<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penukaran_sampahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->foreignId('jenis_sampah_id')->nullable();
            $table->foreign('jenis_sampah_id')->references('id')->on('jenis_sampahs')->onDelete("cascade");
            $table->integer("jumlah_sampah");
            $table->integer("jumlah_point");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penukaran_sampahs');
    }
};
