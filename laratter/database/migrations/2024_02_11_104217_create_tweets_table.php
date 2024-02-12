<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //cascadeOnDelete()の意味は、ユーザーが削除されたときに、そのユーザーに関連するすべてのツイートも削除されることを意味します。
            //constrained()は、外部キー制約を追加するためのショートカットです。
            //foreignId()とconstrained()を使用すると、外部キー制約を追加するための2つのメソッドを1行で実行できます。この二つは組み合わせて使うことが多いです。
            $table->string('tweet');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
