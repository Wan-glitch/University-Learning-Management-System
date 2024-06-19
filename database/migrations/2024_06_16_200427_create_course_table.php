<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            // Reference to the faculty (team)
            $table->unsignedBigInteger('faculty')->nullable();
            $table->foreign('faculty')->references('id')->on('faculties')->onDelete('cascade');
            $table->unsignedBigInteger('pic')->nullable();
            $table->foreign('pic')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            // Using year and term combination
            $table->year('year');
            $table->tinyInteger('term')->comment('1: Term 1, 2: Term 2, 3: Term 3, 4: Term 4');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};

