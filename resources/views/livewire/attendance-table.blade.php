@php
    $currentMonth = $month;
    $currentYear = $year;
@endphp

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Attendance Records</h5>
    </div>

    <div class="card-body">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Total Days</th>
                        <th>Working Days</th>
                        <th>Holidays</th>
                        <th>Absent Days</th>
                        <th>Applied Leaves</th>
                        <th>Present Days</th>
                        <th>Payable Days</th>
                    </tr>
                </thead>
                <tbody>
                    @if($employees->count() > 0)
                        @foreach($employees as $employee)
                            @php
                                $attendance = $employee->attendance->where('month', $currentMonth)->where('year', $currentYear)->first();
                            @endphp
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->full_name }}</td>
                                <td>{{ $attendance->total_days }}</td>
                                <td>{{ $attendance->working_days }}</td>
                                <td>
                                    <input type="number" 
                                        class="form-control form-control-sm"
                                        wire:model.live="holidays.{{ $attendance->id }}"
                                        min="0"
                                        max="{{ $attendance->total_days }}"
                                        style="width: 70px;">
                                </td>
                                <td>
                                    <input type="number" 
                                        class="form-control form-control-sm"
                                        wire:model.live="absentDays.{{ $attendance->id }}"
                                        min="0"
                                        max="{{ $attendance->total_days }}"
                                        style="width: 70px;">
                                </td>
                                <td>
                                    <input type="number" 
                                        class="form-control form-control-sm"
                                        wire:model.live="appliedLeaves.{{ $attendance->id }}"
                                        min="0"
                                        max="{{ $attendance->total_days }}"
                                        style="width: 70px;">
                                </td>
                                <td>{{ $attendance->present_days }}</td>
                                <td>{{ $attendance->payable_days }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center">No employees found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $employees->links() }}
        </div>
    </div>
</div>
