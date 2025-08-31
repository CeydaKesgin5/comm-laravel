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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id('announcement_id');
            $table->string('title');
            $table->text('description');
            $table->dateTime('date_posted');
            $table->unsignedBigInteger('author_id');
            $table->string('category');
            $table->boolean('is_active')->default(true);
            $table->string('image_url')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
