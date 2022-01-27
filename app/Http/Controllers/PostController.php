<?php

namespace App\Http\Controllers;
//postモデルを使う宣言
use App\Post;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Storage;

class PostController extends Controller
{
    //
    function index()
    {
        //postsテーブルから全部のデータを取ってくる
        $posts = Post::all();
        // dd($posts);
        // compact('取ってきた全部のデータ');   ビューで表示するための記述
        return view('posts.index',compact('posts'));
    }
    function create()
    {
        return view('posts.create');
    }
    function store(Request $request)
    {
        //    dd($request);
        //$requestに入っている値を、new Postでデータベースに保存するという記述
        $post = new Post;
        //左辺:テーブル、右辺が送られてきた値（formから送られてきたnameが入っている）
        //$post = データベース
        //$post -> title    データベースの各項目のうち,titleカラム
        //$request -> titleのtitleはcreate.blade.phpのnameから来ている
        $post -> title = $request -> title;
        $post -> body = $request -> body;
        $post -> user_id = Auth::id();

        //s3アップロード開始( image というinputタグから送られてきた情報を $imageに格納)
        $image = $request->file('image');
        // バケット䛾`mybucket`フォルダへアップロード
        $path = Storage::disk('s3')->putFile('mybucket', $image, 'public');
        // アップロードした画像䛾フルパスを取得
        // $post->image_path = Storage::disk('s3')->url($path);

        $post -> save();

        return redirect()->route('posts.index');
    }

    // $idはindex.blade.phpから送られたid
    function show($id)
    {   
        // dd($id);
        $post = Post::find($id);

        return view('posts.show',['post'=>$post]);
    }

    function edit($id)
    {   
        // dd($id);
        $post = Post::find($id);

        return view('posts.edit',['post'=>$post]);
    }

    function update(Request $request,$id)
    {   
        // dd($id);
        $post = Post::find($id);

        $post -> title = $request -> title;
        $post -> body = $request -> body;
        $post -> save();

        //s3アップロード開始( image というinputタグから送られてきた情報を $imageに格納)
        $image = $request->file('image');
        // バケット䛾`mybucket`フォルダへアップロード
        $path = Storage::disk('s3')->putFile('shinji-initial', $image, 'public');
        // アップロードした画像䛾フルパスを取得
        $post->image_path = Storage::disk('s3')->url($path);

        return view('posts.show',compact('post'));
    }

    function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
