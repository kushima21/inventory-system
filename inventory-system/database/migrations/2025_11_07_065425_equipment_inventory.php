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
        Schema::create('equipment_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name', 205);
            $table->integer('quantity');
            $table->timestamp('created_at', 6)->useCurrent()->useCurrentOnUpdate();
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_inventory');
    }
};
