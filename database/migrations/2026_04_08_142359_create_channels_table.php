<?php

use App\Enums\ChannelStatus;
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

            $table->foreignId('adapter_id')
                ->nullable()
                ->constrained('adapters', 'adapter_id')
                ->nullOnDelete();

            $table->string('status')->default(ChannelStatus::PENDING)->index();
            $table->string('channel_name');

            $table->jsonb('credentials')->nullable();
            $table->jsonb('settings')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
