<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::create('barang', function (Blueprint $table) {
    $table->string('id_barang')->primary();
    $table->string('nama');
    $table->integer('harga');
    $table->timestamps();
});