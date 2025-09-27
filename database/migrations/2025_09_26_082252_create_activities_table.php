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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->index();
            $table->foreignId('owner_id')->nullable()->index();
            $table->foreignId('deal_id')->nullable()->index();
            $table->foreignId('contract_id')->nullable()->index();
            $table->foreignId('company_id')->nullable()->index();
            $table->string('title');
            $table->enum('activity_type', ['call', 'email', 'task', 'meeting']);
            $table->date('due_date');
            $table->time('time')->nullable();
            $table->integer('reminder')->nullable();
            $table->text('description')->nullable();
            $table->json('guests')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
