<?php

use App\Enums\ChannelType;
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
        Schema::create('channels', function (Blueprint $table) {
            $table->id('channel_id');

            $table->foreignId('company_id')
                ->constrained('companies', 'company_id')
                ->cascadeOnDelete();

            $table->string('channel_name');
            $table->string('avatar')->nullable();
            $table->enum('type', ChannelType::values());
            $table->json('credentials')->default('{}');
            $table->boolean('is_enabled')->default(true);

            $table->index(['company_id', 'type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};
