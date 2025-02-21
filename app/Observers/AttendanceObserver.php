<?php

namespace App\Observers;

use App\Models\Attendance;

class AttendanceObserver
{
    public function creating(Attendance $attendance)
    {
        $this->calculateDays($attendance);
    }

    public function updating(Attendance $attendance)
    {
        $this->calculateDays($attendance);
    }

    private function calculateDays(Attendance $attendance)
    {
        // Calculate present days: Working Days - (Absent Days + Holidays + Applied Leaves)
        $attendance->present_days = max(0, 
            $attendance->working_days - (
                $attendance->absent_days + 
                $attendance->holidays + 
                $attendance->applied_leaves
            )
        );

        // Calculate payable days: Total Days - Absent Days
        $attendance->payable_days = max(0, 
            $attendance->total_days - $attendance->absent_days
        );
    }
}
