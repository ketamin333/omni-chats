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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id('conversation_id');

            $table->foreignId('contact_id')
                ->constrained('contacts', 'contact_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('channel_id')
                ->constrained('channels', 'channel_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('external_id')->index();
            $table->string('status')->index();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['channel_id', 'external_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
