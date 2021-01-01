<?php

use App\Models\User;
use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Helper\Utils;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProductsTable.
 */
class CreateProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
            $user = new User();
            $table->id();
            $table->string('name', 191);
            $table->string('slug', 191)->unique();
            $table->text('description');
            $table->mediumText('details');
            $table->text('images');

            $table->string('state');
            $table->integer('warranty');
            $table->bigInteger('price')->nullable();
            $table->foreignId('category_id')->constrained();

            $table->foreignId('created_by_id')->constrained($user->getTable());
            $table->foreignId('updated_by_id')->constrained($user->getTable());

            $table->timestamps();
            $table->tinyInteger('status')
                ->default(CommonStatus::ACTIVE)
                ->comment(Utils::generateDbComment(CommonStatus::getInstances()));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}
}
