<?php

namespace App\Http\Controllers;

use App\Http\Requests\Banner\BannerRequest;
use Illuminate\Http\Request;
use App\Banner;
use Illuminate\Filesystem\Filesystem;


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

    public function add(BannerRequest $request)
    {
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



    public function update(Request $request, $id)
    {
        if ($request->image == "undefined") {
            $article = Banner::findOrFail($id);
            if ($article) {
                $data = $request->only(['description', 'title']);
                $article->update($data);
            }
            return response($article, 202);
        } else {
            $article = Banner::findOrFail($id);
            if ($article) {
                $image_path = '/images/banners/' . $article->id . '/' . $article->image;
                if (file_exists(public_path($image_path))) {
                    unlink(public_path($image_path));
                }
                $data = $request->only(['description', 'title', 'image']);
                $article->update($data);
                $path = $request->image->store("{$article->id}", 'banner');
                $name = explode('/', $path)[1];
                $article->image = $name;
                $article->save();
            }
            return response($article, 202);
        }
    }

    public function delete($id)
    {
        $banner =  Banner::findOrFail($id);
        if ($banner) {
            $image_path = '/images/banners/' . $banner->id;
            if (is_dir(public_path($image_path))) {
                $file = new Filesystem;
                $file->cleanDirectory(public_path($image_path));
                rmdir(public_path($image_path));
            }
            $banner->delete();
            return response(['مقاله مورد نظر پاک شد'], 200);
        } else {
            return response(['رکورد مورد نظر یافت نشد'], 404);
        }
    }

}
