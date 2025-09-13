<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pipelines', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Pipeline Name
            $table->decimal('total_deal_value', 15, 2)->default(0);
            $table->integer('no_of_deals')->default(0);
            $table->string('stage')->nullable(); // e.g., Win, Lost, In Pipeline
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pipelines');
    }
};
