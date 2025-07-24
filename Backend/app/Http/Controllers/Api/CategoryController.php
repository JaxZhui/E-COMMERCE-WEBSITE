<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();
        
        // Add full image URLs
        $categories->transform(function ($category) {
            if ($category->image) {
                $category->image_url = asset('storage/' . $category->image);
            }
            return $category;
        });

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function show($id)
    {
        $category = Category::with(['products' => function($query) {
            $query->where('is_active', true);
        }])->find($id);
        
        if (!$category || !$category->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        // Add full image URLs
        if ($category->image) {
            $category->image_url = asset('storage/' . $category->image);
        }

        $category->products->transform(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image);
            }
            return $product;
        });

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }
}
