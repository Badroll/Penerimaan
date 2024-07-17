<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerimaans', function (Blueprint $table) {
            $table->id();
            $table->string('no_penerimaan');
            $table->string('no_invoice');
            $table->string('foto_path');
            $table->integer('supplier');
            $table->timestamp('tanggal');
            $table->integer('berat_real');
            $table->integer('berat_kotor');
            $table->integer('berat_timbangan');
            $table->integer('berat_selisih');
            $table->text('catatan');
            $table->string('pengirim');
            $table->string('pic');
            $table->string('tipe_pembayaran');
            $table->integer('harga_beli')->nullable();
            $table->timestamp('tanggal_tempo')->nullable();
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
        Schema::dropIfExists('penerimaans');
    }
}
