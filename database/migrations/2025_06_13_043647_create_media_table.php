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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('path')->unique(); // Path to the media file
            $table->string('type'); // Type of media (e.g., image, video, document)
            $table->string('mime_type'); // MIME type of the media file
            $table->string('file_name'); // Original file name
            $table->string('file_size'); // Size of the file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
