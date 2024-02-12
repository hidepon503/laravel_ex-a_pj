<?php

use App\Models\Tweet;
use App\Models\User;

//likeのテスト
it('allows authenticated user to like tweet', function(){
    //ユーザーを作成
    $user = User::factory()->create();
    //ツイートを作成
    $tweet = Tweet::factory()->create();

    //ユーザーを認証
    $this->actingAs($user)
        ->post(route('tweets.like', ['tweet' => $tweet->id]))
        ->assertStatus(302);
        // このコードは、ツイートをいいねするために、ユーザーがログインしているかどうかを検証しています。
    
    $this->assertDatabaseHas('tweet_user', [
        'tweet_id' => $tweet->id,
        'user_id' => $user->id
    ]);
    // このコードは、ツイートをいいねしたときに、データベースにいいねが保存されているかを検証しています。
});

//dislikeのテスト
it('allows authenticated user to dislike tweet', function(){
    //ユーザーを作成
    $user = User::factory()->create();
    //ツイートを作成
    $tweet = Tweet::factory()->create();

    //最初にlikeする
    $user->likes()->attach($tweet);

    //ユーザーを認証    
    $this->actingAs($user)
        ->delete(route('tweets.like', ['tweet' => $tweet->id]))
        ->assertStatus(302);
        // このコードは、ツイートをいいね解除するために、ユーザーがログインしているかどうかを検証しています。
    
    $this->assertDatabaseMissing('tweet_user', [
        'tweet_id' => $tweet->id,
        'user_id' => $user->id
    ]);
    // このコードは、ツイートをいいね解除したときに、データベースからいいねが削除されているかを検証しています。
});
