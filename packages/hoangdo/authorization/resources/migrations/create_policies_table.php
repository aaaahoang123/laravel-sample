<?php

use HoangDo\Common\Enum\CommonStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            $table->tinyInteger('status')
                ->default(CommonStatus::ACTIVE)
                ->comment(generate_db_comment(CommonStatus::getInstances()));
        });

        Schema::create('policy_role', function (Blueprint $table) {
            $table->string('role_id');
            $table->integer('policy_id')->index();

            $table->primary(['policy_id', 'role_id']);
        });

        Schema::create('policy_user', function (Blueprint $table) {
            $table->string('user_id')->index();
            $table->string('policy_id');

            $table->primary(['user_id', 'policy_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policies');
        Schema::dropIfExists('policy_role');
        Schema::dropIfExists('policy_user');
    }
}
