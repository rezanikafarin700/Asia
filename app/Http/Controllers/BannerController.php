<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return $banners;
    }

    public function show($id)
    {
        $banners = Banner::findOrFail($id);
        return $banners;
    }



    public function add(Request $request)
    {
//        dd($request);


        $banner = new Banner();
        $banner->title = $request->title; // $p->catId = $request->input('catId');      <- روش درست تر
        $banner->description = $request->description;
        $banner->save();


        $path = $request->image->store("{$banner->id}", 'banner');

        $name = explode('/', $path)[1];
        $banner->image = $name;
        $banner->save();
        return response()->json($request,200);
    }

}
