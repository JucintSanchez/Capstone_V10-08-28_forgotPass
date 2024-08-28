<?php
use App\Models\PaxInfo;
use App\Models\GuideInfo;

$guideId = session('guide_id');
$guide = GuideInfo::find($guideId);
$guideStatus = $guide->status;

$recs = PaxInfo::whereIn('status', ['No Status'])->get();
$hasPending = PaxInfo::where('guide_id', $guideId)->whereIn('status', ['Pending'])->exists();
$disableAcceptButton = $hasPending; // Pass this flag to view
?>

<style>
    /* Style for the header container */
    .header-container {
        background-color: #f0f0f0; /* Light gray background */
        padding: 10px; /* Padding around the header */
        border-radius: 5px; /* Rounded corners */
        margin-bottom: 20px; /* Space below the header */
        text-align: center; /* Center text horizontally */
    }

    /* Style for the header title */
    .header-title {
        margin: 0; /* Removes default margin */
        font-size: 18px; /* Adjusted size */
        font-weight: bold;
    }
    /* Ensure the table is responsive and fits within its container */
    .table-responsive {
        overflow-x: auto; /* Allows horizontal scrolling if needed */
        -webkit-overflow-scrolling: touch; /* Enables smooth scrolling on touch devices */
    }

    /* Style the table to scale down on smaller screens */
    .table {
        width: 100%;
        border-collapse: collapse; /* Ensures the borders of the table and cells collapse into a single border */
        table-layout: auto; /* Allows the table to scale and adjust based on its content */
    }

    .table th, .table td {
        padding: 8px; /* Adds padding to table cells for better readability */
        text-align: center; /* Centers text within table cells */
    }

    /* Style for the Action buttons to be responsive */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 10px; /* Adjusts spacing between buttons */
        flex-wrap: wrap; /* Allows buttons to wrap onto the next line if necessary */
    }

    .btn {
        margin: 0; /* Removes default margin */
        padding: 6px 12px; /* Adjusts padding for buttons */
        font-size: 0.9em; /* Adjusts font size for buttons */
    }

    /* Ensure font size adjusts on smaller screens */
    @media (max-width: 768px) {
        .table {
            font-size: 0.9em; /* Reduces font size for smaller screens */
        }

        .table th, .table td {
            padding: 6px; /* Reduces padding in table cells */
        }
    }

    /* Optional: Adjust button styling on very small screens */
    @media (max-width: 480px) {
        .btn {
            font-size: 0.8em; /* Further reduce font size for very small screens */
            padding: 5px 10px; /* Adjusts padding for very small screens */
        }
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="header-container">
    <h3 class="header-title">Pending Hiking Registration</h3>
</div>
<div class="hiking_registration">
    <?php if ($guideStatus === 'Pending'): ?>
        <p class="text-center">No registration yet.</p>
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
                            <div class="action-buttons">
                                <form action="{{ route('hiking_reg.accept', ['id' => $rec->pax_id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-approve" {{ $disableAcceptButton ? 'disabled' : '' }}>Accept</button>
                                </form>
                                <button type="button" class="btn btn-primary view-members" data-pax-id="{{ $rec->pax_id }}" data-bs-toggle="modal" data-bs-target="#hikingRegistrationModal">View</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewButtons = document.querySelectorAll('.view-members');

    viewButtons.forEach(button => {
        button.addEventListener('click', function () {
            const paxId = this.getAttribute('data-pax-id');
            axios.get(`/pax-members/${paxId}`)
                .then(response => {
                    const members = response.data;
                    const tableBody = document.querySelector('#hikingRegistrationModal tbody');
                    tableBody.innerHTML = '';

                    members.forEach(member => {
                        const row = `
                            <tr class="text-center align-middle">
                                <td>${member.member_name}</td>
                                <td>${member.age}</td>
                                <td>${member.gender}</td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => {
                    console.error('Error fetching members:', error);
                });
        });
    });
});
</script>
