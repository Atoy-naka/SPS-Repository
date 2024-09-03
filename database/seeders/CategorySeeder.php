<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params =
        [
            [
                'name' => '質問'
            ],
            [
                'name' => 'ブログ'    
            ],
            [
                'name' => 'レビュー'
            ],
            [
                'name' => '里親募集'    
            ],
            [
                'name' => '犬'
            ],
            [
                'name' => '猫'    
            ],
            [
                'name' => '小動物'
            ],
            [
                'name' => '鳥'    
            ],
            [
                'name' => '魚'
            ],
            [
                'name' => '爬虫類'    
            ],
        ];
        
        foreach ($params as $param) {
            DB::table('categories')->insert($param);
        }
    }
}
