<!-- resources/views/tweets/show.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Tweet詳細') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <a href="{{ route('tweets.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>
          <p class="text-gray-800 dark:text-gray-300 text-lg">{{ $tweet->tweet }}</p>
          <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $tweet->user->name }}</p>
          <div class="text-gray-600 dark:text-gray-400 text-sm">
            <p>作成日時: {{ $tweet->created_at->format('Y-m-d H:i') }}</p>
            <p>更新日時: {{ $tweet->updated_at->format('Y-m-d H:i') }}</p>
          </div>
          @if (auth()->id() == $tweet->user_id)
          <div class="flex mt-4">
            <a href="{{ route('tweets.edit', $tweet) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
            <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
            </form>
            {{-- 
              削除ボタンを押すとアラートが表示されるようにするために、
              formタグにonsubmit属性を追加し、その中にJavaScriptのconfirm関数を使って確認メッセージを表示するようにしました。
              このconfirm関数は、引数に渡した文字列をアラートとして表示し、ユーザーがOKボタンを押した場合にtrueを返し、キャンセルボタンを押した場合にfalseを返します。
              そのため、この戻り値がtrueの場合にのみフォームが送信されるようになります。
              JavaScriptのコードを記述しなくてもonsubmit属性にとcomfirm関数を記述するだけで、確認メッセージを表示することができます。
              onsubmit属性で利用できるJavaScriptのコードは、他にもたくさんあり、その一例を以下に示します。
              ・return false;: フォームの送信をキャンセルします。
              ・return true;: フォームの送信を許可します。
              ・return 関数名();: 関数を実行し、その戻り値によってフォームの送信を許可またはキャンセルします。
              このように、onsubmit属性を使うことで、フォームの送信を制御することができます。
              他は？
              
              --}}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
