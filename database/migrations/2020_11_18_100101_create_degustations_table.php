<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDegustationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('degustations', function (Blueprint $table) {
            //$table->increments('degustation_id')->autoIncrement();
            $table->id();
            $table->string('name');

            /*$table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();*/
            $table->timestamps();
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
        Schema::dropIfExists('degustations');
    }
}
