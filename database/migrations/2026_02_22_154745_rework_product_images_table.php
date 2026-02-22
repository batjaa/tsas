<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn('image_url');
            $table->string('disk')->nullable()->after('product_id');
            $table->string('path')->nullable()->after('disk');
            $table->string('original_filename')->nullable()->after('path');
            $table->string('mime_type')->nullable()->after('original_filename');
            $table->unsignedInteger('size')->nullable()->after('mime_type');
            $table->json('variants')->nullable()->after('size');
        });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn(['disk', 'path', 'original_filename', 'mime_type', 'size', 'variants']);
            $table->string('image_url')->after('product_id');
        });
    }
};
