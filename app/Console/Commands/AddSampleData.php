<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddSampleData extends Command
{
    protected $signature = 'app:add-sample-data';
    protected $description = 'Add sample data for testing';

    public function handle()
    {
        DB::beginTransaction();

        try {
            // Create a client
            $client = Client::create([
                'client_id' => 'CL001',
                'client_name' => 'Tech Solutions Pvt Ltd',
                'industry_type' => 'Information Technology',
                'email' => 'contact@techsolutions.com',
                'phone' => '9876543210',
                'contact_person_name' => 'John Doe',
                'gstin' => 'GSTIN123456789',
                'pan' => 'PANAB1234C',
                'tan' => 'TAN123456',
                'address' => '123 Tech Park',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'pin_code' => '560001',
                'status' => 'active'
            ]);

            $this->info('Client created successfully');

            // Create an employee
            $employee = Employee::create([
                'client_id' => $client->id,
                'employee_id' => 'EMP001',
                'first_name' => 'Jane',
                'middle_name' => '',
                'last_name' => 'Smith',
                'date_of_birth' => '1990-05-15',
                'gender' => 'female',
                'email' => 'jane.smith@techsolutions.com',
                'phone' => '9876543211',
                'position' => 'Software Engineer',
                'joining_date' => '2024-01-01',
                'employee_type' => 'Full Time',
                'department' => 'Engineering',
                'basic_da' => 30000,
                'hra' => 15000,
                'medical_allowance' => 1500,
                'special_allowance' => 5000,
                'conveyance' => 1600,
                'statutory_bonus' => 1000,
                'el_encashment' => 0,
                'pf' => 1800,
                'esi' => 500,
                'status' => 'active'
            ]);

            $this->info('Employee created successfully');

            // Create attendance record for current month
            $currentYear = date('Y');
            $currentMonth = date('m');
            
            Attendance::create([
                'client_id' => $client->id,
                'employee_id' => $employee->id,
                'year' => $currentYear,
                'month' => $currentMonth,
                'total_days' => 31,
                'working_days' => 22,
                'holidays' => 4,
                'absent_days' => 1,
                'applied_leaves' => 1,
                'present_days' => 16,
                'payable_days' => 30
            ]);

            $this->info('Attendance record created successfully');

            // Create payroll record for current month
            Payroll::create([
                'client_id' => $client->id,
                'employee_id' => $employee->id,
                'year' => $currentYear,
                'month' => $currentMonth,
                'basic_da' => 30000,
                'hra' => 15000,
                'medical_allowance' => 1500,
                'special_allowance' => 5000,
                'conveyance' => 1600,
                'statutory_bonus' => 1000,
                'el_encashment' => 0,
                'pf' => 1800,
                'esi' => 500,
                'tds' => 2500,
                'ot' => 1000,
                'incentives' => 2000,
                'advance' => 0,
                'gross_total' => 57100,
                'deductions_total' => 4800,
                'net_salary' => 52300,
                'status' => 'pending'
            ]);

            $this->info('Payroll record created successfully');

            DB::commit();
            $this->info('All sample data added successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
