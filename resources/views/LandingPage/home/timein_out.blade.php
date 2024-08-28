<?php
use App\Models\PaxInfo;
use Illuminate\Support\Facades\Auth;

$user = Auth::guard('hiker')->user();
$hikerId = $user ? $user->hiker_id : null;

$recs = $hikerId ? PaxInfo::with(['guide', 'leader', 'timeIn', 'timeOut'])->where('hiker_id', $hikerId)->whereDate('hike_date', now()->toDateString())->get() : collect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mountain Themed Interface</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .time-body {
            font-family: Arial, sans-serif;
            background: url('{{ asset('images/mountain-background.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            text-align: center;
            padding: 50px;
        }
        .button-time {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;
        }
        .button-time:hover {
            background-color: #45a049;
        }
        .button-time:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .time-display {
            font-size: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body class="time-body">
    <div class="container">
        <h1>Mountain Expedition Group</h1>
        @if($recs->isEmpty())
            <p>No registrations found for today.</p>
        @else
            @foreach ($recs as $rec)
                <h4>Group Name: {{ $rec->pax_name }}</h4>
                <h4>Leader Name: {{ $rec->leader->first_name }} {{ $rec->leader->last_name }}</h4>
                <h4>Guide Name: 
                    @if ($rec->guide)
                        {{ $rec->guide->first_name }} {{ $rec->guide->last_name }}
                    @else
                        No guide
                    @endif
                </h4>
                <h4>Date: <span id="current-date">{{ $rec->hike_date }}</span></h4>
                <div class="time-display" id="time-display-{{ $rec->pax_id }}">
                    @if ($rec->timeIn)
                        Time-In: {{ $rec->timeIn->time }}<br>
                    @endif
                    @if ($rec->timeOut)
                        Time-Out: {{ $rec->timeOut->time }}
                    @endif
                </div>
                <button id="time-in-btn-{{ $rec->pax_id }}" class="button-time" onclick="handleTime('in', {{ $rec->pax_id }})" {{ $rec->status !== 'Ongoing' || $rec->timeIn ? 'disabled' : '' }}>Time-In</button>
                <button id="time-out-btn-{{ $rec->pax_id }}" class="button-time" onclick="handleTime('out', {{ $rec->pax_id }})" {{ $rec->status !== 'Ongoing' ? 'disabled' : '' }}>Time-Out</button>
            @endforeach
        @endif
    </div>

    <script>
        function handleTime(action, id) {
            const time = new Date().toLocaleTimeString();
            const timeDisplay = document.getElementById('time-display-' + id);
            const timeInButton = document.getElementById('time-in-btn-' + id);
            const timeOutButton = document.getElementById('time-out-btn-' + id);

            let title, text, confirmButtonText;

            if (action === 'in') {
                title = 'Do you want to begin the Hike?';
                text = 'You can start the hike and record the time.';
                confirmButtonText = 'Yes, begin the hike!';
            } else if (action === 'out') {
                title = 'Did you finish your hike?';
                text = 'You can end the hike and record the time out.';
                confirmButtonText = 'Yes, finish the hike!';
            }

            // Use SweetAlert2 to confirm the action
            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to store time-in or time-out information
                    $.ajax({
                        url: action === 'in' ? '{{ route("timein.post") }}' : '{{ route("timeout.post") }}', // Adjust the route to match your application's route
                        type: 'POST',
                        data: {
                            time: time,
                            pax_id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                if (action === 'in') {
                                    Swal.fire({
                                        title: 'Enjoy Hiking and Godbless your trip!',
                                        icon: 'success',
                                        confirmButtonText: 'Ok',
                                    });
                                    // Update time display
                                    timeDisplay.innerHTML = 'Time-In: ' + time;
                                    // Disable the Time-In button
                                    timeInButton.disabled = true;
                                } else if (action === 'out') {
                                    // Update PaxInfo status to Completed
                                    $.ajax({
                                        url: '{{ route("status_complete") }}',
                                        type: 'POST',
                                        data: {
                                            pax_id: id,
                                            status: 'Completed',
                                            _token: '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire({
                                                    title: 'Thank you for hiking!',
                                                    icon: 'success',
                                                    confirmButtonText: 'Ok',
                                                });
                                                // Update time display
                                                timeDisplay.innerHTML += '<br>Time-Out: ' + time;
                                                // Disable the Time-Out button
                                                timeOutButton.disabled = true;
                                            } else {
                                                Swal.fire({
                                                    title: 'Failed to update status',
                                                    text: response.message,
                                                    icon: 'error',
                                                    confirmButtonText: 'Ok',
                                                });
                                            }
                                        },
                                        error: function() {
                                            Swal.fire({
                                                title: 'An error occurred',
                                                text: 'Unable to update the status.',
                                                icon: 'error',
                                                confirmButtonText: 'Ok',
                                            });
                                        }
                                    });
                                }
                            } else {
                                Swal.fire({
                                    title: 'Failed to record time',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'An error occurred',
                                text: 'Unable to record the time.',
                                icon: 'error',
                                confirmButtonText: 'Ok',
                            });
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
