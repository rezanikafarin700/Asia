<?php

namespace App\Http\Controllers;

use App\Image;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Database\Eloquent\Builder;

class ImageController extends Controller
{
    public function index($productId)
    {
        $images = Image::where('productId', $productId)->get();
        return $images;
    }

    public function create(Request $request)
    {
        if ($request->hasFile('images')) {
            $allFiles = request()->file('images');
            foreach ($allFiles as $img) {
                $image = new Image();
                $path = $img->store("{$request->productId}");
                $name= explode('/', $path)[1];
                $image->name = $name;
                $image->productId = $request->productId;
                $image->save();
            }
        }
    }

    public function show($id)
    {
        $images = Image::where('productId',$id)->get();
        return response()->json($images);
    }


}
