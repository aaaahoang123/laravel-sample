<?php

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Common\Helper\Utils;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateArticlesTable.
 */
class CreateArticlesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table) {
            $user = new User();
            $table->bigIncrements('id');
            $table->string('name', 191);
            $table->string('slug', 191)->unique();
            $table->string('description', 500);
            $table->mediumText('content');
            $table->string('thumbnail')->nullable();

            $table->foreignId('category_id')->constrained();
            $table->foreignId('created_by_id')->constrained($user->getTable());
            $table->foreignId('updated_by_id')->constrained($user->getTable());

            $table->unsignedInteger('views')->default(0);

            $table->timestamps();
            $table->tinyInteger('status')
                ->default(CommonStatus::ACTIVE)
                ->comment(Utils::generateDbComment(CommonStatus::getInstances()));
		});

		Schema::create('article_tags', function (Blueprint $table) {
            $article = new Article();
            $tag = new Tag();
            $table->foreignId('article_id')->constrained($article->getTable());
            $table->foreignId('tag_id')->constrained($tag->getTable());
            $table->primary(['article_id', 'tag_id']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::drop('article_tags');
		Schema::drop('articles');
	}
}
