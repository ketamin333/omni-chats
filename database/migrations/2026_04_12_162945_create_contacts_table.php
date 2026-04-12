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
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('username')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
