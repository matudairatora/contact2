<?php
namespace Database\Seeders; // ★名前空間は「Database\Seeders」で正しい

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // DBファサードを使用するために追記

class CategorySeeder extends Seeder // ★クラス名は「CategorySeeder」で正しい
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['content' => '商品のお届けについて'],
            ['content' => '商品の交換について'],
            ['content' => '商品トラブル'],
            ['content' => 'ショップへのお問い合わせ'],
            ['content' => 'その他'],
        ];

        // categoriesテーブルにデータを挿入
        DB::table('categories')->insert($categories);
    }
}
