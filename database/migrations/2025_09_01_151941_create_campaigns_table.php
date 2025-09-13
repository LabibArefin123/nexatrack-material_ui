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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->foreignId('pipeline_id')->nullable();
            $table->string('plan')->nullable();
            $table->integer('total_members')->default(0);
            $table->integer('sent')->default(0);
            $table->integer('opened')->default(0);
            $table->integer('delivered')->default(0);
            $table->integer('closed')->default(0);
            $table->integer('unsubscribe')->default(0);
            $table->integer('bounced')->default(0);
            $table->float('progress')->default(0);
            $table->string('status')->default('Active');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
