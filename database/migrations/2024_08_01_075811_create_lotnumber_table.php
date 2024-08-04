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
        Schema::create('lotnumber', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partnumber_id')->constrained('partnumber')->onDelete('cascade');
            $table->string('lotnumber');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotnumber');
    }
};
