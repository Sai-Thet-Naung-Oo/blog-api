<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Gate;

class ArticleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }

    public function index(){

        $data = Article::latest()->paginate(5);
            
        return view('articles/index', ['articles'=>$data] );
    }

    public function detail($id){
        $data = Article::find($id);
         return view('articles.detail', [
         'article' => $data
         ]);
    }

    public function delete($id)
    {
      $article = Article::find($id);

      if(Gate::denies('article-delete', $article) ){
        return back()->with('info', 'Unauthorize'); 
        }

      $article->delete();
      return redirect('/articles')->with('info', 'Article deleted');
    }

    public function add()
    {
     $data =Category::all();
     return view('articles.add', [
     'categories' => $data
     ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
            ]);
            if($validator->fails()) {
            return back()->withErrors($validator);
            }

     $article = new Article;
     $article->title = request()->title;
     $article->body = request()->body;
     $article->user_id=auth()->user()->id;
     $article->category_id = request()->category_id;
     $article->save();
     return redirect('/articles');
    }

    

}
