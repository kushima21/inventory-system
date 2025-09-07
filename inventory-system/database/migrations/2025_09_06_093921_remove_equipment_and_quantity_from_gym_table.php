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
    Schema::table('gym_table', function (Blueprint $table) {
        $table->dropColumn(['equipment', 'quantity']);
    });
}

public function down(): void
{
    Schema::table('gym_table', function (Blueprint $table) {
        $table->string('equipment');
        $table->integer('quantity');
    });
}
};
