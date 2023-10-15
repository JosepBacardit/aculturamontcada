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
        Schema::create('labelable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('label_id');
            $table->unsignedBigInteger('labelable_id');
            $table->string('labelable_type');
            $table->timestamps();

            $table->index(['labelable_id', 'labelable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labelable');
    }
};
