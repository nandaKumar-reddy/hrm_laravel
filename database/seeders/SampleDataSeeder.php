<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use Carbon\Carbon;
use Faker\Factory as Faker;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create sample clients
        $clients = [
            [
                'client_id' => 'CL001',
                'client_name' => 'ABC Technologies',
                'industry_type' => 'Information Technology',
                'email' => 'contact@abc-tech.com',
                'phone' => '9876543210',
                'contact_person_name' => 'John Doe',
                'gstin' => 'GST123456789',
                'pan' => 'ABCDE1234F',
                'tan' => 'TAN123456',
                'address' => '123 Tech Park, Bangalore',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'pin_code' => '560001',
                'status' => 'active'
            ],
            [
                'client_id' => 'CL002',
                'client_name' => 'XYZ Solutions',
                'industry_type' => 'Consulting',
                'email' => 'info@xyz-solutions.com',
                'phone' => '9876543220',
                'contact_person_name' => 'Jane Wilson',
                'gstin' => 'GST987654321',
                'pan' => 'FGHIJ5678K',
                'tan' => 'TAN654321',
                'address' => '456 Business Hub, Mumbai',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'pin_code' => '400001',
                'status' => 'active'
            ]
        ];

        foreach ($clients as $clientData) {
            $client = Client::create($clientData);
            
            // Create 7-8 random employees for each client
            $numEmployees = rand(7, 8);
            
            for ($i = 1; $i <= $numEmployees; $i++) {
                $firstName = $faker->firstName;
                $lastName = $faker->lastName;
                $basicDa = rand(25000, 80000);
                
                $employee = Employee::create([
                    'client_id' => $client->id,
                    'employee_id' => $client->client_id . sprintf('EMP%03d', $i),
                    'first_name' => $firstName,
                    'middle_name' => '',
                    'last_name' => $lastName,
                    'full_name' => $firstName . ' ' . $lastName,
                    'date_of_birth' => $faker->date('Y-m-d', '2000-01-01'),
                    'gender' => $faker->randomElement(['male', 'female', 'other']),
                    'email' => strtolower($firstName) . '.' . strtolower($lastName) . '@' . $faker->safeEmailDomain,
                    'phone' => $faker->numerify('##########'),
                    'address' => $faker->address,
                    'current_address' => $faker->address,
                    'city' => $client->city,
                    'state' => $client->state,
                    'pin_code' => $client->pin_code,
                    'designation' => $faker->jobTitle,
                    'joining_date' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                    'employee_type' => $faker->randomElement(['full-time', 'part-time', 'contract']),
                    'department' => $faker->randomElement(['Engineering', 'Sales', 'Marketing', 'HR', 'Finance']),
                    'reporting_to' => null,
                    'basic_da' => $basicDa,
                    'hra' => round($basicDa * 0.4),
                    'medical_allowance' => 1500,
                    'special_allowance' => rand(5000, 15000),
                    'conveyance' => 1600,
                    'statutory_bonus' => 2000,
                    'el_encashment' => 2000,
                    'other_allowance' => rand(2000, 8000),
                    'incentives' => rand(1000, 5000),
                    'ot' => 0,
                    'pf_enabled' => true,
                    'esi_enabled' => $basicDa < 21000, // ESI only for salary < 21000
                    'pt_enabled' => true,
                    'tds' => 0,
                    'advance' => 0,
                    'bank_name' => $faker->randomElement(['HDFC Bank', 'ICICI Bank', 'SBI', 'Axis Bank']),
                    'account_number' => $faker->numerify('##########'),
                    'ifsc_code' => $faker->regexify('[A-Z]{4}0[A-Z0-9]{6}'),
                    'branch_name' => $client->city . ' ' . $faker->words(2, true),
                    'uan' => $faker->numerify('############'),
                    'pf_number' => 'PF' . $faker->numerify('########'),
                    'esi_number' => 'ESI' . $faker->numerify('########'),
                    'pan_number' => $faker->regexify('[A-Z]{5}[0-9]{4}[A-Z]{1}'),
                    'status' => 'active'
                ]);

                // Create attendance for last 3 months
                for ($month = 1; $month <= 3; $month++) {
                    $date = Carbon::now()->subMonths($month - 1);
                    $workingDays = 22;
                    $holidays = 8;
                    $absentDays = rand(0, 3);
                    $appliedLeaves = rand(0, 2);
                    $presentDays = $workingDays - $absentDays - $appliedLeaves;
                    
                    $attendance = Attendance::create([
                        'employee_id' => $employee->id,
                        'year' => $date->year,
                        'month' => $date->month,
                        'total_days' => $date->daysInMonth,
                        'working_days' => $workingDays,
                        'holidays' => $holidays,
                        'absent_days' => $absentDays,
                        'applied_leaves' => $appliedLeaves,
                        'present_days' => $presentDays,
                        'payable_days' => $presentDays + $holidays + $appliedLeaves
                    ]);

                    // Calculate salary based on attendance
                    $payableDays = $attendance->payable_days;
                    $totalDays = $attendance->total_days;
                    $payableRatio = $payableDays / $totalDays;

                    // Calculate earnings
                    $earnedBasicDa = round($employee->basic_da * $payableRatio);
                    $earnedHra = round($employee->hra * $payableRatio);
                    $earnedAllowances = round(($employee->medical_allowance + $employee->special_allowance + 
                                             $employee->conveyance + $employee->other_allowance) * $payableRatio);
                    
                    // Calculate deductions
                    $pf = $employee->pf_enabled ? round($earnedBasicDa * 0.12) : 0;
                    $esi = $employee->esi_enabled ? round($earnedBasicDa * 0.0075) : 0;
                    $pt = $employee->pt_enabled ? 200 : 0;
                    
                    $totalEarnings = $earnedBasicDa + $earnedHra + $earnedAllowances + 
                                   $employee->incentives + $employee->ot;
                    $deductionsTotal = $pf + $esi + $pt + $employee->tds + $employee->advance;
                    $netPayable = $totalEarnings - $deductionsTotal;

                    Payroll::create([
                        'client_id' => $client->id,
                        'employee_id' => $employee->id,
                        'year' => $date->year,
                        'month' => $date->month,
                        'basic_da' => $earnedBasicDa,
                        'hra' => $earnedHra,
                        'medical_allowance' => round($employee->medical_allowance * $payableRatio),
                        'special_allowance' => round($employee->special_allowance * $payableRatio),
                        'conveyance' => round($employee->conveyance * $payableRatio),
                        'statutory_bonus' => round($employee->statutory_bonus * $payableRatio),
                        'el_encashment' => round($employee->el_encashment * $payableRatio),
                        'other_allowance' => round($employee->other_allowance * $payableRatio),
                        'incentives' => $employee->incentives,
                        'ot' => $employee->ot,
                        'pf' => $pf,
                        'esi' => $esi,
                        'pt' => $pt,
                        'tds' => $employee->tds,
                        'advance' => $employee->advance,
                        'total_earnings' => $totalEarnings,
                        'deductions_total' => $deductionsTotal,
                        'net_payable' => $netPayable,
                        'status' => 'paid',
                        'payment_date' => $date->endOfMonth()
                    ]);
                }
            }
        }
    }
}
