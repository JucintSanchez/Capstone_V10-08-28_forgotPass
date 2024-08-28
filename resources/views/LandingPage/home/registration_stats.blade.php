<?php
    use App\Models\PaxInfo;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::guard('hiker')->user();
    $hikerId = $user ? $user->hiker_id : null; 

    $recs = $hikerId ? PaxInfo::with('guide')->where('hiker_id', $hikerId)->get() : collect();
?>

<h3>Pending Hiking Registration</h3>
<div class="hiking_registration">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center align-middle">Pax Name</th>
                    <th class="text-center align-middle">No. of Members</th>
                    <th class="text-center align-middle">Hike Date</th>
                    <th class="text-center align-middle">Status</th>
                    <th class="text-center align-middle">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($recs->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">No registration yet</td>
                    </tr>
                @else
                    @foreach($recs as $rec)
                        <tr class="text-center align-middle">
                            <td>{{ $rec->pax_name }}</td>
                            <td>{{ $rec->pax_count }}</td>
                            <td>{{ $rec->hike_date }}</td>
                            <td>{{ $rec->status }}</td>
                            <td>
                                <button type="button" class="btn btn-info" onclick="viewGuideInfo('{{ optional($rec->guide)->guide_id }}')">View Guide Info</button>
                                <button type="button" class="btn btn-warning" onclick="rescheduleHike('{{ $rec->pax_id }}', '{{ $rec->hike_date }}')" {{ ($rec->status != 'No Status' && $rec->status != 'Pending') ? 'disabled' : '' }}>Reschedule</button>
                                <button type="button" class="btn btn-danger" onclick="cancelHike('{{ $rec->pax_id }}')" {{ ($rec->status != 'No Status' && $rec->status != 'Pending') ? 'disabled' : '' }}>Cancel</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@include('LandingPage.modals.guide_info')

<!-- Reschedule Hike Modal -->
<div class="modal fade" id="rescheduleHikeModal" tabindex="-1" aria-labelledby="rescheduleHikeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rescheduleHikeModalLabel">Reschedule Hike</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rescheduleHikeForm">
                    <div class="mb-3">
                        <label for="currentHikeDate" class="form-label">Current Hike Date</label>
                        <input type="text" class="form-control" id="currentHikeDate" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="newHikeDate" class="form-label">New Hike Date</label>
                        <input type="date" class="form-control" id="newHikeDate" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveRescheduleHike">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    function viewGuideInfo(guideId) {
        $.ajax({
            url: '{{ route('fetch-guide-info') }}',
            method: 'GET',
            data: {
                guide_id: guideId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    const guide = response.guide;
                    $('#guideInfoModal .modal-body').html(`
                        <p><strong>First Name:</strong> ${guide.first_name}</p>
                        <p><strong>Last Name:</strong> ${guide.last_name}</p>
                        <p><strong>Address:</strong> ${guide.address}</p>
                        <p><strong>Email:</strong> ${guide.email}</p>
                        <p><strong>Contact Number:</strong> ${guide.contact_num}</p>
                    `);
                    $('#guideInfoModal').modal('show');
                } else {
                    Swal.fire('Notice!', 'No guide information yet!', 'info');
                }
            },
            error: function() {
                Swal.fire('Error', 'Failed to fetch guide information.', 'error');
            }
        });
    }

    function rescheduleHike(id, currentHikeDate) {
        $('#currentHikeDate').val(currentHikeDate);
        $('#rescheduleHikeModal').modal('show');
        
        $('#saveRescheduleHike').off('click').on('click', function() {
            const newHikeDate = $('#newHikeDate').val();
            if (newHikeDate) {
                $.ajax({
                    url: '{{ route('reschedule-hike') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        new_date: newHikeDate
                    },
                    success: function(response) {
                        if (response.status === 'reschedule_review') {
                            Swal.fire('Review Required', 'Your reschedule request is under review.', 'info');
                        } else {
                            Swal.fire('Rescheduled!', 'Your hike has been rescheduled.', 'success');
                        }
                        $('#rescheduleHikeModal').modal('hide');
                        location.reload(); // Reload the page to see the updated hike date
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'There was an error rescheduling your hike.', 'error');
                    }
                });
            } else {
                Swal.fire('Validation', 'Please select a new date for the hike.', 'warning');
            }
        });
    }

    function cancelHike(id) {
        Swal.fire({
            title: 'Cancel Hike',
            text: 'Are you sure you want to cancel this hike? If yes, please provide a reason.',
            input: 'textarea',
            inputPlaceholder: 'Type your reason here...',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it',
            preConfirm: (reason) => {
                if (!reason) {
                    Swal.showValidationMessage('Reason is required');
                } else {
                    return { id: id, reason: reason };
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { id, reason } = result.value;
                
                $.ajax({
                    url: '{{ route('cancel-hike') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        reason: reason
                    },
                    success: (response) => {
                        Swal.fire('Cancellation Request Sent!', response.message, 'success');
                    },
                    error: (xhr) => {
                        Swal.fire('Error!', 'There was an error cancelling your hike.', 'error');
                    }
                });
            }
        });
    }
</script>
