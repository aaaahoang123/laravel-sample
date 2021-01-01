<?php

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTagsTable.
 */
class CreateTagsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags', function(Blueprint $table) {
            $table->id();
            $table->string('name', 191)->unique();
            $table->string('slug', 191)->index();
            $table->timestamps();
		});

		Schema::create('product_tags', function (Blueprint $table) {
		    $product = new Product();
		    $tag = new Tag();
		    $table->foreignId('product_id')->constrained($product->getTable());
		    $table->foreignId('tag_id')->constrained($tag->getTable());
		    $table->primary(['product_id', 'tag_id']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('product_tags');
		Schema::drop('tags');
	}
}
