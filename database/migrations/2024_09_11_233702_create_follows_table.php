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
        Schema::create('follows', function (Blueprint $table) {
        // フォローしているユーザー (自分)
        $table->foreignId('follower_user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
        // フォローされているユーザー (自分がフォローしているユーザー)
        $table->foreignId('followee_user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
    
        $table->primary(['follower_user_id', 'followee_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
