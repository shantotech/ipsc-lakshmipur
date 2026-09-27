<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('popups', function (Blueprint $table) {
            $table->unsignedSmallInteger('repeat_after_hours')->default(6)->after('ends_at');
        });
    }

    public function down(): void
    {
        Schema::table('popups', function (Blueprint $table) {
            $table->dropColumn('repeat_after_hours');
        });
    }
};
