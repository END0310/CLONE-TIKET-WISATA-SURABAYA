<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    private function googleConfig(): array
    {
        return [
            'clientId' => (string) env('google.clientId'),
            'clientSecret' => (string) env('google.clientSecret'),
            'redirectUri' => (string) env('google.redirectUri', base_url('/login/google/callback')),
        ];
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(session()->get('userRole') === 'admin' ? '/admin/dashboard' : '/user/dashboard');
        }

        return view('auth/login', ['title' => 'Login Akun']);
    }

    public function process()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = (new UserModel())->where('email', $email)->first();

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->set([
            'isLoggedIn' => true,
            'userId' => $user['id'],
            'userName' => $user['name'],
            'userEmail' => $user['email'],
            'userRole' => $user['role'],
        ]);

        return redirect()->to($user['role'] === 'admin' ? '/admin/dashboard' : '/user/dashboard');
    }

    public function google()
    {
        $config = $this->googleConfig();

        if ($config['clientId'] === '' || $config['clientSecret'] === '') {
            return redirect()->to('/login')->with('error', 'Google Login belum dikonfigurasi. Isi google.clientId dan google.clientSecret di file .env.');
        }

        $state = bin2hex(random_bytes(16));
        session()->set('google_oauth_state', $state);

        $params = http_build_query([
            'client_id' => $config['clientId'],
            'redirect_uri' => $config['redirectUri'],
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'online',
            'prompt' => 'select_account',
        ]);

        return redirect()->to('https://accounts.google.com/o/oauth2/v2/auth?' . $params);
    }

    public function googleCallback()
    {
        $state = $this->request->getGet('state');
        $code = $this->request->getGet('code');

        if (! $code || ! $state || $state !== session()->get('google_oauth_state')) {
            return redirect()->to('/login')->with('error', 'Login Google tidak valid atau dibatalkan.');
        }

        session()->remove('google_oauth_state');
        $config = $this->googleConfig();
        $token = $this->requestGoogleToken($config, $code);

        if (empty($token['access_token'])) {
            return redirect()->to('/login')->with('error', 'Gagal mengambil token Google. Periksa konfigurasi OAuth.');
        }

        $profile = $this->requestGoogleProfile($token['access_token']);

        if (empty($profile['email'])) {
            return redirect()->to('/login')->with('error', 'Gagal mengambil data email Google.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $profile['email'])->first();
        $userData = [
            'name' => $profile['name'] ?? $profile['email'],
            'email' => $profile['email'],
            'google_id' => $profile['sub'] ?? null,
            'avatar' => $profile['picture'] ?? null,
        ];

        if ($user) {
            $userModel->update($user['id'], $userData);
            $user = $userModel->find($user['id']);
        } else {
            $userData['password'] = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
            $userData['role'] = 'user';
            $userId = $userModel->insert($userData);
            $user = $userModel->find($userId);
        }

        session()->set([
            'isLoggedIn' => true,
            'userId' => $user['id'],
            'userName' => $user['name'],
            'userEmail' => $user['email'],
            'userRole' => $user['role'],
        ]);

        return redirect()->to($user['role'] === 'admin' ? '/admin/dashboard' : '/user/dashboard');
    }

    private function requestGoogleToken(array $config, string $code): array
    {
        $client = \Config\Services::curlrequest();
        $response = $client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'code' => $code,
                'client_id' => $config['clientId'],
                'client_secret' => $config['clientSecret'],
                'redirect_uri' => $config['redirectUri'],
                'grant_type' => 'authorization_code',
            ],
            'http_errors' => false,
        ]);

        return json_decode($response->getBody(), true) ?: [];
    }

    private function requestGoogleProfile(string $accessToken): array
    {
        $client = \Config\Services::curlrequest();
        $response = $client->get('https://www.googleapis.com/oauth2/v3/userinfo', [
            'headers' => ['Authorization' => 'Bearer ' . $accessToken],
            'http_errors' => false,
        ]);

        return json_decode($response->getBody(), true) ?: [];
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
