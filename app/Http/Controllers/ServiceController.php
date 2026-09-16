<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->paginate(12);

        return view('pages.services', compact('services'));
    }

    public function show($id)
    {
        $service = Service::active()->findOrFail($id);

        return view('pages.services-single', compact('service'));
    }
}
