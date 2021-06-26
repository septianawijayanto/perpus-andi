<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembalianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->foreignId('anggota_id')->references('id')->on('anggota')->onDelete('cascade');
            $table->foreignId('buku_id')->references('id')->on('buku')->onDelete('cascade');
            $table->date('tgl_pengembalian');
            $table->string('status', 15);

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
        Schema::dropIfExists('pengembalian');
    }
}
