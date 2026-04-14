<?php

use App\Enums\MessageDirection;
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
        Schema::create('messages', function (Blueprint $table) {
            $table->id('message_id');

            $table->foreignUuid('conversation_id')
                ->index()
                ->constrained('conversations', 'conversation_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('external_id')->nullable();
            $table->enum('direction', MessageDirection::values());
            $table->text('text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
