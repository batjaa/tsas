<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('url', 2048);
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('referrer', 2048)->nullable();
            $table->string('device', 10)->default('desktop');
            $table->string('user_agent', 1024)->nullable();
            $table->string('ip', 45)->nullable();
            $table->smallInteger('status_code')->unsigned()->default(200);
            $table->boolean('is_bot')->default(false);
            $table->timestamp('visited_at')->useCurrent();

            $table->index('visited_at');
            $table->index('status_code');
            $table->index('product_id');
            $table->index('device');
            $table->index('is_bot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
