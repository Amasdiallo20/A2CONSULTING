<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Teacher;

class AboutController extends Controller
{
    public function index()
    {
        $site = SiteSetting::current();
        $services = Service::active()->ordered()->take(6)->get();
        $teachers = Teacher::active()->latest()->take(4)->get();

        return view('pages.about', compact('site', 'services', 'teachers'));
    }
}
