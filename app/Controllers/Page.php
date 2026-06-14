<?php

namespace App\Controllers;

use App\Models\FaqModel;

class Page extends BaseController
{
    public function faq()
    {
        return view('pages/faq', $this->layoutData([
            'title' => 'FAQ',
            'faqs' => (new FaqModel())->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll(),
        ]));
    }
}
