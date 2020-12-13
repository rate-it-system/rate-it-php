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
            $table->id();
            //TODO:Dodać w niedalekiej przyszłości
            //$table->bigInteger('owner_id')->unsigned();
            $table->string('name', 255);
            $table->text('description')->nullable();

            //Options: ["created", "in progress", "completed"]
            $table->string('status', 20);

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
