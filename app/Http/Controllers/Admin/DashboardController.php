<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\ShopProduct;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'courses' => Course::count(),
            'active_courses' => Course::active()->count(),
            'registrations' => CourseRegistration::count(),
            'pending_registrations' => CourseRegistration::where('status', 'pending')->count(),
            'blog_posts' => BlogPost::count(),
            'published_posts' => BlogPost::where('is_published', true)->count(),
            'shop_products' => ShopProduct::count(),
            'active_products' => ShopProduct::where('is_active', true)->count(),
            'events' => \App\Models\Event::count(),
            'services' => \App\Models\Service::count(),
            'teachers' => \App\Models\Teacher::count(),
            'unread_messages' => ContactMessage::query()->where('is_read', false)->count(),
            'messages' => ContactMessage::count(),
        ];

        $recentRegistrations = CourseRegistration::with('course')
            ->latest()
            ->take(5)
            ->get();

        $recentMessages = ContactMessage::query()->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'recentMessages'));
    }
}
