<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained('complaints')->cascadeOnDelete();
            $table->foreignId('complaint_question_id')->constrained('complaint_questions')->cascadeOnDelete();
            $table->longText('value');
            $table->timestamps();

            $table->unique(['complaint_id', 'complaint_question_id'], 'complaint_answer_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_answers');
    }
};
