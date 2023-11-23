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

            $table->string('sendemail_email', 50);
            $table->string('sendemail_label', 255);
            $table->longText('sendemail_message');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("module_sendemail");
    }
};
