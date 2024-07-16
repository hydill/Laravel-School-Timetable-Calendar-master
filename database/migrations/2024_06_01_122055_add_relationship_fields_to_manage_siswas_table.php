<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToManageSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manage_siswas', function (Blueprint $table) {
            $table->unsignedInteger('class_id');
            $table->foreign('class_id')->references('id')->on('school_classes');
            $table->unsignedBigInteger('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->unsignedInteger('lesson_id');
            $table->foreign('lesson_id')->references('id')->on('lessons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manage_siswas', function (Blueprint $table) {
            $table->unsignedBigInteger('konten_id')->nullable();
            $table->foreign('konten_id')->references('id')->on('kontens');
        });
    }
}
