<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('github_releases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagName');
            $table->text('description');
            $table->string('url');
            $table->dateTime('publishedAt');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('github_releases');
    }
};
