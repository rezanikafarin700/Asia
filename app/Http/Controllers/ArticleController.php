<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\Banner\BannerRequest;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;


class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return $articles;
    }

    public function show($id)
    {
        $articles = Article::findOrFail($id);
        return $articles;
    }

    public function add(BannerRequest $request)
    {
        $article = new Article();
        $article->title = $request->title; // $p->catId = $request->input('catId');      <- روش درست تر
        $article->description = $request->description;
        $article->save();

        $path = $request->image->store("{$article->id}", 'article');
        $name = explode('/', $path)[1];
        $article->image = $name;
        $article->save();
        return response()->json($article,200);
    }

    public function update(Request $request, $id)
    {
        if ($request->image == "undefined") {
            $article = Article::findOrFail($id);
            if ($article) {
                $data = $request->only(['description', 'title']);
                $article->update($data);
            }
            return response($article, 202);
        } else {
            $article = Article::findOrFail($id);
            if ($article) {
                $image_path = '/images/articles/' . $article->id . '/' . $article->image;
                if (file_exists(public_path($image_path))) {
                    unlink(public_path($image_path));
                }
                $data = $request->only(['description', 'title', 'image']);
                $article->update($data);
                $path = $request->image->store("{$article->id}", 'article');
                $name = explode('/', $path)[1];
                $article->image = $name;
                $article->save();
            }
            return response($article, 202);
        }
    }

    public function delete($id)
    {
        $article =  Article::findOrFail($id);
        if ($article) {
            $image_path = '/images/articles/' . $article->id;
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
