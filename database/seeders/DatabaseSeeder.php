<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Create a Sample Client
        $client = Client::create([
            'name' => 'John Smith',
            'company_name' => 'ABC Corporation',
            'email' => 'contact@abccorp.com',
            'phone' => '9876543210',
            'address' => '123 Business Park, Main Street',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'country' => 'India',
            'pincode' => '400001',
            'status' => 'active'
        ]);

        // Create Sample Employees
        $employees = [
            [
                'first_name' => 'John',
                'middle_name' => '',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '9876543201',
                'designation' => 'Software Developer',
                'dob' => '1990-01-01',
                'joining_date' => '2023-01-01',
                'status' => 'active',
                'basic_salary' => 50000
            ],
            [
                'first_name' => 'Jane',
                'middle_name' => '',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '9876543202',
                'designation' => 'HR Manager',
                'dob' => '1992-05-15',
                'joining_date' => '2023-02-01',
                'status' => 'active',
                'basic_salary' => 60000
            ]
        ];

        foreach ($employees as $employeeData) {
            $basicSalary = $employeeData['basic_salary'];
            unset($employeeData['basic_salary']);
            
            $employee = new Employee($employeeData);
            $employee->client_id = $client->id;
            $employee->save();

            // Create attendance record for current month
            $now = Carbon::now();
            $totalDays = $now->daysInMonth;
            $sundays = collect(range(1, $totalDays))->reduce(function ($carry, $day) use ($now) {
                return Carbon::create($now->year, $now->month, $day)->isSunday() ? $carry + 1 : $carry;
            }, 0);
            
            $workingDays = $totalDays - $sundays;

            // Create attendance record
            Attendance::create([
                'employee_id' => $employee->id,
                'month' => $now->month,
                'year' => $now->year,
                'total_days' => $totalDays,
                'working_days' => $workingDays,
                'holidays' => 2,
                'absent_days' => 1,
                'applied_leaves' => 1,
                'present_days' => $workingDays - 4, // Subtract holidays, absents, and leaves
                'payable_days' => $totalDays - 1 // Subtract absent days
            ]);

            // Create payroll record
            $hra = $basicSalary * 0.4;
            $specialAllowance = $basicSalary * 0.1;
            $pf = $basicSalary * 0.12;
            $tax = $basicSalary * 0.1;

            Payroll::create([
                'employee_id' => $employee->id,
                'month' => $now->month,
                'year' => $now->year,
                'basic_da' => $basicSalary,
                'hra' => $hra,
                'medical_allowance' => 1500,
                'special_allowance' => $specialAllowance,
                'conveyance' => 1600,
                'statutory_bonus' => 0,
                'el_encashment' => 0,
                'other_allowance' => 0,
                'incentives' => 0,
                'overtime' => 0,
                'pf' => $pf,
                'esi' => 0,
                'pt' => 200,
                'tds' => $tax,
                'advance' => 0,
                'total_earnings' => $basicSalary + $hra + 1500 + $specialAllowance + 1600,
                'total_deductions' => $pf + 200 + $tax,
                'net_payable' => ($basicSalary + $hra + 1500 + $specialAllowance + 1600) - ($pf + 200 + $tax),
                'status' => 'pending'
            ]);
        }
    }
}
