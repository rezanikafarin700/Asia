<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Image;
use App\Product;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;



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


    public function add(Request $request)
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
                $path = $img->store("{$p->id}", 'product');
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

    public function update(Request $request, $id)
    {
        if ($request->hasAny('deletedOfOldImages')) {
            $deleted = $request->input('deletedOfOldImages');
            foreach ($deleted as $d) {
                $image_path = '/images/products/' . $id . '/' . $d;
                if (file_exists(public_path($image_path))) {
                    unlink(public_path($image_path));
                }
                Image::where('productId', $id)->where('name', $d)->delete();
            }
        }

        if ($request->mainImage == "undefined") {
            $product = Product::findOrFail($id);
            if ($product) {
                $data = $request->only([
                    'name',
                    'model',
                    'size',
                    'price',
                    'discount',
                    'code',
                    'material',
                    'description',
                ]);
                $product->update($data);
            }
            if ($request->hasFile('images')) {
                $images = request()->file('images');
                foreach ($images as $img) {
                    $image = new Image();
                    $path = $img->store("{$product->id}", 'product');
                    $name = explode('/', $path)[1];
                    $image->name = $name;
                    $image->productId = $product->id;
                    $image->save();
                }
            }
            return response($product, 202);
        } else {
            $product = Product::findOrFail($id);
            if ($product) {
                $image_path = '/images/products/' . $product->id . '/' . $product->image;
                if (file_exists(public_path($image_path))) {
                    unlink(public_path($image_path));
                }
                $data = $request->only([
                    'name',
                    'model',
                    'size',
                    'price',
                    'discount',
                    'code',
                    'material',
                    'image',
                    'description',
                ]);
                $product->update($data);
                $path = $request->mainImage->store("{$product->id}", 'product');
                $name = explode('/', $path)[1];
                $product->image = $name;
                $product->save();
            }
            if ($request->hasFile('images')) {
                $images = request()->file('images');
                foreach ($images as $img) {
                    $image = new Image();
                    $path = $img->store("{$product->id}", 'product');
                    $name = explode('/', $path)[1];
                    $image->name = $name;
                    $image->productId = $product->id;
                    $image->save();
                }
            }

            return response($product, 202);
        }
    }

    public function delete($id)
    {
        $product =  Product::findOrFail($id);
        if ($product) {
            $image_path = '/images/products/' . $product->id;
            if (is_dir(public_path($image_path))) {
                $file = new Filesystem;
                $file->cleanDirectory(public_path($image_path));
                rmdir(public_path($image_path));
            }
            $product->delete();
            return response(['مقاله مورد نظر پاک شد'], 200);
        } else {
            return response(['رکورد مورد نظر یافت نشد'], 404);
        }
    }
}
