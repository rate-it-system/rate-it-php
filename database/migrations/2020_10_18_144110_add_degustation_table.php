<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDegustationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('degustation', function (Blueprint $table) {
            $table->increments('degustation_id')->autoIncrement();
            $table->string('name');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
        Schema::create('products', function (Blueprint $table) {
            $table->increments('products_id')->autoIncrement();
            $table->string('name');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
        Schema::create('products_to_degustation', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();

            $table->bigInteger('degustation_id')->unsigned()->index()->nullable();
            $table->bigInteger('products_id')->unsigned()->index()->nullable();


            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
        Schema::create('degustation_to_users', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();

            $table->bigInteger('degustation_id')->unsigned()->index()->nullable();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();

            $table->boolean("admin")->default(false);

            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('degustation');
        Schema::dropIfExists('products');
        Schema::dropIfExists('products_to_degustation');
        Schema::dropIfExists('degustation_to_users');
    }
}
