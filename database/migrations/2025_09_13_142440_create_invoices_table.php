<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->index();
            $table->foreignId('project_id')->nullable()->index();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('bill_to');
            $table->string('ship_to');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('USD');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->string('payment_method', 50)->nullable();
            $table->string('status', 50)->default('unpaid');
            $table->text('description')->nullable();
            $table->json('items')->nullable();
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
