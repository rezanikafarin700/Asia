<?php

namespace App\Http\Controllers;

use App\Footer;
use App\Http\Requests\Banner\BannerRequest;
use App\Http\Requests\Footer\FooterRequest;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class FooterController extends Controller
{
    public function index()
    {
        $articles = Footer::all();
        return $articles;
    }

    public function show($id)
    {
        $articles = Footer::findOrFail($id);
        return $articles;
    }

    public function add(BannerRequest $request)
    {
        $article = new Footer();
        $article->title = $request->title; // $p->catId = $request->input('catId');      <- روش درست تر
        $article->description = $request->description;
        $article->save();

        $path = $request->image->store("{$article->id}", 'footer');
        $name = explode('/', $path)[1];
        $article->image = $name;
        $article->save();
        return response()->json($article, 200);
    }

    public function update(BannerRequest $request, $id)
    {
        if ($request->image == "undefined") {
            $article = Footer::findOrFail($id);
            if ($article) {
                $data = $request->only(['description', 'title']);
                $article->update($data);
            }
            return response($article, 202);
        } else {
            $article = Footer::findOrFail($id);
            if ($article) {
                $image_path = '/images/footers/' . $article->id . '/' . $article->image;
                if (file_exists(public_path($image_path))) {
                    unlink(public_path($image_path));
                }
                $data = $request->only(['description', 'title', 'image']);
                $article->update($data);
                $path = $request->image->store("{$article->id}", 'footer');
                $name = explode('/', $path)[1];
                $article->image = $name;
                $article->save();
            }
            return response($article, 202);
        }
    }

    public function delete($id)
    {
        $article =  Footer::findOrFail($id);
        if ($article) {
            $image_path = '/images/footers/' . $article->id;
            if (is_dir(public_path($image_path))) {
                $file = new Filesystem;
                $file->cleanDirectory(public_path($image_path));
                rmdir(public_path($image_path));
            }
            $article->delete();
            return response(['مقاله مورد نظر پاک شد'], 200);
        } else {
            return response(['رکورد مورد نظر یافت نشد'], 404);
        }
    }
}
