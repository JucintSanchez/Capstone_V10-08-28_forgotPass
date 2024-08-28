<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/css/bootstrap.min.css">
    <style>
        /* General container styling */
        .container {
            max-width: 800px;
            margin: auto;
        }

        /* Card Styling */
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .card-header {
            font-size: 18px;
            font-weight: bold;
            padding: 16px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #e0e0e0;
        }

        .card-body {
            padding: 16px;
        }

        .row {
            margin-bottom: 12px;
            align-items: center;
        }

        .col-md-4 {
            font-weight: bold;
        }

        .col-md-8 {
            color: #333;
        }

        /* Avatar and Image Styling */
        .avatar-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .avatar-container img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .change-image {
            position: absolute;
            bottom: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            display: none;
        }

        .file-input {
            display: none;
        }

        .edit-button, .save-button {
            width: 20%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
        }

        .edit-button {
            background-color: #007bff;
        }

        .save-button {
            background-color: #28a745;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 12px;
        }

        .modal-header {
            border-bottom: 1px solid #e0e0e0;
        }

        .modal-body img {
            border-radius: 12px;
        }

        /* Icon Styling */
        .icon {
            color: #007bff;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    @extends('LandingPage.layouts.dashboardlayout')

    @section('content')
    <!-- My Profile Section -->
    <div class="container mt-4">
        <h1 class="mb-4">More Details</h1>

        <!-- Profile Information -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header">Profile Information</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4"><i class="fas fa-user icon"></i><b>Name:</b></div>
                    <div class="col-md-8" id="profileName">{{ $user->first_name }} {{ $user->last_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><i class="fas fa-map-marker-alt icon"></i><b>Address:</b></div>
                    <div class="col-md-8" id="profileAddress">{{ $user->address }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><i class="fas fa-envelope icon"></i><b>Email:</b></div>
                    <div class="col-md-8" id="profileEmail">{{ $user->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><i class="fas fa-phone icon"></i><b>Contact:</b></div>
                    <div class="col-md-8" id="profileContact">{{ $user->contact_num }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><i class="fas fa-info-circle icon"></i><b>Status:</b></div>
                    <div class="col-md-8" id="profileStatus">{{ $user->status }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4"><i class="fas fa-file-alt icon"></i><b>Proof:</b></div>
                    <div class="col-md-8">
                        <img id="profileProof" src="{{ asset('storage/'.$user->proof) }}" class="img-fluid" style="max-width: 150px; cursor: pointer;" alt="Proof Image" data-bs-toggle="modal" data-bs-target="#profileImagePreviewModal">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Profile Image Preview -->
    <div class="modal fade" id="profileImagePreviewModal" tabindex="-1" aria-labelledby="profileImagePreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileImagePreviewLabel">Proof Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="profileImagePreview" src="{{ asset('storage/'.$user->proof) }}" class="img-fluid" alt="Proof Image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // No additional JavaScript needed as profile data is already rendered server-side.
            // If needed, add any dynamic actions here.
        });
    </script>
    @endsection
</body>
</html>
