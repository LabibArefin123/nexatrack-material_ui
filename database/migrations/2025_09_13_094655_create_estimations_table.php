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
        Schema::create('estimations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->string('bill_to')->nullable();
            $table->string('ship_to')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('currency')->nullable();
            $table->date('estimate_date');
            $table->date('expiry_date');
            $table->string('status')->nullable();
            $table->json('tags')->nullable();
            $table->string('attachment')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimations');
    }
};
