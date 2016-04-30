<?php

use Illuminate\Database\Seeder;
use MrCoffer\Transaction\Category;

/**
 * Class CategoriesTableSeeder
 */
class CategoriesTableSeeder extends Seeder
{
    /**
     * Transaction Category Model
     *
     * @var Category
     */
    protected $category;

    /**
     * CategoriesTableSeeder constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->category->name = 'automotive';
        $this->category->save();
    }
}
