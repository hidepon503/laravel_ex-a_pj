<?php

namespace Tests\Feature;
use App\Models\Tweet;
use App\Models\User;

it('displays tweets', function(){
    //ユーザーを作成
    $user = User::factory()->create();

    //ユーザーを認証
    $this->actingAs($user);

    //ツイートを作成
    $tweet = Tweet::factory()->create();

    //GETリクエスト
    $response = $this->get('/tweets');
    // なぜGETリクエストを送信しているかというと、ツイート一覧を表示するためです。

    // レスポンスを検証
    $response->assertStatus(200)
        ->assertSee($tweet->tweet)
        ->assertSee($tweet->user->name);
    // このコードは、ツイート一覧ページにアクセスし、ツイートの内容と投稿者名、作成日時と更新一時が表示されているかを検証しています。
    //assertStatus(200)は、リクエストが成功したかどうかを検証します。200は成功を意味します。
    //assertSee()は、指定したテキストがレスポンスに含まれているかを検証します。 
});

//作成画面のテスト
it('displays create tweet form', function(){
    //ユーザーを作成
    $user = User::factory()->create();

    //ユーザーを認証
    $this->actingAs($user);

    //GETリクエスト
    $response = $this->get('/tweets/create');

    // レスポンスを検証
    $response->assertStatus(200);
    
    // このコードは、ツイート作成ページにアクセスし、ツイート作成フォームが表示されているかを検証しています。
    //assertSee()は、指定したテキストがレスポンスに含まれているかを検証します。 
});

// 作成処理のテスト
it('allows authenticated user to create tweet', function(){
    //ユーザーを作成
    $user = User::factory()->create();

    //ユーザーを認証
    $this->actingAs($user);

    //Tweet作成
    $tweetData = ['tweet' => 'This is a test tweet.']; 

    //POSTリクエスト
    $response = $this->post('/tweets', $tweetData);

    // レスポンスを検証
    $response->assertStatus(302);
    $response->assertRedirect('/tweets');
    // このコードは、ツイートを作成し、その後ツイート一覧ページにリダイレクトされているかを検証しています。
    //assertStatus(302)は、リクエストがリダイレクトされたかどうかを検証します。302はリダイレクトを意味します。
    //assertRedirect()は、指定したURLにリダイレクトされているかを検証します。
});


//詳細画面のテスト
it('display a tweet', function(){
    //ユーザーを作成
    $user = User::factory()->create();

    //ユーザーを認証
    $this->actingAs($user);

    //ツイートを作成
    $tweet = Tweet::factory()->create();

    //GETリクエスト
    $response = $this->get('/tweets/' . $tweet->id);

    // レスポンスを検証
    $response->assertStatus(200);
    $response->assertSee($tweet->created_at->format('Y-m-d H:i'));
    $response->assertSee($tweet->updated_at->format('Y-m-d H:i'));
    $response->assertSee($tweet->tweet);
    $response->assertSee($tweet->user->name);
    // このコードは、ツイート詳細ページにアクセスし、ツイートの内容と投稿者名、作成日時と更新一時が表示されているかを検証しています。
    //assertStatus(200)は、リクエストが成功したかどうかを検証します。200は成功を意味します。
    //assertSee()は、指定したテキストがレスポンスに含まれているかを検証します。 
});

//編集画面のテスト
it('displays edit tweet page', function(){
    //ユーザーを作成
    $user = User::factory()->create();

    //ユーザーを認証
    $this->actingAs($user);

    //ツイートを作成
    $tweet = Tweet::factory()->create(['user_id' => $user->id]);

    //編集ページにアクセス
    $response = $this->get('/tweets/' . $tweet->id . '/edit');

    //GETリクエスト
    $response = $this->get('/tweets/' . $tweet->id . '/edit');

    //ステータスコードを検証
    $response->assertStatus(200);
    // viewにtweetが含まれているか検証
    $response->assertSee($tweet->tweet); 
});

// tests/Feature/TweetTest.php

// 更新処理のテスト
it('allows a user to update their tweet', function () {
  // ユーザを作成
  $user = User::factory()->create();

  // ユーザを認証
  $this->actingAs($user);

  // Tweetを作成
  $tweet = Tweet::factory()->create(['user_id' => $user->id]);

  // 更新データ
  $updatedData = ['tweet' => 'Updated tweet content.'];

  // PUTリクエスト
  $response = $this->put("/tweets/{$tweet->id}", $updatedData);

  // データベースが更新されたことを確認
  $this->assertDatabaseHas('tweets', $updatedData);

  // レスポンスの確認
  $response->assertStatus(302);
  $response->assertRedirect("/tweets");
});


// ツイートの削除処理のテスト
it('allows a user to delete tweet', function(){
    //ユーザーを作成
    $user = User::factory()->create();

    //ユーザーを認証
    $this->actingAs($user);

    //ツイートを作成
    $tweet = Tweet::factory()->create(['user_id' => $user->id]);

    //DELETEリクエスト
    $response = $this->delete('/tweets/' . $tweet->id);

    //DBが削除されたか検証
    $this->assertDatabaseMissing('tweets', ['id' => $tweet->id]);

    // レスポンスを検証
    $response->assertStatus(302);
    $response->assertRedirect('/tweets');
    // このコードは、ツイートを削除し、その後ツイート一覧ページにリダイレクトされているかを検証しています。
    //assertStatus(302)は、リクエストがリダイレクトされたかどうかを検証します。302はリダイレクトを意味します。
    //assertRedirect()は、指定したURLにリダイレクトされているかを検証します。
});