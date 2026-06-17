<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'store_id'    => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'tag_id'      => 'nullable|integer',
            'status'      => 'nullable|in:active,inactive',
        ]);

        $products = Product::filter($validated)
            ->with(['category:id,name', 'tags:id,name'])
            ->paginate(15);

    return ProductResource::collection($products);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->safe()->except('tag_ids'));

        if ($request->filled('tag_ids')) {
            $product->tags()->sync($request->tag_ids);
        }

        $product->load(['category:id,name', 'tags:id,name']);

      return new ProductResource($product);
    }

    public function show(string $id): JsonResponse
    {
        $product = Product::with(['category:id,name', 'tags:id,name'])
            ->findOrFail($id);

        return response()->json($product);
    }

    public function update(ProductRequest $request, string $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        $product->update($request->safe()->except('tag_ids'));

        if ($request->has('tag_ids')) {
            $product->tags()->sync($request->tag_ids ?? []);
        }

        $product->load(['category:id,name', 'tags:id,name']);

        return response()->json($product);
    }

    public function destroy(string $id): Response
    {
        Product::findOrFail($id)->delete();

        return response()->noContent();
    }
}