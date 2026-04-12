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
    Schema::create('deal_user', function (Blueprint $table) {
        $table->id();
        // Links to the User who joined
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Links to the specific Deal they joined
        $table->foreignId('deal_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deal_user');
    }
};
