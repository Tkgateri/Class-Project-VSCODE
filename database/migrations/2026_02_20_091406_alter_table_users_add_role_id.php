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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is active');
            $table->string('user_image')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();  
            $table->foreign('role_id')->references('id')->on('roles');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is active', 'user_image', 'role_id']);

            $table->dropForeign(['role_id']);
        });
    }
};
