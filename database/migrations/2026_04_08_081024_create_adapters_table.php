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
        Schema::create('adapters', function (Blueprint $table) {
            $table->id('adapter_id');

            $table->string('adapter_name');
            $table->string('adapter_type');

            $table->string('slug')->unique();
            $table->string('handler');
            $table->jsonb('settings_schema')->nullable();
            $table->boolean('is_enabled')->default(true);

            $table->timestamps();

            $table->index(['adapter_name', 'adapter_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adapters');
    }
};
