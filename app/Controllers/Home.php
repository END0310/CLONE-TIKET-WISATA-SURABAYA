<?php

namespace App\Controllers;

use App\Models\WebsiteProfileModel;
use App\Models\NavigationMenuModel;
use App\Models\BannerModel;
use App\Models\TourismDestinationModel;
use App\Models\VisitScheduleModel;
use App\Models\TicketTypeModel;
use App\Models\StaticPageModel;
use App\Models\FooterLinkModel;
use App\Models\SocialMediaModel;
use App\Models\ContactInfoModel;

class Home extends BaseController
{
    public function __construct()
    {
        helper(['url']);
    }

    public function index()
    {
        $websiteProfileModel = new WebsiteProfileModel();
        $navigationMenuModel = new NavigationMenuModel();
        $bannerModel = new BannerModel();
        $destinationModel = new TourismDestinationModel();
        $visitScheduleModel = new VisitScheduleModel();
        $ticketTypeModel = new TicketTypeModel();
        $staticPageModel = new StaticPageModel();
        $footerLinkModel = new FooterLinkModel();
        $socialMediaModel = new SocialMediaModel();
        $contactInfoModel = new ContactInfoModel();

        $profile = $websiteProfileModel->first();

        $data = [
            'title' => 'Beranda - Tiket Wisata Surabaya',
            'profile' => $profile,
            'menus' => $navigationMenuModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
            'banners' => $bannerModel->where('is_active', 1)->findAll(),
            'destinations' => $destinationModel->getDestinationsWithCategoryAndPrice(),
            'featuredDestinations' => $destinationModel->getFeaturedDestinations(8),
            'schedules' => $visitScheduleModel->findAll(),
            'ticketTypes' => $ticketTypeModel->where('is_active', 1)->findAll(),
            'staticPages' => $staticPageModel->where('is_active', 1)->findAll(),
            'footerLinks' => $footerLinkModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
            'socialMedia' => $socialMediaModel->where('is_active', 1)->findAll(),
            'contactInfos' => $contactInfoModel->where('is_active', 1)->findAll(),
        ];

        return view('home/index', $data);
    }
}
