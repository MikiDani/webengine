<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("images", function (Blueprint $table) {
            $table->id();

            $table->integer('id_menulist');
            $table->integer('id_menumodulelist');
            $table->integer('id_module')->nullable();
            $table->string('imagename', 50);
            $table->integer('sequence')->nullable();
            $table->string('imagetitle', 100)->nullable();
            $table->boolean('first')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("images");
    }
};
