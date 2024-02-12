<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

class TweetLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Tweet $tweet)
    {
        $tweet->liked()->attach(auth()->id());
        return back();
        // このコードは、ユーザーがツイートをいいねすると、そのツイートとユーザーの関連をデータベースに保存しています。
        // attach()メソッドは、中間テーブルにレコードを挿入します。
        // この場合、ツイートとユーザーの関連を保存しています。
        // back()関数は、直前のページにリダイレクトします。
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    // 引数にTweetモデルを受け取る理由は、ツイートのいいねを解除するためです。
    //この引数は、ルーティングで指定した{tweet}パラメータに対応しています。
    {
        $tweet->liked()->detach(auth()->id());
        return back();
        // このコードは、ユーザーがツイートのいいねを解除すると、そのツイートとユーザーの関連をデータベースから削除しています。
        // detach()メソッドは、中間テーブルからレコードを削除します。
        // この場合、ツイートとユーザーの関連を削除しています。
        // back()関数は、直前のページにリダイレクトします。
    }
}
