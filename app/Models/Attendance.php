<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'total_days',
        'working_days',
        'holidays',
        'absent_days',
        'applied_leaves',
        'present_days',
        'payable_days'
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'total_days' => 'integer',
        'working_days' => 'integer',
        'applied_leaves' => 'integer',
        'holidays' => 'integer',
        'absent_days' => 'integer',
        'present_days' => 'integer',
        'payable_days' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($attendance) {
            // Present Days = Working Days - (Absent Days + Holidays + Applied Leaves)
            $attendance->present_days = max(0, 
                $attendance->working_days - (
                    $attendance->absent_days + 
                    $attendance->holidays + 
                    $attendance->applied_leaves
                )
            );
            
            // Payable Days = Total Days - Absent Days
            $attendance->payable_days = max(0, 
                $attendance->total_days - $attendance->absent_days
            );
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
}
