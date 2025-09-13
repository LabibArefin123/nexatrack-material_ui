<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('deal_stage');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 5);
            $table->date('end_date');
            $table->string('client_option');
            $table->string('company_option')->nullable();
            $table->string('deal_type');
            $table->string('source');
            $table->text('source_information');
            $table->date('start_date');
            $table->text('responsibles')->nullable();   // ✅ make it nullable
            $table->text('observer')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
