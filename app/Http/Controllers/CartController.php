<?php

namespace App\Http\Controllers;

use App\Services\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('pages.cart', [
            'items' => Cart::items(),
            'total' => Cart::total(),
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:product,course',
            'id' => 'required|integer',
            'quantity' => 'nullable|integer|min:1|max:20',
        ]);

        try {
            $title = Cart::add(
                $validated['type'],
                (int) $validated['id'],
                (int) ($validated['quantity'] ?? 1)
            );
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', $title . ' a été ajouté au panier.');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
            'quantity' => 'required|integer|min:0|max:20',
        ]);

        Cart::update($validated['key'], (int) $validated['quantity']);

        return back()->with('success', 'Panier mis à jour.');
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
        ]);

        Cart::remove($validated['key']);

        return back()->with('success', 'Article retiré du panier.');
    }
}
