<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToKontensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kontens', function (Blueprint $table) {
            $table->unsignedInteger('class_id');
            $table->foreign('class_id')->references('id')->on('school_classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kontens', function (Blueprint $table) {
            //
        });
    }
}
