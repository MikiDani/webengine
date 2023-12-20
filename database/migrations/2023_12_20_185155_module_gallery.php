<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("module_gallery", function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_menumodulelist')->constrained('menumodulelist')->onDelete('cascade');

            $table->integer('image_id');
            $table->integer('sequence');
            $table->string('picturename_hu');
            $table->string('picturename_en');
            $table->boolean('active');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("module_gallery");
    }
};
