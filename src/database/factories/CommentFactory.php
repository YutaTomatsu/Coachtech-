<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;


class CommentFactory extends Factory
{

    protected $model = Comment::class;

    private $comments = [
        ['id' => 1, 'user_id' => '2','item_id' =>'1','comment' =>'こちらの商品の値下げは可能でしょうか？'],
        ['id' => 2, 'user_id' => '1', 'item_id' => '1', 'comment' => '400円までなら値下げ可能です！'],
        ['id' => 3, 'user_id' => '3', 'item_id' => '1', 'comment' => 'コメント失礼します。後から見た時の写真など、より詳しく状態を確認するために写真を追加していただくことは可能でしょうか？'],
        ['id' => 4, 'user_id' => '1', 'item_id' => '1', 'comment' => 'コメントありがとうございます。承知しました！今日中に追加させて頂きます！'],

    ];

    public function definition()
    {
        $comment = array_shift($this->comments);

        return [
            'id' => $comment['id'],
            'user_id' => $comment['user_id'],
            'item_id' => $comment['item_id'],
            'comment' => $comment['comment'],
        ];
    }
}
