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
        Schema::create("module_news", function (Blueprint $table) {
            $table->id();

            $table->datetime('news_datetime');
            $table->string('news_title');
            $table->longText('news_message');
            $table->string('news_image');
            $table->string('news_link');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("module_news");
    }
};
