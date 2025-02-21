<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Attendance;
use Carbon\Carbon;

class PayrollTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $client;
    public $month;
    public $year;
    public $searchTerm = '';
    public $perPage = 10;
    
    // Arrays to store editable values
    public $incentives = [];
    public $overtime = [];
    public $tds = [];
    public $advance = [];

    protected $listeners = ['dates-updated' => 'updateDates', 'monthYearChanged' => 'updateMonthYear'];

    public function mount()
    {
        try {
          //  $this->client = auth()->user()->client;
            if (!$this->client) {
                throw new \Exception('Client not found');
            }

            $this->month = session('selected_month', Carbon::now()->month);
            $this->year = session('selected_year', Carbon::now()->year);
            $this->searchTerm = '';
            $this->perPage = 10;
            $this->incentives = [];
            $this->overtime = [];
            $this->tds = [];
            $this->advance = [];
            $this->initializeEditableFields();
        } catch (\Exception $e) {
            Log::error('Error in PayrollTable mount: ' . $e->getMessage());
            session()->flash('error', 'Failed to initialize payroll table: ' . $e->getMessage());
        }
    }

    public function initializeEditableFields()
    {
        try {
            if (!$this->client) {
                return;
            }

            $payrolls = Payroll::whereHas('employee', function($query) {
                    $query->where('client_id', $this->client->id);
                })
                ->where('month', $this->month)
                ->where('year', $this->year)
                ->get();

            foreach ($payrolls as $payroll) {
                if ($payroll && $payroll->id) {
                    $this->incentives[$payroll->id] = $payroll->incentives ?? 0;
                    $this->overtime[$payroll->id] = $payroll->ot ?? 0;
                    $this->tds[$payroll->id] = $payroll->tds ?? 0;
                    $this->advance[$payroll->id] = $payroll->advance ?? 0;
                }
            }
        } catch (\Exception $e) {
            Log::error('Error initializing editable fields: ' . $e->getMessage());
            session()->flash('error', 'Failed to load payroll data');
        }
    }

    public function getPayrollsProperty()
    {
        try {
            if (!$this->client) {
                return collect();
            }

            return Payroll::with(['employee.attendance' => function($query) {
                    $query->where('month', $this->month)
                          ->where('year', $this->year);
                }, 'employee.salaryDetails'])
                ->whereHas('employee', function($query) {
                    $query->where('client_id', $this->client->id)
                          ->where('status', 'active');
                })
                ->where('month', $this->month)
                ->where('year', $this->year)
                ->get();
        } catch (\Exception $e) {
            Log::error('Error in getPayrollsProperty: ' . $e->getMessage());
            return collect();
        }
    }

    public function updatePayroll($payrollId)
    {
        try {
            if (!$this->client || !$payrollId) {
                throw new \Exception('Invalid client or payroll ID');
            }

            DB::beginTransaction();

            $payroll = Payroll::with(['employee.attendance' => function($query) {
                    $query->where('month', $this->month)
                          ->where('year', $this->year);
                }, 'employee.salaryDetails'])
                ->whereHas('employee', function($query) {
                    $query->where('client_id', $this->client->id);
                })
                ->find($payrollId);

            if (!$payroll || !$payroll->employee) {
                throw new \Exception('Payroll or employee record not found');
            }

            $attendance = $payroll->employee->attendance->first();
            if (!$attendance) {
                throw new \Exception('Attendance record not found');
            }

            if (!$payroll->employee->salaryDetails) {
                throw new \Exception('Salary details not found');
            }

            // Update editable fields
            $payroll->incentives = $this->incentives[$payrollId] ?? 0;
            $payroll->ot = $this->overtime[$payrollId] ?? 0;
            $payroll->tds = $this->tds[$payrollId] ?? 0;
            $payroll->advance = $this->advance[$payrollId] ?? 0;

            // Recalculate payroll using AttendanceTable component
            $attendanceComponent = new AttendanceTable();
            $attendanceComponent->client = $this->client;
            $attendanceComponent->month = $this->month;
            $attendanceComponent->year = $this->year;

            $updatedPayroll = $attendanceComponent->calculatePayroll($payroll->employee, $attendance);
            
            if (!$updatedPayroll) {
                throw new \Exception('Failed to calculate payroll');
            }

            DB::commit();
            session()->flash('success', 'Payroll updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update payroll: ' . $e->getMessage());
            session()->flash('error', 'Failed to update payroll: ' . $e->getMessage());
        }
    }

    public function updatedIncentives($value, $payrollId)
    {
        if ($payrollId) {
            $this->updatePayroll($payrollId);
        }
    }

    public function updatedOvertime($value, $payrollId)
    {
        if ($payrollId) {
            $this->updatePayroll($payrollId);
        }
    }

    public function updatedTds($value, $payrollId)
    {
        if ($payrollId) {
            $this->updatePayroll($payrollId);
        }
    }

    public function updatedAdvance($value, $payrollId)
    {
        if ($payrollId) {
            $this->updatePayroll($payrollId);
        }
    }

    public function updateDates($month, $year)
    {
        try {
            if (!$this->client) {
                throw new \Exception('Client not found');
            }

            DB::beginTransaction();

            $this->month = $month;
            $this->year = $year;
            session(['selected_month' => $month, 'selected_year' => $year]);

            // Get all active employees with their salary details
            $employees = Employee::where('client_id', $this->client->id)
                ->where('status', 'active')
                ->with(['salaryDetails', 'attendance' => function($query) use ($month, $year) {
                    $query->where('month', $month)
                          ->where('year', $year);
                }])
                ->get();

            foreach ($employees as $employee) {
                if (!$employee->salaryDetails) {
                    continue;
                }

                // Get or create attendance record using AttendanceTable component
                $attendanceComponent = new AttendanceTable();
                $attendanceComponent->client = $this->client;
                $attendanceComponent->month = $month;
                $attendanceComponent->year = $year;
                
                // This will create attendance if it doesn't exist
                $attendanceComponent->datesUpdated($month, $year);

                // Refresh employee to get the new attendance record
                $employee->refresh();
                $attendance = $employee->attendance()
                    ->where('month', $month)
                    ->where('year', $year)
                    ->first();

                if ($attendance) {
                    // Calculate payroll using AttendanceTable component
                    $attendanceComponent->calculatePayroll($employee, $attendance);
                }
            }

            $this->initializeEditableFields();

            DB::commit();
            session()->flash('success', 'Month changed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update dates: ' . $e->getMessage());
            session()->flash('error', 'Failed to change month: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.payroll-table', [
            'payrolls' => $this->payrolls
        ]);
    }
}
