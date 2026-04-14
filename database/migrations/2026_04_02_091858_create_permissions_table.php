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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id('permission_id');

            $table->string('slug')->unique();
            $table->string('label');
            $table->string('description')->nullable();

            $table->timestamps();
        });

        Schema::create('user_permissions', function (Blueprint $table) {
            $table->foreignId('permission_id')
                ->index()
                ->constrained('permissions', 'permission_id')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->index()
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();

            $table->primary(['permission_id', 'user_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('permissions');
    }
};
