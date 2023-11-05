<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("menumodulelist", function (Blueprint $table) {
            $table->id();

            $table->integer('sequence');

            $table->unsignedBigInteger('id_menulist');
            $table->foreign('id_menulist')->references('id')->on('menulist')
            ->onDelete('RESTRICT')->onUpdate('RESTRICT');

            $table->unsignedBigInteger('id_moduletype');
            $table->foreign('id_moduletype')->references('id')->on('menumoduletype');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menumodulelist');
    }
};
