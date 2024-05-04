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
        Schema::create('alumni_records', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->string('studentNumber');
            $table->string('civilStatus');
            $table->integer('year');
            $table->string('relatedOrNot');
            $table->string('course');
            $table->string('employmentStatus');
            $table->string('gender');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni_records');
    }
};
