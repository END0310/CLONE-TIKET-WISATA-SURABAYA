<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\WebsiteProfileModel;
use App\Models\NavigationMenuModel;
use App\Models\FooterLinkModel;
use App\Models\SocialMediaModel;
use App\Models\ContactInfoModel;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    protected $helpers = ['url', 'form'];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    protected function layoutData(array $data = []): array
    {
        $profileModel = new WebsiteProfileModel();
        $menuModel = new NavigationMenuModel();
        $footerModel = new FooterLinkModel();
        $socialModel = new SocialMediaModel();
        $contactModel = new ContactInfoModel();

        return array_merge([
            'profile' => $profileModel->first(),
            'menus' => $menuModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
            'footerLinks' => $footerModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
            'socialMedia' => $socialModel->where('is_active', 1)->findAll(),
            'contactInfos' => $contactModel->where('is_active', 1)->findAll(),
        ], $data);
    }

    protected function requireAdmin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (session()->get('userRole') !== 'admin') {
            return redirect()->to('/user/dashboard')->with('error', 'Halaman admin hanya untuk admin.');
        }

        return null;
    }

    protected function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return null;
    }
}
