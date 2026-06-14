<?php

namespace App\Controllers;

use App\Models\WebsiteProfileModel;
use App\Models\NavigationMenuModel;
use App\Models\DestinationCategoryModel;
use App\Models\TourismDestinationModel;
use App\Models\VisitScheduleModel;
use App\Models\TicketTypeModel;
use App\Models\TermsAndConditionsModel;
use App\Models\FooterLinkModel;
use App\Models\SocialMediaModel;
use App\Models\ContactInfoModel;

class Destination extends BaseController
{
    public function __construct()
    {
        helper(['url']);
    }

    private function getLayoutData()
    {
        $websiteProfileModel = new WebsiteProfileModel();
        $navigationMenuModel = new NavigationMenuModel();
        $footerLinkModel = new FooterLinkModel();
        $socialMediaModel = new SocialMediaModel();
        $contactInfoModel = new ContactInfoModel();

        return [
            'profile' => $websiteProfileModel->first(),
            'menus' => $navigationMenuModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
            'footerLinks' => $footerLinkModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
            'socialMedia' => $socialMediaModel->where('is_active', 1)->findAll(),
            'contactInfos' => $contactInfoModel->where('is_active', 1)->findAll(),
        ];
    }

    public function index()
    {
        $destinationModel = new TourismDestinationModel();
        $categoryModel = new DestinationCategoryModel();
        $categoryId = $this->request->getGet('category');

        $data = array_merge($this->getLayoutData(), [
            'title' => 'Daftar Destinasi Wisata',
            'categories' => $categoryModel->where('is_active', 1)->orderBy('name', 'ASC')->findAll(),
            'destinations' => $destinationModel->getDestinationsWithCategoryAndPrice($categoryId),
            'selectedCategory' => $categoryId,
        ]);

        return view('destinations/index', $data);
    }

    public function detail($id)
    {
        $destinationModel = new TourismDestinationModel();
        $visitScheduleModel = new VisitScheduleModel();
        $ticketTypeModel = new TicketTypeModel();
        $termsModel = new TermsAndConditionsModel();

        $destination = $destinationModel->getDestinationDetail($id);

        if (!$destination) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Destinasi tidak ditemukan');
        }

        $data = array_merge($this->getLayoutData(), [
            'title' => $destination['name'],
            'destination' => $destination,
            'schedules' => $visitScheduleModel->where('destination_id', $id)->findAll(),
            'ticketTypes' => $ticketTypeModel->where('destination_id', $id)->where('is_active', 1)->findAll(),
            'terms' => $termsModel->where('destination_id', $id)->orderBy('sort_order', 'ASC')->findAll(),
        ]);

        return view('destinations/detail', $data);
    }
}
