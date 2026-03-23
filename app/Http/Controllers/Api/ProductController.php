<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');

        $query = Product::query()
            ->select('id', 'title', 'slug', 'main_image')
            ->where('status', true);

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $products = $query->latest()->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'main_image' => r2_url($product->main_image),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function show($slug)
    {
        $product = Product::with([
            'category',
            'sizes',
            'faqs'
        ])->where('slug', $slug)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'category' => $product->category?->name,
                'category_products' => \App\Models\Product::where('category_id', $product->category_id)
                    ->where('status', true)
                    ->where('id', '!=', $product->id)
                    ->select('id', 'title', 'slug')
                    ->get(),
                'description' => $product->description,
                'main_image' => r2_url($product->main_image),
                'gallery' => collect($product->gallery ?? [])->map(fn($img) => r2_url($img)),
                'sizes' => $product->sizes,
                'faqs' => $product->faqs,
                'seo' => [
                    'meta_title' => $product->meta_title,
                    'meta_description' => $product->meta_description,
                    'meta_keywords' => $product->meta_keywords,
                ]
            ]
        ]);
    }

    public function subcategories(Request $request)
    {
        $categorySlug = $request->query('category');

        $category = Category::where('slug', $categorySlug)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $subcategories = Category::with(['products' => function ($query) {
            $query->where('status', true);
        }])
            ->where('parent_id', $category->id)
            ->get()
            ->map(function ($subcategory) {

                $subcategory->products->map(function ($product) {

                    if ($product->main_image) {
                        $product->main_image = r2_url($product->main_image);
                    }

                    return $product;
                });

                return $subcategory;
            });

        return response()->json($subcategories);
    }
}
