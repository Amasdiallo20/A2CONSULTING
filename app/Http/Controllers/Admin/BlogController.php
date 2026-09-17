<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    use StoresImages;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::with(['author', 'category'])
            ->latest()
            ->paginate(15);
        
        return view('admin.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->ofType('blog')->get();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = Auth::id();
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');
        
        if ($validated['is_published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $validated['image'] = $this->storeImage($request, 'image', 'blog');

        BlogPost::create($validated);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blog)
    {
        $blog->load(['author', 'category']);
        return view('admin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blog)
    {
        $categories = Category::active()->ofType('blog')->get();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');
        
        if ($validated['is_published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        $validated['image'] = $this->storeImage($request, 'image', 'blog', $blog->image, true);

        $blog->update($validated);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article supprimé avec succès.');
    }
}
