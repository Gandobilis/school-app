<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->string('linkedin')->nullable();
            $table->timestamps();
        });

        Schema::create('lecturer_translations', function (Blueprint $table) {
            $table->unsignedBigInteger('lecturer_id');
            $table->string('locale')->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('position');
            $table->text('description');

            $table->unique(['lecturer_id', 'locale']);
            $table->foreign('lecturer_id')->references('id')->on('lecturers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_translations');
        Schema::dropIfExists('lecturers');
    }
};
