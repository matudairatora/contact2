<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use App\Models\Category;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->truncate();
        $categoryMap = Category::pluck('id', 'content')->toArray();

        $contactsData = [[
            'first_name'=>'satou',
            'last_name'=>'itirou',
            'gender'=> 1,
            'email'=>'itirou@gmail.com',
            'tel'=>'07012345678',
            'address'=>'toukyoutotiyodaku',
            'building'=>'itirou102',
            'content'=>'商品のお届けについて',
            'detail'=>'otoiawase'

        ],
        [
            'first_name'=>'yamada',
            'last_name'=>'jirou',
            'gender'=> 1,
            'email'=>'jirou@gmail.com',
            'tel'=>'07012348888',
            'address'=>'aitikennnagoyasi',
            'building'=>'jirou201',
            'content'=>'商品の交換について',
            'detail'=>'otoiawase2'

        ],
        [
            'first_name'=>'sagawa',
            'last_name'=>'saburou',
            'gender'=> 2,
            'email'=>'saburou@gmail.com',
            'tel'=>'07012349999',
            'address'=>'miekenntusi',
            'building'=>'saburou302',
            'content'=>'商品トラブル',
            'detail'=>'otoiawase3'

        ],
        [
            'first_name'=>'tanaka',
            'last_name'=>'yonnko',
            'gender'=> 2,
            'email'=>'yonnko@gmail.com',
            'tel'=>'07012346666',
            'address'=>'oosakafusuitasi',
            'building'=>'yonko403',
            'content'=>'ショップへのお問い合わせ',
            'detail'=>'otoiawase4'

        ],
        [
            'first_name'=>'satonaka',
            'last_name'=>'gorou',
            'gender'=> 3,
            'email'=>'gorou@gmail.com',
            'tel'=>'07012347777',
            'address'=>'aomorikenaomorisi',
            'building'=>'gorou505',
            'content'=>'その他',
            'detail'=>'otoiawase5'

           ]   ];
            foreach ($contactsData as $data) {
            // カテゴリー名からIDを取得し、'category_id'として追加
            $categoryId = $categoryMap[$data['content']] ?? null;

            if ($categoryId) {
                DB::table('contacts')->insert([
                    'category_id' => $categoryId, // ★ IDをセット
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'gender' => $data['gender'],
                    'email' => $data['email'],
                    'tel' => $data['tel'],
                    'address' => $data['address'],
                    'building' => $data['building'],
                    'detail' => $data['detail'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
