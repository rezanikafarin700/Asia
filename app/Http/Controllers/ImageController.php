<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

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


}
