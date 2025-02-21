<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('month');
            $table->year('year');
            $table->unsignedTinyInteger('total_days');
            $table->unsignedTinyInteger('working_days');
            $table->unsignedTinyInteger('holidays')->default(0);
            $table->unsignedTinyInteger('absent_days')->default(0);
            $table->unsignedTinyInteger('applied_leaves')->default(0);
            $table->unsignedTinyInteger('present_days'); // Calculated: working_days - absent_days
            $table->unsignedTinyInteger('payable_days'); // Calculated: present_days - applied_leaves
            $table->timestamps();

            // Add unique constraint
            $table->unique(['employee_id', 'month', 'year']);
        });

        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('month');
            $table->year('year');
            
            // Earnings
            $table->decimal('basic_da', 10, 2)->default(0);
            $table->decimal('hra', 10, 2)->default(0);
            $table->decimal('medical_allowance', 10, 2)->default(0);
            $table->decimal('special_allowance', 10, 2)->default(0);
            $table->decimal('conveyance', 10, 2)->default(0);
            $table->decimal('statutory_bonus', 10, 2)->default(0);
            $table->decimal('el_encashment', 10, 2)->default(0);
            $table->decimal('other_allowance', 10, 2)->default(0);
            $table->decimal('incentives', 10, 2)->default(0);
            $table->decimal('overtime', 10, 2)->default(0);
            
            // Deductions
            $table->decimal('pf', 10, 2)->default(0);
            $table->decimal('esi', 10, 2)->default(0);
            $table->decimal('pt', 10, 2)->default(0);
            $table->decimal('tds', 10, 2)->default(0);
            $table->decimal('advance', 10, 2)->default(0);
            
            // Totals
            $table->decimal('total_earnings', 10, 2)->default(0);
            $table->decimal('total_deductions', 10, 2)->default(0);
            $table->decimal('net_payable', 10, 2)->default(0);
            
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Add unique constraint
            $table->unique(['employee_id', 'month', 'year']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payrolls');
        Schema::dropIfExists('attendance');
    }
};
