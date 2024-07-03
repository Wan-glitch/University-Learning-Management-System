<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::table('users')->whereNull('faculty')->update(['faculty' => 1]); // Assuming 1 is a valid faculty ID


        Schema::table('users', function (Blueprint $table) {

            $table->foreign('faculty')->references('id')->on('faculties')->onDelete('set null');

        });



    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['faculty']);
        });
    }
};
