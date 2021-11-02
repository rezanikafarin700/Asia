<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\Banner\BannerRequest;
use Illuminate\Http\Request;

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

}
