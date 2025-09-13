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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('plan')->nullable();
            $table->string('source')->nullable();
            $table->string('status')->nullable(); // 1 = New, 2 = Contacted, 3 = Qualified, 4 = Disqualified
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
