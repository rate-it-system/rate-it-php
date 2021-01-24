<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDegustationfeaturesIdToProduktevaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produktevaluations', function (Blueprint $table) {
            $table->bigInteger('degustationfeatures_id')->index();
            $table->dropColumn('degustation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produktevaluations', function (Blueprint $table) {
            $table->dropColumn('degustationfeatures_id');
            $table->bigInteger('degustation_id')->index();
        });
    }
}
