<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Hiking Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
        .disabled-btn {
            pointer-events: none;
            opacity: 0.5;
        }
        .completed {
            background-color: green;
            color: white;
            border-radius: 12px;
            padding: 5px 10px;
            font-weight: bold;
            display: inline-block;
        }
        .toggle-btn-group {
            display: inline-flex;
            border-radius: 50px;
            overflow: hidden;
            border: 2px solid  #228b22;
        }
        .toggle-btn {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            color: #007bff;
            border: none;
            outline: none;
            transition: background-color 0.3s, color 0.3s;
        }
        .toggle-btn.active {
            background-color: #228b22;
            color: white;
        }
        .toggle-btn.inactive {
            background-color: white;
            color:  #228b22;
        }
        .dropdown {
            display: inline-block;
            margin-left: auto;
        }
        .dropdown-menu {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .dropdown-item {
            color: #333;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <?php
            use App\Models\PaxInfo;
            $recs = PaxInfo::all();
        ?>
        <h3>Pending Hiking Registration</h3>
        <div class="d-flex justify-content-between mb-3">
            <div class="toggle-btn-group">
                <button id="allHikesBtn" class="toggle-btn active">All Hikes</button>
                <button id="todaysHikeBtn" class="toggle-btn inactive">Today's Hike</button>
            </div>
            <!-- Status Filter Dropdown -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="statusFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter by Status
                </button>
                <div class="dropdown-menu" aria-labelledby="statusFilterDropdown">
                    <a class="dropdown-item status-filter" href="#" data-status="All">All</a>
                    <a class="dropdown-item status-filter" href="#" data-status="Pending">Pending</a>
                    <a class="dropdown-item status-filter" href="#" data-status="No Status">No Status</a>
                    <a class="dropdown-item status-filter" href="#" data-status="Under Review">Under Review</a>
                    <a class="dropdown-item status-filter" href="#" data-status="Cancelled">Cancelled</a>
                    <a class="dropdown-item status-filter" href="#" data-status="Completed">Completed</a>
                </div>
            </div>
        </div>

        <div class="hiking_registration">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Pax Name</th>
                            <th class="text-center align-middle">No. of Members</th>
                            <th class="text-center align-middle">Hike Date</th>
                            <th class="text-center align-middle">Status</th>
                            <th class="text-center align-middle">Location</th>
                            <th class="text-center align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recs as $rec)
                            <tr class="text-center align-middle" data-hike-date="{{ $rec->hike_date }}" data-status="{{ $rec->status }}">
                                <td>{{ $rec->pax_name }}</td>
                                <td>{{ $rec->pax_count }}</td>
                                <td>{{ $rec->hike_date }}</td>
                                <td class="status">{{ $rec->status }}</td>
                                <td>
                                    @if($rec->status === 'Completed')
                                        <span class="completed">COMPLETED</span>
                                    @elseif($rec->status !== 'Ongoing')
                                        <button class="btn btn-primary view-location-btn disabled-btn" data-pax-name="{{ $rec->pax_name }}" data-bs-toggle="modal" data-bs-target="#locationModal" data-lat="{{ $rec->latitude }}" data-lng="{{ $rec->longitude }}" disabled>View Location</button>
                                    @else
                                        <button class="btn btn-primary view-location-btn" data-pax-name="{{ $rec->pax_name }}" data-bs-toggle="modal" data-bs-target="#locationModal" data-lat="{{ $rec->latitude }}" data-lng="{{ $rec->longitude }}">View Location</button>
                                    @endif
                                </td>
                                <td>
                                    @if($rec->status === 'Completed')
                                        <button class="btn btn-info view-time-info-btn" data-bs-toggle="modal" data-bs-target="#timeInfoModal" data-pax-id="{{ $rec->pax_id }}">View Hike Info</button>
                                    @else
                                        <button class="btn btn-success verify-btn" data-pax-id="{{ $rec->pax_id }}">Verify</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @include('LandingPage.modals.location')
        @include('LandingPage.modals.hike_summary')

        <!-- jQuery and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            var map;

            function initMap(lat, lng, paxName) {
                if (map) {
                    map.remove();
                }
                map = L.map('map').setView([lat, lng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
                L.marker([lat, lng]).addTo(map)
                    .bindPopup(paxName + ' Location')
                    .openPopup();
            }

            function showLocationModal(lat, lng, paxName) {
                $('#map').html(''); // Clear previous map content

                $('#locationModal').modal({
                    backdrop: false, // Remove backdrop
                    show: true
                }).on('shown.bs.modal', function () {
                    initMap(lat, lng, paxName);
                }).on('hidden.bs.modal', function () {
                    $('#map').html(''); // Clear the map container
                    $('#locationModal').off('shown.bs.modal hidden.bs.modal'); // Remove event handlers
                });
            }

            function showTimeInfoModal(paxId) {
                // Clear any existing backdrops
                $('.modal-backdrop').remove();

                $.ajax({
                    url: '{{route("getHikeDetails")}}',
                    type: 'POST',
                    data: {
                        pax_id: paxId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            $('#modalLeaderName').text(data.leaderName);
                            $('#modalMemberNames').text(data.memberNames);
                            $('#modalHikeDate').text(data.hikeDate);
                            $('#modalGuideName').text(data.guideName);
                            $('#modalTimeIn').text(data.timeIn);
                            $('#modalTimeOut').text(data.timeOut);

                            $('#timeInfoModal').modal({
                                backdrop: false, // Remove backdrop
                                show: true
                            }).on('hidden.bs.modal', function () {
                                $('#timeInfoModal').off('shown.bs.modal hidden.bs.modal'); // Remove event handlers
                            });
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching hike details.');
                    }
                });
            }

            function getDeviceLocation(paxName) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        showLocationModal(lat, lng, paxName);
                    }, function() {
                        alert('Geolocation is not supported by this browser.');
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            }

            $('.view-location-btn').on('click', function() {
                if ($(this).hasClass('disabled-btn')) {
                    return;
                }

                // Remove any existing backdrops
                $('.modal-backdrop').remove();
                // Get Pax name
                var paxName = $(this).data('pax-name');
                // Get device location
                getDeviceLocation(paxName);
            });

            // Disable "Verify" button if date is not the current date
            $(document).ready(function() {
                var today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

                $('.verify-btn').each(function() {
                    var hikeDate = $(this).closest('tr').data('hike-date');
                    if (hikeDate !== today) {
                        $(this).addClass('disabled-btn').prop('disabled', true);
                    }
                });
            });

            // Verify button click handler
            $('.verify-btn').on('click', function() {
                var paxId = $(this).data('pax-id');
                $.ajax({
                    url: '{{ route("paxinfo.verify") }}',
                    type: 'POST',
                    data: {
                        pax_id: paxId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Status updated to Ongoing');
                            // Update status in the table
                            $('button[data-pax-id="' + paxId + '"]').closest('tr').find('.status').text('Ongoing');
                        } else {
                            alert('Failed to update status: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while updating the status.');
                    }
                });
            });

            // Toggle between today's hikes and all hikes
            $('#todaysHikeBtn').on('click', function() {
                var today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

                $('tbody tr').each(function() {
                    var hikeDate = $(this).data('hike-date');
                    if (hikeDate !== today) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });

                $('#allHikesBtn').removeClass('active').addClass('inactive');
                $(this).removeClass('inactive').addClass('active');

                // Hide the filter dropdown
                $('.dropdown').hide();
            });

            $('#allHikesBtn').on('click', function() {
                $('tbody tr').each(function() {
                    $(this).show();
                });

                $('#todaysHikeBtn').removeClass('active').addClass('inactive');
                $(this).removeClass('inactive').addClass('active');

                // Show the filter dropdown
                $('.dropdown').show();
            });

            // Filter by status
            $('.status-filter').on('click', function() {
                var status = $(this).data('status');
                $('tbody tr').each(function() {
                    var rowStatus = $(this).data('status');
                    if (status === 'All' || rowStatus === status) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('.status-filter').removeClass('active');
                $(this).addClass('active');
            });

            // View Time Info button click handler
            $(document).on('click', '.view-time-info-btn', function() {
                var paxId = $(this).data('pax-id');
                showTimeInfoModal(paxId);
            });
        </script>
    </div>
</body>
</html>
