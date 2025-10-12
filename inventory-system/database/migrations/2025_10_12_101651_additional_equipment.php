<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('additional_equipments', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('booking_id');
    $table->string('equipment_name');
    $table->integer('quantity');
    $table->decimal('price', 10, 2)->default(0);
    $table->timestamps();

    $table->foreign('booking_id')
          ->references('id')
          ->on('booking_tbl')
          ->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('additional_equipments');
    }
};
