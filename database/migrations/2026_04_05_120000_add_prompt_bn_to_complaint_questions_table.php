<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaint_questions', function (Blueprint $table) {
            $table->string('prompt_bn')->nullable()->after('prompt');
        });
    }

    public function down(): void
    {
        Schema::table('complaint_questions', function (Blueprint $table) {
            $table->dropColumn('prompt_bn');
        });
    }
};
