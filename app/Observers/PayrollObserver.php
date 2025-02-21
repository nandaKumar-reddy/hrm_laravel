<?php

namespace App\Observers;

use App\Models\Payroll;

class PayrollObserver
{
    public function creating(Payroll $payroll)
    {
        $this->calculateTotals($payroll);
    }

    public function updating(Payroll $payroll)
    {
        $this->calculateTotals($payroll);
    }

    private function calculateTotals(Payroll $payroll)
    {
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
    }
}
