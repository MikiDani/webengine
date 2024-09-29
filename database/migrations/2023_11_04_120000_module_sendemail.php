<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("module_sendemail", function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_menumodulelist')->constrained('menumodulelist')->onDelete('cascade');

            $table->longText('message')->nullable();
            $table->boolean('newsletter')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("module_sendemail");
    }
};
