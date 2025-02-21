<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

class AttendanceTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $client;
    public $month;
    public $year;
    public $totalDays;
    public $workingDays;
    public $perPage = 10;
    public $holidays = [];
    public $absentDays = [];
    public $appliedLeaves = [];
    public $payrollData = [];

    protected $listeners = ['dates-updated' => 'datesUpdated'];

    public function mount($client)
    {
        $this->client = $client;
        $this->month = session('selected_month', Carbon::now()->month);
        $this->year = session('selected_year', Carbon::now()->year);
        $this->initializeData();
    }

    public function datesUpdated($month, $year)
    {
        try {
            DB::beginTransaction();

            $this->month = $month;
            $this->year = $year;
            session(['selected_month' => $month, 'selected_year' => $year]);

            // Get total days and working days for the new month
            $this->totalDays = $this->getTotalDays();
            $this->workingDays = $this->getWorkingDays();

            // Get all active employees
            $employees = Employee::where('client_id', $this->client->id)
                ->where('status', 'active')
                ->get();

            foreach ($employees as $employee) {
                // Check if attendance record exists for the new month
                $attendance = Attendance::where('employee_id', $employee->id)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->first();

                if (!$attendance) {
                    // Create new attendance record with default values
                    $attendance = new Attendance([
                        'employee_id' => $employee->id,
                        'month' => $month,
                        'year' => $year,
                        'total_days' => $this->totalDays,
                        'working_days' => $this->workingDays,
                        'holidays' => 0, // Default 0
                        'absent_days' => 0, // Default 0
                        'applied_leaves' => 0, // Default 0
                    ]);

                    // Calculate present days and payable days
                    $attendance = $this->recalculateAttendance($attendance);
                    $attendance->save();
                }

                // Reset the arrays for the new attendance records
                $this->holidays[$attendance->id] = $attendance->holidays;
                $this->absentDays[$attendance->id] = $attendance->absent_days;
                $this->appliedLeaves[$attendance->id] = $attendance->applied_leaves;

                // Calculate and store payroll for the new month
                if ($employee->salaryDetails) {
                    $this->calculatePayroll($employee, $attendance);
                }
            }

            DB::commit();
            $this->resetPage();
            
            session()->flash('success', 'Month changed successfully. New attendance records created.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update dates: ' . $e->getMessage());
            session()->flash('error', 'Failed to change month: ' . $e->getMessage());
        }
    }

    private function initializeData()
    {
        try {
            DB::beginTransaction();

            $this->totalDays = $this->getTotalDays();
            $this->workingDays = $this->getWorkingDays();

            // Get all active employees
            $employees = Employee::where('client_id', $this->client->id)
                ->where('status', 'active')
                ->get();

            foreach ($employees as $employee) {
                // Get or create attendance record
                $attendance = Attendance::firstOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'month' => $this->month,
                        'year' => $this->year
                    ],
                    [
                        'total_days' => $this->totalDays,
                        'working_days' => $this->workingDays,
                        'holidays' => 0,
                        'absent_days' => 0,
                        'applied_leaves' => 0
                    ]
                );

                // Calculate dependent fields
                $attendance = $this->recalculateAttendance($attendance);
                $attendance->save();

                // Initialize the arrays with current values
                $this->holidays[$attendance->id] = $attendance->holidays;
                $this->absentDays[$attendance->id] = $attendance->absent_days;
                $this->appliedLeaves[$attendance->id] = $attendance->applied_leaves;

                // Calculate and store payroll
                if ($employee->salaryDetails) {
                    $this->calculatePayroll($employee, $attendance);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to initialize data: ' . $e->getMessage());
            session()->flash('error', 'Failed to initialize attendance: ' . $e->getMessage());
        }
    }

    private function getTotalDays()
    {
        return Carbon::create($this->year, $this->month)->daysInMonth;
    }

    private function getWorkingDays()
    {
        $date = Carbon::create($this->year, $this->month, 1);
        $lastDay = $date->copy()->endOfMonth();
        $workingDays = 0;

        while ($date->lte($lastDay)) {
            if (!$date->isSunday()) {
                $workingDays++;
            }
            $date->addDay();
        }

        return $workingDays;
    }

    private function calculatePresentDays($workingDays, $absentDays, $holidays, $appliedLeaves)
    {
        // Present Days = Working Days - (Absent Days + Holidays + Applied Leaves)
        return max(0, $workingDays - ($absentDays + $holidays + $appliedLeaves));
    }

    private function calculatePayableDays($totalDays, $absentDays)
    {
        // Payable Days = Total Days - Absent Days
        return max(0, $totalDays - $absentDays);
    }

    private function recalculateAttendance($attendance)
    {
        // Get working days (excluding Sundays)
        $date = Carbon::create($this->year, $this->month, 1);
        $lastDay = $date->copy()->endOfMonth();
        $workingDays = 0;

        while ($date->lte($lastDay)) {
            if (!$date->isSunday()) {
                $workingDays++;
            }
            $date->addDay();
        }

        $attendance->working_days = $workingDays;
        
        // Calculate Present Days = Working Days - (Absent Days + Holidays + Applied Leaves)
        $attendance->present_days = $this->calculatePresentDays(
            $workingDays,
            $attendance->absent_days,
            $attendance->holidays,
            $attendance->applied_leaves
        );
        
        // Calculate Payable Days = Total Days - Absent Days
        $attendance->payable_days = $this->calculatePayableDays(
            $attendance->total_days,
            $attendance->absent_days
        );

        return $attendance;
    }

    public function updatedHolidays($value, $attendanceId)
    {
        $this->updateAttendance($attendanceId, 'holidays', $value);
    }

    public function updatedAbsentDays($value, $attendanceId)
    {
        $this->updateAttendance($attendanceId, 'absent_days', $value);
    }

    public function updatedAppliedLeaves($value, $attendanceId)
    {
        $this->updateAttendance($attendanceId, 'applied_leaves', $value);
    }

    private function updateAttendance($attendanceId, $field, $value)
    {
        try {
            DB::beginTransaction();

            $attendance = Attendance::find($attendanceId);
            if (!$attendance) {
                throw new \Exception('Attendance record not found');
            }

            // Update the specific field
            $attendance->$field = max(0, intval($value)); // Ensure non-negative integer
            
            // Recalculate all dependent fields
            $attendance = $this->recalculateAttendance($attendance);
            
            $attendance->save();

            // Recalculate payroll after attendance update
            $employee = Employee::with('salaryDetails')->find($attendance->employee_id);
            if ($employee) {
                $this->calculatePayroll($employee, $attendance);
            }

            DB::commit();
            session()->flash('success', 'Attendance updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update attendance: ' . $e->getMessage());
            session()->flash('error', 'Failed to update attendance: ' . $e->getMessage());
        }
    }

    private function calculatePayroll($employee, $attendance)
    {
        try {
            if (!$employee->salaryDetails) {
                return null;
            }

            $salary = $employee->salaryDetails;
            $totalDays = $attendance->total_days;
            $payableDays = $attendance->payable_days;

            // Calculate prorated fixed components
            $proratedBasicDA = round(($salary->basic_da * $payableDays) / $totalDays, 2);
            $proratedHRA = round(($salary->hra * $payableDays) / $totalDays, 2);
            $proratedMedical = round(($salary->medical_allowance * $payableDays) / $totalDays, 2);
            $proratedSpecial = round(($salary->special_allowance * $payableDays) / $totalDays, 2);
            $proratedConveyance = round(($salary->conveyance * $payableDays) / $totalDays, 2);
            $proratedBonus = round(($salary->statutory_bonus * $payableDays) / $totalDays, 2);
            $proratedEL = round(($salary->el_encashment * $payableDays) / $totalDays, 2);
            $proratedOther = round(($salary->other_allowance * $payableDays) / $totalDays, 2);

            // Calculate total fixed earnings (prorated)
            $totalFixedEarnings = $proratedBasicDA + 
                                $proratedHRA + 
                                $proratedMedical + 
                                $proratedSpecial +
                                $proratedConveyance + 
                                $proratedBonus + 
                                $proratedEL + 
                                $proratedOther;

            // Add variable components (not prorated)
            $incentives = $salary->incentives ?? 0;
            $overtime = $salary->overtime ?? 0;

            // Calculate gross salary
            $grossSalary = $totalFixedEarnings + $incentives + $overtime;

            // Calculate PF on prorated basic components
            $pfBaseAmount = $proratedBasicDA + 
                          $proratedMedical + 
                          $proratedSpecial +
                          $proratedConveyance + 
                          $proratedBonus + 
                          $proratedEL + 
                          $proratedOther;

            // Cap PF base at prorated 15,000
            $pfCappedBase = min($pfBaseAmount, (15000 * $payableDays) / $totalDays);
            $pf = round($pfCappedBase * 0.12, 2);

            // ESI Calculation (on gross excluding incentives, if < 21,000)
            $esi = ($grossSalary < 21000) ? round(($grossSalary - $incentives) * 0.0075, 2) : 0;

            // PT based on gross salary
            $pt = ($grossSalary >= 25000) ? 200 : 0;

            // Other deductions (not prorated)
            $tds = $salary->tds ?? 0;
            $advance = $salary->advance ?? 0;

            // Calculate total deductions
            $totalDeductions = $pf + $esi + $pt + $tds + $advance;

            // Calculate net salary
            $netSalary = $grossSalary - $totalDeductions;

            // Update or create payroll record
            $payroll = Payroll::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'month' => $this->month,
                    'year' => $this->year
                ],
                [
                    'basic_da' => $proratedBasicDA,
                    'hra' => $proratedHRA,
                    'medical_allowance' => $proratedMedical,
                    'special_allowance' => $proratedSpecial,
                    'conveyance' => $proratedConveyance,
                    'statutory_bonus' => $proratedBonus,
                    'el_encashment' => $proratedEL,
                    'other_allowance' => $proratedOther,
                    'incentives' => $incentives,
                    'ot' => $overtime,
                    'pf' => $pf,
                    'esi' => $esi,
                    'pt' => $pt,
                    'tds' => $tds,
                    'advance' => $advance,
                    'total_earnings' => round($grossSalary, 2),
                    'total_deductions' => round($totalDeductions, 2),
                    'net_payable' => round($netSalary, 2)
                ]
            );

            return $payroll;
        } catch (\Exception $e) {
            Log::error('Error in calculatePayroll: ' . $e->getMessage());
            return null;
        }
    }

    public function getEmployeesProperty()
    {
        return Employee::where('client_id', $this->client->id)
            ->where('status', 'active')
            ->with(['attendance' => function($query) {
                $query->where('month', $this->month)
                      ->where('year', $this->year);
            }, 'salaryDetails'])
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.attendance-table', [
            'employees' => $this->employees
        ]);
    }
}
