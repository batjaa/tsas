<?php

namespace App\Http\Controllers;

use App\Helpers\ColorMap;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['images', 'variants']);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->get();

        $categories = Product::select('category')
            ->distinct()
            ->pluck('category');

        return view('pages.products.index', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $request->category,
        ]);
    }

    public function show($id)
    {
        $product = Product::with(['images', 'variants'])->findOrFail($id);

        $relatedProducts = Product::with(['images', 'variants'])
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('pages.products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
