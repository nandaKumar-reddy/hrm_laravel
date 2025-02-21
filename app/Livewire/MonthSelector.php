<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class MonthSelector extends Component
{
    public $selectedMonth;
    public $selectedYear;

    public function mount()
    {
        $this->selectedMonth = session('selected_month', Carbon::now()->month);
        $this->selectedYear = session('selected_year', Carbon::now()->year);
    }

    public function updatedSelectedMonth($value)
    {
        session(['selected_month' => $value]);
        $this->dispatch('dates-updated', month: $value, year: $this->selectedYear);
    }

    public function updatedSelectedYear($value)
    {
        session(['selected_year' => $value]);
        $this->dispatch('dates-updated', month: $this->selectedMonth, year: $value);
    }

    public function render()
    {
        return view('livewire.month-selector');
    }
}
