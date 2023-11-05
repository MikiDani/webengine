<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("modules_switch", function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_modulelist');
            $table->foreign('id_modulelist')->references('id')->on('menumodulelist');
            
            $table->unsignedBigInteger('id_module');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("modules_switch");
    }
};
