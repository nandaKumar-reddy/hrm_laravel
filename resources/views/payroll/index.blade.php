@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payroll Management</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="payrollMonth" class="form-control">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="payrollYear" class="form-control">
                                @for($i = date('Y'); $i >= date('Y')-2; $i--)
                                    <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="loadPayroll" class="btn btn-primary">Load</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="payrollTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Name</th>
                                    <th>Basic + DA</th>
                                    <th>HRA</th>
                                    <th>Medical</th>
                                    <th>Special</th>
                                    <th>Conveyance</th>
                                    <th>Statutory</th>
                                    <th>EL</th>
                                    <th>Other</th>
                                    <th>Incentives</th>
                                    <th>OT</th>
                                    <th>Total Earnings</th>
                                    <th>PF</th>
                                    <th>ESI</th>
                                    <th>PT</th>
                                    <th>TDS</th>
                                    <th>Advance</th>
                                    <th>Total Deductions</th>
                                    <th>Net Payable</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/payroll.js') }}"></script>
@endsection
