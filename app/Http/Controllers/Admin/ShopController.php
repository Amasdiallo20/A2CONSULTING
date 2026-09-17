<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\StoresImages;
use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ShopController extends Controller
{
    use StoresImages;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = ShopProduct::with('category')
            ->latest()
            ->paginate(15);
        
        return view('admin.shop.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->ofType('shop')->get();
        return view('admin.shop.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'author' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:255',
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(fn ($query) => $query->where('type', 'shop')),
            ],
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['image'] = $this->storeImage($request, 'image', 'shop');
        $validated = $this->normalizeShopPrices($validated);

        ShopProduct::create($validated);

        return redirect()->route('admin.shop.index')
            ->with('success', 'Produit créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShopProduct $shop)
    {
        $shop->load('category');
        return view('admin.shop.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopProduct $shop)
    {
        $categories = Category::active()->ofType('shop')->get();
        return view('admin.shop.edit', compact('shop', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShopProduct $shop)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => $this->imageValidationRule(),
            'author' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:255',
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where(fn ($query) => $query->where('type', 'shop')),
            ],
        ]);

        $validated['slug'] = $shop->title === $validated['title']
            ? $shop->slug
            : Str::slug($validated['title']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['image'] = $this->storeImage($request, 'image', 'shop', $shop->image, true);
        $validated = $this->normalizeShopPrices($validated, $shop);

        $shop->fill($validated);
        $shop->save();
        $shop->refresh();

        return redirect()->route('admin.shop.edit', $shop)
            ->with('success', 'Produit enregistré. Le nouveau prix est visible sur le site.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Le champ "Prix" est celui affiché sur le site.
     * Un prix promo n'est conservé que s'il est inférieur et explicitement modifié.
     */
    private function normalizeShopPrices(array $validated, ?ShopProduct $existing = null): array
    {
        $validated['price'] = integer_price($validated['price'] ?? 0);
        $sale = $validated['sale_price'] ?? null;
        if ($sale === '' || $sale === null || integer_price($sale) <= 0 || integer_price($sale) >= $validated['price']) {
            $validated['sale_price'] = null;
        } else {
            $validated['sale_price'] = integer_price($sale);
        }

        if ($existing && $validated['price'] !== integer_price($existing->price)) {
            $incomingSale = integer_price($validated['sale_price'] ?? 0);
            $previousSale = integer_price($existing->sale_price ?? 0);
            if ($incomingSale === $previousSale) {
                $validated['sale_price'] = null;
            }
        }

        return $validated;
    }

    public function destroy(ShopProduct $shop)
    {
        $shop->delete();

        return redirect()->route('admin.shop.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
}
