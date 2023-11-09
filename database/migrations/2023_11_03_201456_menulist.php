<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menulist', function(Blueprint $table) {
            $table->id();

            $table->integer('id_menu');         ///  ???? NEM IS KELLL   AZ ID KELL


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
