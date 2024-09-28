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
        Schema::create('communitypost_likes', function (Blueprint $table) {
            $table->id();
            //いいねしたユーザーのid
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            //いいねされた記事のid
            $table->foreignId('community_posts_id')->constrained()->onDelete('cascade');
            //主キーをuser_idとcommunitypost_idの組み合わせにする
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communitypost_likes');
    }
};