<div class="card shadow-sm mb-3">
    <div class="card-body py-2">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-2">
                    <select class="form-select" wire:model.live="selectedMonth">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                            </option>
                        @endfor
                    </select>
                    <select class="form-select" wire:model.live="selectedYear">
                        @for ($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                            <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-8 text-end">
                <button class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-printer"></i> Print
                </button>
                <button class="btn btn-outline-success btn-sm ms-2">
                    <i class="bi bi-file-excel"></i> Export
                </button>
            </div>
        </div>
    </div>
</div>
