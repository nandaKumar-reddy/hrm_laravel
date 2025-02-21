<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalaryDetail extends Model
{
    protected $fillable = [
        'employee_id',
        'basic_da',
        'hra',
        'medical_allowance',
        'special_allowance',
        'conveyance',
        'statutory_bonus',
        'el_encashment',
        'other_allowance'
    ];

    protected $casts = [
        'basic_da' => 'decimal:2',
        'hra' => 'decimal:2',
        'medical_allowance' => 'decimal:2',
        'special_allowance' => 'decimal:2',
        'conveyance' => 'decimal:2',
        'statutory_bonus' => 'decimal:2',
        'el_encashment' => 'decimal:2',
        'other_allowance' => 'decimal:2'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
