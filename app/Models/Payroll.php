<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic_da',
        'hra',
        'medical_allowance',
        'special_allowance',
        'conveyance',
        'statutory_bonus',
        'el_encashment',
        'other_allowance',
        'incentives',
        'overtime',
        'pf',
        'esi',
        'pt',
        'tds',
        'advance',
        'total_earnings',
        'total_deductions',
        'net_payable',
        'status',
        'remarks'
    ];

    protected $casts = [
        'basic_da' => 'decimal:2',
        'hra' => 'decimal:2',
        'medical_allowance' => 'decimal:2',
        'special_allowance' => 'decimal:2',
        'conveyance' => 'decimal:2',
        'statutory_bonus' => 'decimal:2',
        'el_encashment' => 'decimal:2',
        'other_allowance' => 'decimal:2',
        'incentives' => 'decimal:2',
        'overtime' => 'decimal:2',
        'pf' => 'decimal:2',
        'esi' => 'decimal:2',
        'pt' => 'decimal:2',
        'tds' => 'decimal:2',
        'advance' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_payable' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($payroll) {
            // Calculate total earnings
            $payroll->total_earnings = array_sum([
                $payroll->basic_da,
                $payroll->hra,
                $payroll->medical_allowance,
                $payroll->special_allowance,
                $payroll->conveyance,
                $payroll->statutory_bonus,
                $payroll->el_encashment,
                $payroll->other_allowance,
                $payroll->incentives,
                $payroll->overtime
            ]);

            // Calculate total deductions
            $payroll->total_deductions = array_sum([
                $payroll->pf,
                $payroll->esi,
                $payroll->pt,
                $payroll->tds,
                $payroll->advance
            ]);

            // Calculate net payable
            $payroll->net_payable = $payroll->total_earnings - $payroll->total_deductions;
        });
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function getMonthYearAttribute(): string
    {
        return date('F Y', mktime(0, 0, 0, $this->month, 1, $this->year));
    }

    public function getEarningsBreakdownAttribute(): array
    {
        return [
            'Basic + DA' => $this->basic_da,
            'HRA' => $this->hra,
            'Medical Allowance' => $this->medical_allowance,
            'Special Allowance' => $this->special_allowance,
            'Conveyance' => $this->conveyance,
            'Statutory Bonus' => $this->statutory_bonus,
            'EL Encashment' => $this->el_encashment,
            'Other Allowance' => $this->other_allowance,
            'Incentives' => $this->incentives,
            'Overtime' => $this->overtime
        ];
    }

    public function getDeductionsBreakdownAttribute(): array
    {
        return [
            'PF' => $this->pf,
            'ESI' => $this->esi,
            'PT' => $this->pt,
            'TDS' => $this->tds,
            'Advance' => $this->advance
        ];
    }
}
