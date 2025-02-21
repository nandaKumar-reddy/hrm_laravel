<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatutoryDetails extends Model
{
    protected $fillable = [
        'employee_id',
        'uan_number',
        'esi_number',
        'emp_state_code',
        'nominee_name',
        'nominee_contact_num',
        'nominee_relation',
    ];

    /**
     * Get the employee that owns the statutory details.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
