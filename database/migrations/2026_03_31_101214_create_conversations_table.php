<?php

use App\Enums\ConversationStatus;
use Carbon\Carbon;
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
                ->cascadeOnDelete();
            $table->foreignId('assigner_id')
                ->nullable()
                ->constrained('users', 'user_id')
                ->nullOnDelete();

            $table->enum('status', ConversationStatus::values())->default(ConversationStatus::PENDING);

            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
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
