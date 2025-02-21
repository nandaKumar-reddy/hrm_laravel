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
        Schema::create('statutory_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('uan_number')->unique()->nullable();
            $table->string('esi_number')->unique()->nullable();
            $table->string('emp_state_code')->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_contact_num')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statutory_details');
    }
};
