<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Image;
use App\Product;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return $products;
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $product;
    }


    public function add(ProductRequest $request)
    {

        $p = new Product();
        $p->name = $request->name; // $p->catId = $request->input('catId');      <- روش درست تر
        $p->model = $request->model;
        $p->size = $request->size;
        $p->price = $request->price;
        $p->discount = $request->discount;
        $p->code = $request->code;
        $p->material = $request->material;
        $p->description = $request->description;
        $p->save();

        if ($request->hasFile('images')) {
            $i = 0;
            $images = request()->file('images');
            foreach ($images as $img) {
                $image = new Image();
                $path = $img->store("{$p->id}",'product');
                $name = explode('/', $path)[1];
                if ($i === 0) {
                    $p->image = $name;
                    $p->save();
                } else {
                    $image->name = $name;
                    $image->productId = $p->id;
                    $image->save();
                }
                $i++;
            }
        }
        return redirect()->action('ProductController@add')->with('insert', true);
    }
}
