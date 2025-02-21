<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email')->unique();
            $table->string('industry_type')->nullable();
            $table->string('client_number')->nullable();
            $table->text('client_address')->nullable();
            $table->string('pan')->nullable();
            $table->string('gst')->nullable();
            $table->string('tan_number')->nullable();
            $table->string('cin_number')->nullable();
            $table->string('pf_num')->nullable();
            $table->string('esi_num')->nullable();
            $table->string('pt_num')->nullable();
            $table->string('lwf_num')->nullable();
            $table->string('poc_name')->nullable();
            $table->string('poc_designation')->nullable();
            $table->string('poc_email')->nullable();
            $table->string('poc_number')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
