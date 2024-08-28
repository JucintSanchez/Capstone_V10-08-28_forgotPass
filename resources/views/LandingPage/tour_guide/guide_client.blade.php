<?php
use App\Models\PaxInfo;
use App\Models\GuideInfo;

// Get guide status
$guideId = session('guide_id');
$guide = GuideInfo::find($guideId);
$guideStatus = $guide->status;

$recs = PaxInfo::where('guide_id', $guideId)->whereIn('status', ['Pending', 'Reschedule on review', 'Completed'])->get();
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<h3>Clients</h3>
<div class="pending_hike">
    <?php if ($guideStatus === 'Pending'): ?>
        <p class="text-center">No registrations yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center align-middle">Pax Name</th>
                        <th class="text-center align-middle">No. of Members</th>
                        <th class="text-center align-middle">Hike Date</th>
                        <th class="text-center align-middle">Status</th>
                        <th class="text-center align-middle">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recs as $rec)
                    <tr class="text-center align-middle">
                        <td>{{ $rec->pax_name }}</td>
                        <td>{{ $rec->pax_count }}</td>
                        <td>{{ $rec->hike_date }}</td>
                        <td>{{ $rec->status }}</td>
                        <td>
                            <button type="button" class="btn btn-primary view-members" data-pax-id="{{ $rec->pax_id }}" data-bs-toggle="modal" data-bs-target="#hikingRegistrationModal">View</button>
                            @if($rec->status == 'Reschedule on review')
                                <button type="button" class="btn btn-warning resched-request" data-pax-id="{{ $rec->pax_id }}">Resched Request</button>
                            @endif
                            @if($rec->status != 'Completed')
                                <form action="{{ route('hiking_reg.cancel', ['id' => $rec->pax_id]) }}" method="POST" class="d-inline cancel-form">
                                    @csrf
                                    <button type="button" class="btn btn-danger cancel_reg">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Include SweetAlert2 and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   $(document).ready(function () {
    $('.cancel_reg').click(function (e) {
        e.preventDefault(); // Prevent the form from submitting immediately
        const form = $(this).closest('.cancel-form'); // Get the form element

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to cancel this registration?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form if confirmed
            }
        });
    });

    // Handle the reschedule request button click
    $('.resched-request').click(function () {
        const paxId = $(this).data('pax-id');
        
        // Fetch the requested hike date
        $.ajax({
            url: '{{ route("fetch-resched-date") }}', // Update with your route
            method: 'GET',
            data: {
                pax_id: paxId
            },
            success: function(response) {
                if (response.success) {
                    const requestedDate = response.requested_date;

                    Swal.fire({
                        title: 'Reschedule Request',
                        html: `Do you want to approve this reschedule request to <br> <b>${requestedDate}</b>?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Approve',
                        cancelButtonText: 'Reject'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Send an AJAX request to approve the reschedule
                            $.ajax({
                                url: '{{ route("hiking_reg.reschedule_approve") }}', // Update with your route
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    pax_id: paxId,
                                    approve: 'true'
                                },
                                success: function(response) {
                                    Swal.fire('Approved!', 'The reschedule request has been approved.', 'success')
                                    .then(() => {
                                        location.reload(); // Reload the page to see the updated status
                                    });
                                },
                                error: function(xhr) {
                                    const errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'There was an error approving the reschedule request.';
                                    Swal.fire('Error!', errorMessage, 'error');
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Send an AJAX request to reject the reschedule
                            $.ajax({
                                url: '{{ route("hiking_reg.reschedule_approve") }}', // Update with your route
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    pax_id: paxId,
                                    approve: 'false'
                                },
                                success: function(response) {
                                    Swal.fire('Rejected!', 'The reschedule request has been rejected.', 'info')
                                    .then(() => {
                                        location.reload(); // Reload the page to see the updated status
                                    });
                                },
                                error: function(xhr) {
                                    const errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'There was an error rejecting the reschedule request.';
                                    Swal.fire('Error!', errorMessage, 'error');
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire('Error', 'Failed to fetch the reschedule date.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Failed to fetch the reschedule date.', 'error');
            }
        });
    });
});
</script>
