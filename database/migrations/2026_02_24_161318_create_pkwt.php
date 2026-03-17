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
        Schema::create('pkwt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('contract_number')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('contract_type')->nullable();
            $table->string('work_type')->nullable();
            $table->string('work_type_secondary')->nullable();
            $table->decimal('base_salary', 15, 2)->default(0);
            $table->decimal('allowance', 15, 2)->default(0);
            $table->decimal('total_salary', 15, 2)->default(0);
            $table->string('responsible_name')->nullable();
            $table->date('signed_date')->nullable();
            $table->string('work_location')->nullable();
            $table->text('notes')->nullable();
            $table->string('signed_contract_file')->nullable();
            $table->enum('status', ['active', 'near-expired', 'expired'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkwt');
    }
};
