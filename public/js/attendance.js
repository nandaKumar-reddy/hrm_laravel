// Attendance calculations
$(document).ready(function() {
    // Get CSRF token
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    const $monthSelect = $('#attendanceMonth');
    const $yearSelect = $('#attendanceYear');
    const $loadBtn = $('#loadAttendance');
    
    // Table cells and inputs
    const $totalDaysCell = $('#totalDays');
    const $workingDaysCell = $('#workingDays');
    const $holidaysInput = $('#holidays');
    const $absentDaysInput = $('#absentDays');
    const $appliedLeavesInput = $('#appliedLeaves');
    const $presentDaysCell = $('#presentDays');
    const $payableDaysCell = $('#payableDays');

    // Get employee ID from the data attribute
    const employeeId = $('#attendance').data('employee-id');

    // Load attendance data
    function loadAttendance() {
        const year = parseInt($yearSelect.val());
        const month = parseInt($monthSelect.val());

        // Show loading state
        $loadBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        $('.attendance-input').prop('disabled', true);

        $.ajax({
            url: `/attendance/employee/${employeeId}`,
            method: 'GET',
            data: { year, month },
            success: function(response) {
                if (response.success) {
                    updateDisplayValues(response.data);
                    // Enable inputs
                    $('.attendance-input').prop('disabled', false);
                } else {
                    toastr.error('Error loading attendance data');
                }
            },
            error: function(xhr) {
                let message = 'Error loading attendance data';
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

    // Update display values
    function updateDisplayValues(data) {
        $totalDaysCell.text(data.total_days || 0);
        $workingDaysCell.text(data.working_days || 0);
        $holidaysInput.val(data.holidays || 0);
        $absentDaysInput.val(data.absent_days || 0);
        $appliedLeavesInput.val(data.applied_leaves || 0);
        $presentDaysCell.text(data.present_days || 0);
        $payableDaysCell.text(data.payable_days || 0);
    }

    // Calculate local updates
    function calculateLocalUpdates() {
        const workingDays = parseInt($workingDaysCell.text()) || 0;
        const holidays = parseInt($holidaysInput.val()) || 0;
        const absentDays = parseInt($absentDaysInput.val()) || 0;
        const appliedLeaves = parseInt($appliedLeavesInput.val()) || 0;

        // Calculate present days: Working Days - (Holidays + Absent Days + Applied Leaves)
        const presentDays = Math.max(0, workingDays - (holidays + absentDays + appliedLeaves));
        $presentDaysCell.text(presentDays);

        // Calculate payable days: Total Days - Absent Days
        const totalDays = parseInt($totalDaysCell.text()) || 0;
        const payableDays = Math.max(0, totalDays - absentDays);
        $payableDaysCell.text(payableDays);
    }

    // Update attendance data
    function updateAttendance() {
        const year = parseInt($yearSelect.val());
        const month = parseInt($monthSelect.val());
        const holidays = parseInt($holidaysInput.val()) || 0;
        const absentDays = parseInt($absentDaysInput.val()) || 0;
        const appliedLeaves = parseInt($appliedLeavesInput.val()) || 0;

        $.ajax({
            url: `/attendance/employee/${employeeId}`,
            method: 'POST',
            data: {
                year,
                month,
                holidays,
                absent_days: absentDays,
                applied_leaves: appliedLeaves
            },
            success: function(response) {
                if (response.success) {
                    updateDisplayValues(response.data);
                    toastr.success('Attendance updated successfully');
                } else {
                    toastr.error('Error updating attendance');
                }
            },
            error: function(xhr) {
                let message = 'Error updating attendance';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                toastr.error(message);
            }
        });
    }

    // Event listeners
    $loadBtn.on('click', loadAttendance);

    // Update calculations when editable fields change
    $('.attendance-input').on('input', function() {
        const $input = $(this);
        const value = parseInt($input.val()) || 0;
        
        // Ensure non-negative values
        if (value < 0) {
            $input.val(0);
        }
        
        // Update display immediately
        calculateLocalUpdates();
        
        // Debounce the server update
        clearTimeout($(this).data('timeout'));
        $(this).data('timeout', setTimeout(updateAttendance, 300));
    });

    // Initial load if month and year are pre-selected
    if ($monthSelect.length && $yearSelect.length) {
        loadAttendance();
    }
});
