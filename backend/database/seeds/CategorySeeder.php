<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => "プログラミング"],
            ['name' => "アイドル"],
            ['name' => "歴史"],
            ['name' => "お笑い"],
            ['name' => "生活"],
            ['name' => "料理"],
            ['name' => "マンガ・アニメ"],
            ['name' => "小説"],
            ['name' => "映画"],
        ]);
    }
}
