<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ShopProduct;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::active()->ofType('shop')->orderBy('order')->orderBy('name')->get();

        $products = ShopProduct::with('category')
            ->where('is_active', true)
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($categoryQuery) use ($request) {
                    $categoryQuery->where('slug', $request->category)->where('type', 'shop');
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pages.shop', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = ShopProduct::with('category')->where('is_active', true)->findOrFail($id);

        return view('pages.shop-single', compact('product'));
    }
}
