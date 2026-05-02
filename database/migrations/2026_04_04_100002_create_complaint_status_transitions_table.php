<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_status_transitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_complaint_status_id')->constrained('complaint_statuses')->cascadeOnDelete();
            $table->foreignId('to_complaint_status_id')->constrained('complaint_statuses')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['from_complaint_status_id', 'to_complaint_status_id'], 'complaint_transition_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_status_transitions');
    }
};
