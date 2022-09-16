<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPesertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pesertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id');
            $table->string('Nama');
            $table->string('Jurusan');
            $table->string('NoHP');
            $table->string('IDLine')->nullable();
            $table->string('KTM')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pesertas');
    }
}