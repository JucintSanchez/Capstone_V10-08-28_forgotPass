<?php
    use App\Models\CancelReq;

    $cancelRequests = CancelReq::all();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cancellation Requests</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2 class="mt-4">Cancellation Requests</h2>
    <table class="table table-striped mt-4">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Request Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cancelRequests as $request)
            <tr>
                <td>{{ $request->cancellation_id }}</td>
                <td>{{ $request->pax_info_id }}</td>
                <td>{{ $request->created_at }}</td> <!-- Assuming you have a created_at column -->
                <td>{{ $request->reason }}</td>
                <td>{{ $request->status }}</td>
                <td>
                    <a href="#" class="btn btn-primary btn-sm">View</a>
                    @if ($request->status !== 'Approved')
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu">
                            <form action="{{ route('cancel-requests.approve', $request->cancellation_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Approve</button>
                            </form>
                            <form action="{{ route('cancel-requests.decline', $request->cancellation_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Decline</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
