<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->date('date');
            $table->date('open_till');
            $table->unsignedBigInteger('client_id')->nullable()->index();
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->unsignedBigInteger('deal_id')->nullable()->index();
            $table->string('currency')->nullable();
            $table->string('status')->nullable();
            $table->json('assigned_to')->nullable();
            $table->string('attachment')->nullable();
            $table->json('tags')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
