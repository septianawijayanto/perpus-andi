<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 12);
            $table->string('judul', 90);
            $table->string('isbn', 25)->nullable();
            $table->string('pengarang', 50)->nullable();
            $table->string('penerbit')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->integer('jml_buku');
            $table->integer('jml_dipinjam')->nullable();
            $table->integer('rusak')->nullable();
            $table->integer('hilang')->nullable();
            $table->string('sumber', 50);
            $table->text('deskripsi')->nullable();
            $table->string('lokasi', 15);
            $table->string('cover')->nullable();
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
        Schema::dropIfExists('buku');
    }
}
