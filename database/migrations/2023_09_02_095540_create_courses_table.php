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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->text('syllabus');
            $table->integer('duration');
            $table->decimal('fee');
            $table->decimal('old_fee')->nullable();
            $table->date('start_date');
            $table->timestamps();
        });

        Schema::create('course_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->text('short_description');
            $table->text('detailed_description');

            $table->unique(['course_id', 'locale']);
            $table->foreign('course_id')->references('id')->on('courses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses_translations');
        Schema::dropIfExists('courses');
    }
};
