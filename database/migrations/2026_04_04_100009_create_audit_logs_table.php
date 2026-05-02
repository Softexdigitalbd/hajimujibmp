<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained('complaints')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 32);
            $table->foreignId('from_complaint_status_id')->nullable()->constrained('complaint_statuses')->nullOnDelete();
            $table->foreignId('to_complaint_status_id')->nullable()->constrained('complaint_statuses')->nullOnDelete();
            $table->foreignId('comment_id')->nullable()->constrained('comments')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['complaint_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
