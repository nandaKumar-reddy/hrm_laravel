// Payroll calculations and display
$(document).ready(function() {
    // Get CSRF token
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    const $monthSelect = $('#payrollMonth');
    const $yearSelect = $('#payrollYear');
    const $loadBtn = $('#loadPayroll');
    const $payrollTable = $('#payrollTable');
    
    // Format number with 2 decimal places
    function formatNumber(number) {
        return parseFloat(number || 0).toFixed(2);
    }

    // Load payroll data
    function loadPayroll() {
        const year = parseInt($yearSelect.val());
        const month = parseInt($monthSelect.val());
        const clientId = $('#clientId').val();

        // Show loading state
        $loadBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            url: '/payroll/data',
            method: 'GET',
            data: { year, month, client_id: clientId },
            success: function(response) {
                if (response.success) {
                    const tbody = $payrollTable.find('tbody');
                    tbody.empty();

                    response.data.forEach(function(row) {
                        tbody.append(`
                            <tr>
                                <td>${row.employee_id}</td>
                                <td>${row.employee_name}</td>
                                <td>${formatNumber(row.basic_da)}</td>
                                <td>${formatNumber(row.hra)}</td>
                                <td>${formatNumber(row.medical_allowance)}</td>
                                <td>${formatNumber(row.special_allowance)}</td>
                                <td>${formatNumber(row.conveyance)}</td>
                                <td>${formatNumber(row.statutory_bonus)}</td>
                                <td>${formatNumber(row.el_encashment)}</td>
                                <td>${formatNumber(row.other_allowance)}</td>
                                <td>${formatNumber(row.incentives)}</td>
                                <td>${formatNumber(row.ot)}</td>
                                <td>${formatNumber(row.total_earnings)}</td>
                                <td>${formatNumber(row.pf)}</td>
                                <td>${formatNumber(row.esi)}</td>
                                <td>${formatNumber(row.pt)}</td>
                                <td>${formatNumber(row.tds)}</td>
                                <td>${formatNumber(row.advance)}</td>
                                <td>${formatNumber(row.deductions_total)}</td>
                                <td>${formatNumber(row.net_payable)}</td>
                                <td>
                                    <span class="badge badge-${row.status === 'paid' ? 'success' : 'warning'}">
                                        ${row.status}
                                    </span>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    toastr.error('Error loading payroll data');
                }
            },
            error: function(xhr) {
                let message = 'Error loading payroll data';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                toastr.error(message);
            },
            complete: function() {
                // Reset button state
                $loadBtn.prop('disabled', false).html('Load');
            }
        });
    }

    // Event listeners
    $loadBtn.on('click', loadPayroll);

    // Initial load if month and year are pre-selected
    if ($monthSelect.length && $yearSelect.length) {
        loadPayroll();
    }
});
