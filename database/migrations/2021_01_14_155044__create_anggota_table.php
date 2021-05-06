<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('kode_anggota', 15);
            $table->string('nama', 50);
            $table->enum('jenis_anggota', ['siswa', 'guru', 'staf']);
            $table->string('tempat_lahir', 50);
            $table->date('tgl_lahir');
            $table->enum('jk', ['L', 'P']);
            $table->string('no_hp', 15);
            $table->text('alamat');
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
        Schema::dropIfExists('anggota');
    }
}
