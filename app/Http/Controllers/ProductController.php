<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    private $username;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('images')->paginate();

        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        Log::channel('myLog')->info('PRODUCT Store', ["Username" => $request->user()->email, "Product Info" => ["id" => $product->id, "name" => $product->name], "ORIGIN" => $_SERVER['REMOTE_ADDR']]);

        return redirect()->route('products.index')->with('success', 'Produto inserido com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load('images');

        return Inertia::render('Products/Edit', [
            'product' => $product
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        Log::channel('myLog')->info('PRODUCT Update', ["Username" => $request->user()->email, "Product Info" => ["id" => $product->id, "name" => $product->name], "ORIGIN" => $_SERVER['REMOTE_ADDR']]);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        Log::channel('myLog')->info('PRODUCT Delete', ["Username" => $request->user()->email, "Product Info" => ["id" => $product->id, "name" => $product->name], "ORIGIN" => $_SERVER['REMOTE_ADDR']]);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto inserido com sucesso!');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::query()->find($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()->back();
    }
}
