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
            $table->bigInteger('owner_id')->index();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('invitation_key', 20)->index();

            //Options: ["created", "in progress", "completed"]
            $table->string('status', 20)->nullable()->default('created');

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
