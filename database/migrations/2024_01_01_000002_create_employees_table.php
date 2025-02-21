<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->date('dob');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('current_address');
            $table->string('department');
            $table->string('designation');
            $table->date('joining_date');
            $table->string('emp_type')->nullable();
            $table->string('emp_category')->nullable();
            $table->string('reporting')->nullable();
            $table->mediumText('aadhar_card')->nullable();
            $table->mediumText('pan_card')->nullable();
            $table->date('resignation_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->decimal('basic_da', 10, 2);
            $table->decimal('hra', 10, 2);
            $table->decimal('medical_allowance', 10, 2)->default(0);
            $table->decimal('special_allowance', 10, 2)->default(0);
            $table->decimal('conveyance', 10, 2)->default(0);
            $table->decimal('statutory_bonus', 10, 2)->default(0);
            $table->decimal('el_encashment', 10, 2)->default(0);
            $table->decimal('other_allowance', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('bank_name');
            $table->string('act_holder_name');
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->string('branch_name');
            $table->string('upi_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_details');
        Schema::dropIfExists('salary_details');
        Schema::dropIfExists('employees');
    }
};
