<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Payroll Records</h5>
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="card-body">
        @if(!$client)
            <div class="alert alert-warning">
                No client information found. Please contact your administrator.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Basic + DA</th>
                            <th>HRA</th>
                            <th>Medical</th>
                            <th>Special</th>
                            <th>Conveyance</th>
                            <th>Statutory Bonus</th>
                            <th>EL</th>
                            <th>Other</th>
                            <th>Incentives</th>
                            <th>OT</th>
                            <th>PF</th>
                            <th>ESI</th>
                            <th>PT</th>
                            <th>TDS</th>
                            <th>Advance</th>
                            <th>Total Earnings</th>
                            <th>Total Deductions</th>
                            <th>Net Payable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls ?? [] as $payroll)
                            @if($payroll && $payroll->employee)
                                <tr>
                                    <td>{{ $payroll->employee->id ?? 'N/A' }}</td>
                                    <td>{{ optional($payroll->employee)->full_name ?? 'N/A' }}</td>
                                    <td class="text-end">{{ number_format($payroll->basic_da ?? 0, 2) }}</td>
                                    <td class="text-end">{{ number_format($payroll->hra ?? 0, 2) }}</td>
                                    <td class="text-end">{{ number_format($payroll->medical_allowance ?? 0, 2) }}</td>
                                    <td class="text-end">{{ number_format($payroll->special_allowance ?? 0, 2) }}</td>
                                    <td class="text-end">{{ number_format($payroll->conveyance ?? 0, 2) }}</td>
                                    <td class="text-end">{{ number_format($payroll->statutory_bonus ?? 0, 2) }}</td>
                                    <td class="text-end">{{ number_format($payroll->el_encashment ?? 0, 2) }}</td>
                                    <td class="text-end">{{ number_format($payroll->other_allowance ?? 0, 2) }}</td>
                                    <td>
                                        <input type="number" 
                                            class="form-control form-control-sm text-end"
                                            wire:model.live="incentives.{{ $payroll->id }}"
                                            min="0"
                                            step="0.01"
                                            style="width: 100px;"
                                            {{ !$payroll->id ? 'disabled' : '' }}>
                                    </td>
                                    <td>
                                        <input type="number" 
                                            class="form-control form-control-sm text-end"
                                            wire:model.live="overtime.{{ $payroll->id }}"
                                            min="0"
                                            step="0.01"
                                            style="width: 100px;"
                                            {{ !$payroll->id ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-end">{{ number_format($payroll->pf ?? 0, 2) }}</td>
                                    <td class="text-end">{{ number_format($payroll->esi ?? 0, 2) }}</td>
                                    <td class="text-end">{{ number_format($payroll->pt ?? 0, 2) }}</td>
                                    <td>
                                        <input type="number" 
                                            class="form-control form-control-sm text-end"
                                            wire:model.live="tds.{{ $payroll->id }}"
                                            min="0"
                                            step="0.01"
                                            style="width: 100px;"
                                            {{ !$payroll->id ? 'disabled' : '' }}>
                                    </td>
                                    <td>
                                        <input type="number" 
                                            class="form-control form-control-sm text-end"
                                            wire:model.live="advance.{{ $payroll->id }}"
                                            min="0"
                                            step="0.01"
                                            style="width: 100px;"
                                            {{ !$payroll->id ? 'disabled' : '' }}>
                                    </td>
                                    <td class="text-end font-weight-bold">{{ number_format($payroll->total_earnings ?? 0, 2) }}</td>
                                    <td class="text-end font-weight-bold">{{ number_format($payroll->total_deductions ?? 0, 2) }}</td>
                                    <td class="text-end font-weight-bold">{{ number_format($payroll->net_payable ?? 0, 2) }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="20" class="text-center">No payroll records found for the selected month</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
