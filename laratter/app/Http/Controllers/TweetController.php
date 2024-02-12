<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tweets = Tweet::latest()->get();
        $user = auth()->user();
        return view('tweets.index', compact('tweets', 'user'));
        // コードレビューのためのコメント
        // このコードは、データベースから最新のツイート全てを取得し、それをビューに渡しています。
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //バリデーションはRequestクラスに作成する
        $request->validate([
            'tweet' => 'required|max:255',
        ]);

        $request->user()->tweets()->create($request->only('tweet'));
        // このコードは、ユーザーが入力したツイートをデータベースに保存しています。
        //アロー関数を使ってuser()でログインしているユーザーを取得し、そのユーザーに紐づいたツイートを作成しています。
        //only()メソッドは、指定したキーのみを含む配列を返します。
        //only()メソッドがない場合、全てのリクエストデータが保存されてしまうため、セキュリティ上の問題が発生します。

        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        $request->validate([
            'tweet' => 'required|max:255',
        ]);

        $tweet->update($request->only('tweet'));
        return redirect()->route('tweets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->delete();
        return redirect()->route('tweets.index');
    }
}
