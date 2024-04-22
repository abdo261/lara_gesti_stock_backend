<?php namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'EPC' => 'required|string|unique:products|max:255',
            'title' => 'required|string|unique:products|max:255',
            'price' => 'numeric',
            'stock' => 'integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation rules
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        if ($validateData->fails()) {
            return response()->json($validateData->errors());
        }

        $productData = $request->except('image');
        $product = Product::create($productData);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $product->id . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/product', $imageName); 
            $product->image = $imageName;
            $product->save();
        }
        if ($request->has('categories')) {
            $product->categories()->attach($request->categories);
        }

        return response()->json($product, 201);
    }

    /**
     * Update the specified resource in storage.
     */
 /**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $validateData = Validator::make($request->all(), [
        'EPC' => 'string|unique:products|max:255',
        'title' => 'string|unique:products|max:255',
        'price' => 'numeric',
        'stock' => 'integer',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', 
        'categories' => 'array',
        'categories.*' => 'exists:categories,id',
    ]);

    if ($validateData->fails()) {
        return response()->json($validateData->errors());
    }

    $product = Product::find($id);

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    $productData = $request->except('image');
    $product->update($productData);


if ($request->hasFile('image')) {
    $image = $request->file('image');
    $imageName = $product->id . '.' . $image->getClientOriginalExtension();

    if ($product->image) {
        Storage::delete('public/images/product/' . $product->image);
    }

    $image->storeAs('public/images/product', $imageName); 
    $product->image = $imageName;
    $product->save();
}

    if ($request->has('categories')) {
        $product->categories()->sync($request->categories);
    }

    return response()->json($product, 200);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Delete image if exists
        if ($product->image) {
            $imagePath = public_path('images/product/') . $product->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->categories()->detach(); // Detach all categories associated with the product
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
