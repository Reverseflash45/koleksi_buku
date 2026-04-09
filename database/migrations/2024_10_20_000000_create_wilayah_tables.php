<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reg_provinces', function (Blueprint $table) {
            $table->string('id', 2)->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('regencies', function (Blueprint $table) {
            $table->string('id', 4)->primary();
            $table->string('province_id', 2);
            $table->string('name');
            $table->timestamps();
            $table->foreign('province_id')->references('id')->on('reg_provinces');
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->string('id', 7)->primary();
            $table->string('regency_id', 4);
            $table->string('name');
            $table->timestamps();
            $table->foreign('regency_id')->references('id')->on('regencies');
        });

        Schema::create('villages', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('district_id', 7);
            $table->string('name');
            $table->timestamps();
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    public function down()
    {
        Schema::dropIfExists('villages');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('regencies');
        Schema::dropIfExists('reg_provinces');
    }
};