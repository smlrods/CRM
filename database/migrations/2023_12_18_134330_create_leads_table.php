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
            $table->foreignId('contact_id')->constrained();
            $table->foreignId('company_id')->constrained();
            $table->enum('source', ['website', 'referral', 'social_media', 'other']);
            $table->date('created_at');
            $table->enum('status', ['open', 'closed', 'converted']);
            $table->text('description')->nullable();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
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
