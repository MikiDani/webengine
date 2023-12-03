<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("module_news", function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_menumodulelist')->constrained('menumodulelist')->onDelete('cascade');

            $table->integer('sequence');
            $table->datetime('news_datetime');
            $table->string('news_title');
            $table->longText('news_message');
            $table->string('news_image')->nullable();
            $table->string('news_link');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("module_news");
    }
};
