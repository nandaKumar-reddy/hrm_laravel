<?php

namespace App\Models;

use App\Traits\GeneratesId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use GeneratesId;

    protected $fillable = [
        'client_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'gender',
        'marital_status',
        'current_address',
        'department',
        'designation',
        'joining_date',
        'emp_type',
        'emp_category',
        'reporting',
        'aadhar_card',
        'pan_card',
        'status'
    ];

    // protected $dates = [
    //     'dob',
    //     'joining_date',
    //     'resignation_date'
    // ];

    // Optionally, if you wish to generate an employee ID automatically, you can update and uncomment this method.
    // protected static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($employee) {
    //         $client = Client::find($employee->client_id);
    //         $employee->employee_id = self::generateEmployeeId($client->name);
    //     });
    // }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function salaryDetails(): HasOne
    {
        return $this->hasOne(SalaryDetail::class);
    }

    public function bankDetails(): HasOne
    {
        return $this->hasOne(BankDetail::class);
    }
    
    public function statutoryDetails(): HasOne
    {
        return $this->hasOne(StatutoryDetails::class);
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function currentMonthAttendance()
    {
        return $this->attendance()
            ->where('month', date('m'))
            ->where('year', date('Y'))
            ->first();
    }

    public function getAttendanceForMonth($month, $year)
    {
        return $this->attendance()
            ->where('month', $month)
            ->where('year', $year)
            ->first();
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    public function currentMonthPayroll()
    {
        return $this->payrolls()
            ->where('month', date('m'))
            ->where('year', date('Y'))
            ->first();
    }

    public function getPayrollForMonth($month, $year)
    {
        return $this->payrolls()
            ->where('month', $month)
            ->where('year', $year)
            ->first();
    }

    public function getFullNameAttribute(): string
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name
        ])));
    }
}
