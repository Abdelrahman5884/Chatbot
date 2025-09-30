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
        Schema::create('newchats', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('New Chat');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->foreignId('newchat_id')->constrained('newchats')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign(['newchat_id']);
            $table->dropColumn('newchat_id');
        });

        Schema::dropIfExists('newchats');
    }
};
