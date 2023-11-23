<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menulist', function(Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary();

            $table->string('menuname_hu');
            $table->string('menuname_en');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menulist');
    }
};
