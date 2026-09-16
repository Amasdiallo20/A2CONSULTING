<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->ofType('blog')->orderBy('order')->orderBy('name')->get();

        $posts = BlogPost::with(['author', 'category'])
            ->published()
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
            })
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('pages.blog', compact('posts', 'categories'));
    }

    public function show($id)
    {
        $post = BlogPost::with(['author', 'category'])->published()->findOrFail($id);
        $recentPosts = BlogPost::published()->where('id', '!=', $post->id)->latest('published_at')->take(4)->get();

        return view('pages.blog-single', compact('post', 'recentPosts'));
    }
}
