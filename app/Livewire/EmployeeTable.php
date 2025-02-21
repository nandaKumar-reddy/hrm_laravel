<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Client;
use Livewire\WithPagination;

class EmployeeTable extends Component
{
    use WithPagination;

    public $client;
    public $searchTerm = '';
    public $month;
    public $year;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['dates-updated' => 'updateDates'];

    public function mount(Client $client)
    {
        $this->client = $client;
        $this->month = request('month', date('m'));
        $this->year = request('year', date('Y'));
    }

    public function updateDates($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function render()
    {
        $employees = Employee::where('client_id', $this->client->id)
            ->select('id', 'first_name', 'last_name', 'email', 'phone', 'designation')
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.employee-table', [
            'employees' => $employees
        ]);
    }
}
