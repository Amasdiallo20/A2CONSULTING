<?php

namespace App\Http\Controllers;

use App\Models\SoftwareProduct;
use App\Models\SiteSetting;

class SoftwareProductController extends Controller
{
    public function index()
    {
        $products = SoftwareProduct::active()->ordered()->get();
        $site = SiteSetting::current();

        return view('pages.software', compact('products', 'site'));
    }

    public function show(SoftwareProduct $softwareProduct)
    {
        abort_unless($softwareProduct->is_active, 404);

        $others = SoftwareProduct::active()
            ->ordered()
            ->where('id', '!=', $softwareProduct->id)
            ->get();
        $site = SiteSetting::current();

        return view('pages.software-single', [
            'product' => $softwareProduct,
            'others' => $others,
            'site' => $site,
        ]);
    }
}
