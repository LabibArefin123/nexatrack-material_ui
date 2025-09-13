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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('priority')->nullable(); // 1->high, 2->medium, 3->low
            $table->unsignedSmallInteger('status')->nullable(); // 1->pending,2->in_progress,3->completed,4->onhold
            $table->date('due_date')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
