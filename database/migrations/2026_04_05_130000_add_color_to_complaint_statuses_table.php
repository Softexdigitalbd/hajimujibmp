<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaint_statuses', function (Blueprint $table) {
            $table->string('color', 32)->default('slate')->after('state');
        });
    }

    public function down(): void
    {
        Schema::table('complaint_statuses', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
