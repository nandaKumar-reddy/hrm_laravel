<?php

namespace App\Traits;

trait GeneratesId
{
    /**
     * Generate Client ID (Format: REKA-{increment})
     */
    public static function generateClientId()
    {
        $lastClient = static::orderBy('id', 'desc')->first();
        $increment = $lastClient ? (int)substr($lastClient->client_id, 5) + 1 : 1;
        return 'REKA-' . $increment;
    }

    /**
     * Generate Employee ID (Format: {client_prefix}-{increment})
     */
    public static function generateEmployeeId($clientName)
    {
        $prefix = strtoupper(substr($clientName, 0, 2));
        $lastEmployee = static::where('employee_id', 'like', $prefix . '-%')
            ->orderBy('id', 'desc')
            ->first();
        
        $increment = $lastEmployee ? 
            (int)substr($lastEmployee->employee_id, strlen($prefix) + 1) + 1 : 
            1;
        
        return $prefix . '-' . str_pad($increment, 3, '0', STR_PAD_LEFT);
    }
}
