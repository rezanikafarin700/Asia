<?php

namespace App\Http\Controllers;

use App\DemoImage;

use App\Product;
use Illuminate\Http\Request;
use App\Demo;

class DemoController extends Controller
{
    public function index()
    {
        $demos = Product::all();
        return $demos;
    }
    public function show($id)
    {
        $demo = Product::findOrFail($id);
        return $demo;
    }

    public function createImage(Request $request)
    {
        if ($request->hasFile('images')) {
            dd($request->images);
            $images = request()->file('images');
            foreach ($images as $img) {
                $image = new DemoImage();
                $path = $img->store("{$request->demoId}",'demo');
                $name = explode('/', $path)[1];
                    $image->name = $name;
                    $image->demoId = $request->demoId;
                    $image->save();
                }
            }
        }



    public function add(Request $request)
    {
        $p = new Demo();
        $p->title = $request->title; // $p->catId = $request->input('catId');      <- روش درست تر
        $p->description = $request->description;
        $p->save();
//        dd($request->images);
        if ($request->hasFile('images')) {
            $i = 0;
            $images = request()->file('images');
            foreach ($images as $img) {
                $image = new DemoImage();
                $path = $img->store("{$p->id}",'demo');
                $name = explode('/', $path)[1];
                if ($i === 0) {
                    $p->image = $name;
                    $p->save();
                } else {
                    $image->name = $name;
                    $image->demoId = $p->id;
                    $image->save();
                }
                $i++;
            }
        }
        return redirect()->action('DemoController@add')->with('insert', true);
    }

}
