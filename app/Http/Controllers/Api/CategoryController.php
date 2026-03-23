<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', true)
            ->with(['products' => function ($query) {
                $query->where('status', true)
                    ->latest()
                    ->select('id', 'title', 'slug', 'main_image', 'category_id');
            }])
            ->first();

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $category->name,
                'slug' => $category->slug,
                'title' => $category->title,
                'subtitle' => $category->subtitle,
                'overview' => $category->overview,
                'gallery' => collect($category->gallery ?? [])->map(fn($img) => r2_url($img)),
                'collections_title' => $category->collections_title ?? "Collections",
                'collections_description' => $category->collections_description,
                'banner_image' => r2_url($category->banner_image),
                'specs' => $category->specs ?? [],
                'faqs' => $category->faqs ?? [],
                'products' => $category->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'slug' => $product->slug,
                        'main_image' => r2_url($product->main_image),
                    ];
                }),
                'brochures' => [
                    'project_book' => [
                        'image' => isset($category->brochures['project_book']['image'])
                            ? r2_url($category->brochures['project_book']['image'])
                            : null,
                        'file' => isset($category->brochures['project_book']['file'])
                            ? r2_url($category->brochures['project_book']['file'])
                            : null,
                    ],

                    'range' => [
                        'image' => isset($category->brochures['range']['image'])
                            ? r2_url($category->brochures['range']['image'])
                            : null,
                        'file' => isset($category->brochures['range']['file'])
                            ? r2_url($category->brochures['range']['file'])
                            : null,
                    ],
                ],
            ]
        ]);
    }
}
