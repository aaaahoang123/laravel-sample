<?php

namespace Database\Seeders;

use App\Enums\Type\CategoryType;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SystemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'Hệ thống';
        $category = new Category();
        $category->name = $name;
        $category->slug = Str::lower(Str::slug($name));
        $category->type = CategoryType::ARTICLE;
        $category->is_system = true;
        $category->save();
    }
}
