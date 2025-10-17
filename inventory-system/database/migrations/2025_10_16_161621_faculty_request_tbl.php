<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('supply_requests', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone_number');
        $table->string('email');
        $table->date('date_needed');
        $table->string('supply_name');
        $table->integer('quantity');
        $table->string('request_status')->default('Pending'); // Default status
        $table->date('date_approved')->nullable();            // Nullable
        $table->date('date_completed')->nullable();           // Nullable
        $table->date('date_cancelled')->nullable();           // Nullable
        $table->date('date_declined')->nullable();           // Nullable
        $table->string('reason')->nullable();                 // Nullable
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('supply_requests');
    }
};
