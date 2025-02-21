<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Client;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('client');

        // Filter by client_id if provided
        if ($request->has('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $employees = $query->latest()->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function create(Request $request)
    {
        // If client_id is provided, only show that client
        if ($request->has('client_id')) {
            $clients = Client::where('id', $request->client_id)->get();
            $selectedClient = $request->client_id;
        } else {
            $clients = Client::all();
            $selectedClient = null;
        }

        return view('employees.create', compact('clients', 'selectedClient'));
    }

    public function store(Request $request)
    {
        if (!$request->has('client_id')) {
            $request->merge(['client_id' => $request->query('client_id')]);
        }
        $request->validate([
            // Basic Information
            'client_id'         => 'required|exists:clients,id',
            'first_name'        => 'required|string|max:255',
            'middle_name'       => 'nullable|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|email|unique:employees,email',
            'phone'             => 'required|string|max:20',
            'date_of_birth'     => 'required|date', // will be stored as "dob"
            'gender'            => 'required|in:male,female,other',
            'marital_status'    => 'nullable|string|max:500',
            'current_address'   => 'nullable|string|max:500',
            'department'        => 'required|string|max:255',
            'designation'       => 'required|string|max:255',
            'joining_date'      => 'required|date',
            'emp_type'          => 'required|string|max:255',
            'emp_category'      => 'required|string|max:255',
            'reporting'         => 'nullable|string|max:255',

            // Salary Details
            'basic_da'          => 'required|numeric|min:0',
            'hra'               => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'conveyance'        => 'nullable|numeric|min:0',
            'statutory_bonus'   => 'nullable|numeric|min:0',
            'el_encashment'     => 'nullable|numeric|min:0',
            'special_allowance' => 'nullable|numeric|min:0',
            'other_allowance'   => 'nullable|numeric|min:0',

            // Bank Details
            'bank_name'         => 'required|string|max:255',
            'act_holder_name'   => 'required|string|max:255',
            'account_number'    => 'required|string|max:255',
            'ifsc_code'         => 'required|string|max:255',
            'branch_name'       => 'nullable|string|max:255',
            'upi_id'            => 'nullable|string|max:255',

            // Documents
            'aadhar_card'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pan_card'          => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',

            // Statutory Details
            'uan_number'          => 'nullable|string|max:255',
            'esi_number'          => 'nullable|string|max:255',
            'emp_state_code'      => 'nullable|string|max:255',
            'nominee_name'        => 'nullable|string|max:255',
            'nominee_contact_num' => 'nullable|string|max:20',
            'nominee_relation'    => 'nullable|string|max:255',
        ]);

        // Define the destination path for file storage
        $destinationPath = storage_path('images');

        // Store Aadhar Card
        $aadharFilename = time() . '_aadhar.' . $request->file('aadhar_card')->getClientOriginalExtension();
        $request->file('aadhar_card')->move($destinationPath, $aadharFilename);
        $aadharPath = 'images/' . $aadharFilename; // Relative path stored in the DB

        // Store PAN Card
        $panFilename = time() . '_pan.' . $request->file('pan_card')->getClientOriginalExtension();
        $request->file('pan_card')->move($destinationPath, $panFilename);
        $panPath = 'images/' . $panFilename; // Relative path stored in the DB

        // Create employee record in the "employees" table
        $employee = Employee::create([
            'client_id'       => $request->client_id,
            'first_name'      => $request->first_name,
            'middle_name'     => $request->middle_name,
            'last_name'       => $request->last_name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'dob'             => $request->date_of_birth,  // mapping date_of_birth to "dob"
            'gender'          => $request->gender,
            'marital_status'  => $request->marital_status,
            'current_address' => $request->current_address,
            'department'      => $request->department,
            'designation'     => $request->designation,
            'joining_date'    => $request->joining_date,
            'emp_type'        => $request->emp_type,
            'emp_category'    => $request->emp_category,
            'reporting'       => $request->reporting,
            'aadhar_card'     => $aadharPath,
            'pan_card'        => $panPath,
            'status'          => 'active'
        ]);

        // Save Salary Details in the "salary_details" table
        \App\Models\SalaryDetail::create([
            'employee_id'        => $employee->id,
            'basic_da'           => $request->basic_da,
            'hra'                => $request->hra,
            'medical_allowance'  => $request->medical_allowance,
            'conveyance'         => $request->conveyance,
            'statutory_bonus'    => $request->statutory_bonus,
            'el_encashment'      => $request->el_encashment,
            'special_allowance'  => $request->special_allowance,
            'other_allowance'    => $request->other_allowance,
        ]);

        // Save Bank Details in the "bank_details" table
        \App\Models\BankDetail::create([
            'employee_id'     => $employee->id,
            'bank_name'       => $request->bank_name,
            'act_holder_name' => $request->act_holder_name,
            'account_number'  => $request->account_number,
            'ifsc_code'       => $request->ifsc_code,
            'branch_name'     => $request->branch_name,
            'upi_id'          => $request->upi_id,
        ]);

        // Save Statutory Details in the "statutory_details" table
        \App\Models\StatutoryDetails::create([
            'employee_id'         => $employee->id,
            'uan_number'          => $request->uan_number,
            'esi_number'          => $request->esi_number,
            'emp_state_code'      => $request->emp_state_code,
            'nominee_name'        => $request->nominee_name,
            'nominee_contact_num' => $request->nominee_contact_num,
            'nominee_relation'    => $request->nominee_relation,
        ]);

        return redirect()->route('clients.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        try {
            $currentDate = Carbon::now();
            $currentYear = $currentDate->year;
            $currentMonth = $currentDate->month;

            // Get attendance for current month
            $attendance = Attendance::where('employee_id', $employee->id)
                ->where('year', $currentYear)
                ->where('month', $currentMonth)
                ->first();

            // If no attendance record exists, create one
            if (!$attendance) {
                $totalDays = Carbon::create($currentYear, $currentMonth)->daysInMonth;
                $workingDays = 0;

                // Calculate working days (excluding weekends)
                for ($day = 1; $day <= $totalDays; $day++) {
                    $date = Carbon::create($currentYear, $currentMonth, $day);
                    if (!in_array($date->dayOfWeek, [0, 6])) { // Not Saturday or Sunday
                        $workingDays++;
                    }
                }

                $attendance = Attendance::create([
                    'employee_id' => $employee->id,
                    'client_id' => $employee->client_id,
                    'year' => $currentYear,
                    'month' => $currentMonth,
                    'total_days' => $totalDays,
                    'working_days' => $workingDays,
                    'holidays' => 0,
                    'absent_days' => 0,
                    'applied_leaves' => 0,
                    'present_days' => $workingDays,
                    'payable_days' => $workingDays
                ]);
            }

            // Get payroll information
            $payroll = $employee->payrolls()
                ->where('year', $currentYear)
                ->where('month', $currentMonth)
                ->first();

            return view('employees.show', compact('employee', 'attendance', 'payroll'));
        } catch (\Exception $e) {
            \Log::error('Error showing employee: ' . $e->getMessage());
            return redirect()->route('employees.index')
                ->with('error', 'Error loading employee data: ' . $e->getMessage());
        }
    }


    public function edit(Employee $employee)
    {

        $employee->load(['salaryDetails', 'bankDetails', 'statutoryDetails']);
        // dd( $employee->load(['salaryDetails', 'bankDetails', 'statutoryDetails']));die;
        $clients = Client::all();
        return view('employees.edit', compact('employee', 'clients'));
    }

    public function update(Request $request, Employee $employee)
    {
        //  dd($request->all());die;
        // Validate input data.
        $request->validate([
            // Basic Information (employees)
            'client_id'         => 'nullable|exists:clients,id',
            'first_name'        => 'nullable|string|max:255',
            'middle_name'       => 'nullable|string|max:255',
            'last_name'         => 'nullable|string|max:255',
            'email'             => 'nullable|email|unique:employees,email,' . $employee->id,
            'phone'             => 'nullable|string|max:20',
            'date_of_birth'     => 'nullable|date',  // mapped to "dob"
            'gender'            => 'nullable|in:male,female,other',
            'marital_status'    => 'nullable|string|max:500',
            'current_address'   => 'nullable|string|max:500',
            'department'        => 'nullable|string|max:255',
            'designation'       => 'nullable|string|max:255',
            'joining_date'      => 'nullable|date',
            'emp_type'          => 'nullable|string|max:255',
            'emp_category'      => 'nullable|string|max:255',
            'reporting'         => 'nullable|string|max:255',
            'status'            => 'nullable|string|max:255',

            // Salary Details (salary_details)
            'basic_da'          => 'required|numeric|min:0',
            'hra'               => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'conveyance'        => 'nullable|numeric|min:0',
            'statutory_bonus'   => 'nullable|numeric|min:0',
            'el_encashment'     => 'nullable|numeric|min:0',
            'special_allowance' => 'nullable|numeric|min:0',
            'other_allowance'   => 'nullable|numeric|min:0',

            // Bank Details (bank_details)
            'bank_name'         => 'required|string|max:255',
            'act_holder_name'   => 'required|string|max:255',
            'account_number'    => 'required|string|max:255',
            'ifsc_code'         => 'required|string|max:255',
            'branch_name'       => 'nullable|string|max:255',
            'upi_id'            => 'nullable|string|max:255',

            // Documents (optional on update)
            'aadhar_card'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pan_card'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            // Statutory Details (statutory_details)
            'uan_number'          => 'nullable|string|max:255',
            'esi_number'          => 'nullable|string|max:255',
            'emp_state_code'      => 'nullable|string|max:255',
            'nominee_name'        => 'nullable|string|max:255',
            'nominee_contact_num' => 'nullable|string|max:20',
            'nominee_relation'    => 'nullable|string|max:255',
        ]);

        // Prepare employee data.
        $employeeData = $request->only([
            'client_id',
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'phone',
            'gender',
            'marital_status',
            'current_address',
            'department',
            'designation',
            'joining_date',
            'emp_type',
            'emp_category',
            'reporting'
        ]);
        // Map date_of_birth to dob.
        $employeeData['dob'] = $request->input('date_of_birth');

        // Process file uploads if new files are provided.
        if ($request->hasFile('aadhar_card')) {
            $destinationPath = storage_path('images');
            $aadharFilename = time() . '_aadhar.' . $request->file('aadhar_card')->getClientOriginalExtension();
            $request->file('aadhar_card')->move($destinationPath, $aadharFilename);
            $employeeData['aadhar_card'] = 'images/' . $aadharFilename;
        }
        if ($request->hasFile('pan_card')) {
            $destinationPath = storage_path('images');
            $panFilename = time() . '_pan.' . $request->file('pan_card')->getClientOriginalExtension();
            $request->file('pan_card')->move($destinationPath, $panFilename);
            $employeeData['pan_card'] = 'images/' . $panFilename;
        }

        // Update the employee record.
        $employee->update($employeeData);

        // Update or create Salary Details.
        $salaryData = $request->only([
            'basic_da',
            'hra',
            'medical_allowance',
            'conveyance',
            'statutory_bonus',
            'el_encashment',
            'special_allowance',
            'other_allowance'
        ]);
        if ($employee->salaryDetails) {
            $employee->salaryDetails->update($salaryData);
        } else {
            $salaryData['employee_id'] = $employee->id;
            \App\Models\SalaryDetail::create($salaryData);
        }

        // Update or create Bank Details.
        $bankData = $request->only([
            'bank_name',
            'act_holder_name',
            'account_number',
            'ifsc_code',
            'branch_name',
            'upi_id'
        ]);
        if ($employee->bankDetails) {
            $employee->bankDetails->update($bankData);
        } else {
            $bankData['employee_id'] = $employee->id;
            \App\Models\BankDetail::create($bankData);
        }

        // Update or create Statutory Details.
        $statutoryData = $request->only([
            'uan_number',
            'esi_number',
            'emp_state_code',
            'nominee_name',
            'nominee_contact_num',
            'nominee_relation'
        ]);
        if ($employee->statutoryDetails) {
            $employee->statutoryDetails->update($statutoryData);
        } else {
            $statutoryData['employee_id'] = $employee->id;
            \App\Models\StatutoryDetails::create($statutoryData);
        }

        return redirect()->route('employees.show', $employee)
            ->with('success', 'Employee updated successfully.');
    }



    public function destroy(Employee $employee)
    {
        // Delete associated documents
        Storage::delete([
            $employee->aadhar_card_path,
            $employee->pan_card_path,
            $employee->id_proof_path
        ]);

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function getData(Request $request)
    {
        try {
            $clientId = $request->input('client_id');
            $month = $request->input('month', date('m'));
            $year = $request->input('year', date('Y'));

            $employees = Employee::where('client_id', $clientId)
                ->select(
                    'id',
                    //'employee_id',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'designation',
                    'email',
                    'phone'
                )
                ->whereHas('payrolls', function ($query) use ($month, $year) {
                    $query->where('month', $month)
                        ->where('year', $year);
                })
                ->orWhere(function ($query) use ($clientId) {
                    $query->where('client_id', $clientId)
                        ->doesntHave('payrolls');
                })
                ->get();

            return response()->json([
                'success' => true,
                'data' => $employees
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load employees data'
            ], 500);
        }
    }
}
