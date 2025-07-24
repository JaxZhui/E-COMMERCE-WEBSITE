<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Add full image URLs
        $products->transform(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image);
            }
            return $product;
        });

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);
        
        if (!$product || !$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Add full image URL
        if ($product->image) {
            $product->image_url = asset('storage/' . $product->image);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function getByCategory($categoryId)
    {
        $category = Category::find($categoryId);
        
        if (!$category || !$category->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $products = Product::with('category')
            ->where('category_id', $categoryId)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Add full image URLs
        $products->transform(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image);
            }
            return $product;
        });

        return response()->json([
            'success' => true,
            'data' => $products,
            'category' => $category
        ]);
    }
}
