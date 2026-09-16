<?php

namespace App\Services;

use App\Models\Course;
use App\Models\ShopProduct;
use Illuminate\Support\Facades\Session;

class Cart
{
    public const SESSION_KEY = 'cart';

    public static function items(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public static function count(): int
    {
        return collect(self::items())->sum('quantity');
    }

    public static function total(): float
    {
        return (float) collect(self::items())->sum(fn ($item) => $item['unit_price'] * $item['quantity']);
    }

    public static function add(string $type, int $id, int $quantity = 1): string
    {
        $quantity = max(1, $quantity);
        $resolved = self::resolve($type, $id);
        $items = self::items();
        $key = $type . ':' . $id;

        if (isset($items[$key])) {
            $items[$key]['quantity'] += $quantity;
        } else {
            $items[$key] = array_merge($resolved, ['quantity' => $quantity]);
        }

        if ($type === 'product') {
            $stock = (int) ($resolved['stock'] ?? 0);
            if ($items[$key]['quantity'] > $stock) {
                $items[$key]['quantity'] = $stock;
            }
        }

        Session::put(self::SESSION_KEY, $items);

        return $resolved['title'];
    }

    public static function update(string $key, int $quantity): void
    {
        $items = self::items();
        if (! isset($items[$key])) {
            return;
        }

        if ($quantity < 1) {
            unset($items[$key]);
        } else {
            if ($items[$key]['type'] === 'product') {
                $quantity = min($quantity, (int) $items[$key]['stock']);
            }
            $items[$key]['quantity'] = $quantity;
        }

        Session::put(self::SESSION_KEY, $items);
    }

    public static function remove(string $key): void
    {
        $items = self::items();
        unset($items[$key]);
        Session::put(self::SESSION_KEY, $items);
    }

    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    private static function resolve(string $type, int $id): array
    {
        if ($type === 'course') {
            $course = Course::active()->findOrFail($id);

            return [
                'key' => 'course:' . $course->id,
                'type' => 'course',
                'id' => $course->id,
                'title' => $course->title,
                'image' => $course->image,
                'unit_price' => (float) (($course->price_type === 'free') ? 0 : $course->price),
                'stock' => null,
            ];
        }

        $product = ShopProduct::active()->findOrFail($id);
        if ($product->stock_quantity < 1) {
            throw new \RuntimeException('Ce produit est en rupture de stock.');
        }

        return [
            'key' => 'product:' . $product->id,
            'type' => 'product',
            'id' => $product->id,
            'title' => $product->title,
            'image' => $product->image,
            'unit_price' => (float) ($product->sale_price ?: $product->price),
            'stock' => $product->stock_quantity,
        ];
    }
}
