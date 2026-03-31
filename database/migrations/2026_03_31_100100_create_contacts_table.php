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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id('contact_id');

            $table->foreignId('company_id')
                ->constrained('companies', 'company_id')
                ->cascadeOnDelete();
            $table->foreignId('channel_id')
                ->constrained('channels', 'channel_id')
                ->cascadeOnDelete();

            $table->string('external_id');
            $table->string('name');
            $table->string('avatar');

            $table->unique(['channel_id', 'external_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
