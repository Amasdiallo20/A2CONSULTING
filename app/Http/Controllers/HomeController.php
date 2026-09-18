<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Course;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Service;
use App\Models\SoftwareProduct;
use App\Models\ShopProduct;
use App\Models\SiteSetting;
use App\Models\Teacher;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $site = SiteSetting::current();
        $categories = Category::active()->ofType('course')->withCount('courses')->orderBy('order')->take(8)->get();
        $events = Event::active()->upcoming()->latest('event_date')->take(3)->get();
        $courses = Course::with('teacher')->withRatingStats()->active()->featured()->latest()->take(8)->get();
        if ($courses->isEmpty()) {
            $courses = Course::with('teacher')->withRatingStats()->active()->latest()->take(8)->get();
        }
        $teachers = Teacher::active()->featured()->latest()->take(4)->get();
        if ($teachers->isEmpty()) {
            $teachers = Teacher::active()->latest()->take(4)->get();
        }
        $products = ShopProduct::with('category')->active()->featured()->latest()->take(4)->get();
        if ($products->isEmpty()) {
            $products = ShopProduct::with('category')->active()->latest()->take(4)->get();
        }
        $posts = BlogPost::with('category')->published()->latest('published_at')->take(4)->get();
        $services = Service::active()->featured()->ordered()->take(2)->get();
        if ($services->isEmpty()) {
            $services = Service::active()->ordered()->take(2)->get();
        }
        $partners = Schema::hasTable('partners')
            ? Partner::active()->ordered()->get()
            : collect();
        $testimonials = Schema::hasTable('testimonials')
            ? Testimonial::active()->ordered()->take(6)->get()
            : collect();
        $softwareProducts = Schema::hasTable('software_products')
            ? SoftwareProduct::active()->ordered()->get()
            : collect();

        return view('pages.home', compact(
            'site', 'categories', 'events', 'courses', 'teachers', 'products', 'posts', 'services', 'partners', 'testimonials', 'softwareProducts'
        ));
    }
}
