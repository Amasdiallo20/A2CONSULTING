<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Teacher;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Schema;

class AboutController extends Controller
{
    public function index()
    {
        $site = SiteSetting::current();
        $services = Service::active()->ordered()->take(6)->get();
        $teachers = Teacher::active()->latest()->take(4)->get();
        $partners = Schema::hasTable('partners')
            ? Partner::active()->ordered()->get()
            : collect();
        $testimonials = Schema::hasTable('testimonials')
            ? Testimonial::active()->ordered()->take(6)->get()
            : collect();

        return view('pages.about', compact('site', 'services', 'teachers', 'partners', 'testimonials'));
    }
}
