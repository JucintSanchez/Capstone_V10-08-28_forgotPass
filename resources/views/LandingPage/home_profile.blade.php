<?php
use Illuminate\Support\Facades\Auth;
use App\Models\HomeSettings;
use App\Models\Organization;
use App\Models\MountainDetails;
use App\Models\ThingsToBring;
use App\Models\Rules_Regulation;
use App\Models\TermsCondition;

$admin = Auth::guard('admin')->user();
$org_id = $admin->org_id ?? null;
$organization = $org_id ? Organization::find($org_id) : null;
$homeSettings = $org_id ? HomeSettings::where('org_id', $org_id)->first() : null;
$mountainDetails = $org_id ? MountainDetails::where('org_id', $org_id)->first() : null;
$thingsToBring = $org_id ? ThingsToBring::where('org_id', $org_id)->get() : [];
$rulesRegulations = $org_id ? Rules_Regulation::where('org_id', $org_id)->get() : [];
$termsCondition = $org_id ? TermsCondition::where('org_id', $org_id)->first() : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card h5 {
            margin: 0 0 10px 0;
            font-size: 18px;
            color: #333;
        }
        .card hr {
            margin: 10px 0;
            border: none;
            border-top: 1px solid #ccc;
        }
        label {
            font-weight: bold;
        }
        input, textarea, button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }
        input[type="file"] {
            display: none; /* Hide the default file input */
        }
        .file-input-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .file-input-container button {
            padding: 10px;
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #2E8B57;
            width: auto;
        }
        .file-input-container button:hover {
            background-color: #1e6e49;
        }
        .image_prev {
            margin-top: 10px;
            max-width: 100%;
            height: auto; /* Maintain aspect ratio */
            border: 1px solid #ccc;
            border-radius: 5px;
            display: none; /* Initially hidden */
        }
        .card button {
            margin-top: 15px;
            background-color: #2E8B57;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .card button:hover {
            background-color: #1e6e49;
        }
        .things-to-bring-container, .rules-regulations-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .things-to-bring-table, .rules-regulations-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .things-to-bring-table th, .things-to-bring-table td, .rules-regulations-table th, .rules-regulations-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .btn-del {
            background-color: #dc3545 !important;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px 20px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h1>Landing Page Settings</h1>
        @if ($organization)
        <form id="homeSettingsForm" action="{{ route('home-settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Landing Page Photo Section -->
            <div class="card" id="landingPagePhotoCard">
                <h5>Landing Page Photo Settings</h5>
                <hr>
                <div class="file-input-container">
                    <button type="button" onclick="document.getElementById('landingPagePhoto').click();">Choose File</button>
                    <input type="file" id="landingPagePhoto" name="landingPagePhoto" accept="image/*" onchange="previewImage(event)">
                </div>
                @if ($homeSettings && $homeSettings->landing_photo)
                    <img id="imagePrev" class="image_prev" src="{{ asset('images/' . $homeSettings->landing_photo) }}" alt="Image Preview">
                @else
                    <img id="imagePrev" class="image_prev" src="" alt="Image Preview">
                @endif
                <button type="submit">Save Settings</button>
            </div>

            <!-- About Us Section -->
            <div class="card">
                <h5>About Us Settings</h5>
                <hr>
                <textarea id="aboutUs" name="aboutUs" rows="5" placeholder="Enter information about your company...">{{ $homeSettings->about_us ?? '' }}</textarea>
                <button type="submit">Save Settings</button>
            </div>

            <!-- Contact Us Section -->
            <div class="card">
                <h5>Contact Us Settings</h5>
                <hr>
                <label for="contactNumber">Contact Number:</label>
                <input id="contactNumber" name="contactNumber" placeholder="Enter contact number..." value="{{ $homeSettings->contact_num ?? '' }}">
                <label for="contactEmail">Email:</label>
                <input type="email" id="contactEmail" name="contactEmail" placeholder="Enter contact email..." value="{{ $homeSettings->email ?? '' }}">
                <button type="submit">Save Settings</button>
            </div>

            <!-- Mountain Details Section -->
            <div class="card">
                <h5>Mountain Details</h5>
                <hr>
                    <label for="mountainName">Mountain Name:</label>
                    <input id="mountainName" name="mountain_name" placeholder="Enter mountain name..." value="{{ $mountainDetails->mountain_name ?? '' }}">
                    <label for="difficulty">Difficulty:</label>
                    <input id="difficulty" name="difficulty" placeholder="Enter difficulty level..." value="{{ $mountainDetails->difficulty ?? '' }}">
                    <label for="elevation">Elevation:</label>
                    <input id="elevation" name="elevation" placeholder="Enter elevation..." value="{{ $mountainDetails->elevation ?? '' }}">
                    <label for="jumpOffStation">Jump-off Station:</label>
                    <input id="jumpOffStation" name="station" placeholder="Enter jump-off station..." value="{{ $mountainDetails->station ?? '' }}">
                    <label for="features">Features:</label>
                    <textarea id="features" name="features" rows="3" placeholder="Enter features...">{{ $mountainDetails->features ?? '' }}</textarea>
                    <label for="overview">Overview:</label>
                    <textarea id="overview" name="overview" rows="3" placeholder="Enter overview...">{{ $mountainDetails->overview ?? '' }}</textarea>
                    <button type="submit">Save Mountain Details</button>
                </div>
        </form>

            <!-- Things to Bring Section -->
            <div class="card">
                <h5>Things to Bring</h5>
                <hr>
                <form id="thingsToBringForm" action="{{ route('things-to-bring.add') }}" method="POST">
                    @csrf
                    <div class="things-to-bring-container">
                        <label for="thingsToBringInput">Add Item:</label>
                        <input id="thingsToBringInput" name="item_name" placeholder="Enter item to bring...">
                        <button type="submit">Add</button>
                    </div>
                </form>
                <table class="things-to-bring-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="thingsToBringTableBody">
                        @if ($thingsToBring->isEmpty())
                            <tr>
                                <td colspan="2" style="text-align: center;">No items yet</td>
                            </tr>
                        @else
                            @foreach ($thingsToBring as $item)
                                <tr id="item-{{ $item->things_id }}">
                                    <td>{{ $item->item_name }}</td>
                                    <td>
                                        <form class="deleteItemForm" data-id="{{ $item->things_id }}" action="{{ route('things-to-bring.delete', $item->things_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-del" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>


            <!-- Rules and Regulations Section -->
            <div class="card">
                <h5>Rules and Regulations</h5>
                <hr>
                <form id="rulesRegulationsForm" action="{{ route('rules-regulations.add') }}" method="POST">
                    @csrf
                    <div class="rules-regulations-container">
                        <label for="rulesRegulationsInput">Add Rule:</label>
                        <input id="rulesRegulationsInput" name="rules_n_regulation" placeholder="Enter rule...">
                        <button type="submit">Add</button>
                    </div>
                </form>
                <table class="rules-regulations-table">
                    <thead>
                        <tr>
                            <th>Rule</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="rulesRegulationsTableBody">
                        @if ($rulesRegulations->isEmpty())
                            <tr>
                                <td colspan="2" style="text-align: center;">No rules yet</td>
                            </tr>
                        @else
                            @foreach ($rulesRegulations as $rule)
                                <tr id="rule-{{ $rule->rules_id }}">
                                    <td>{{ $rule->rules_n_regulation }}</td>
                                    <td>
                                        <form class="deleteRuleForm" data-id="{{ $rule->rules_id }}" action="{{ route('rules-regulations.delete', $rule->rules_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-del" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Terms and Conditions Section -->
            <div class="card">
                <h5>Terms and Conditions</h5>
                <hr>
                <form id="termsConditionsForm" action="{{ route('terms-conditions.update') }}" method="POST">
                    @csrf
                    <textarea id="termsConditions" name="terms_and_condition" rows="7" placeholder="Enter terms and conditions...">{{ $termsCondition->terms_and_condition ?? '' }}</textarea>
                    <button type="submit">Save Terms and Conditions</button>
                </form>
            </div>

            <input type="hidden" name="org_id" value="{{ $organization->org_id }}">
        @else
            <p>No organization found for this admin.</p>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const imagePrev = document.getElementById('imagePrev');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePrev.src = e.target.result;
                    imagePrev.style.display = 'block'; // Show the image preview
                };
                reader.readAsDataURL(file);
            } else {
                imagePrev.style.display = 'none'; // Hide the preview if not an image
            }
        }

        function refreshTableContent(tableId) {
            fetch(location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector(tableId).innerHTML;
                    document.querySelector(tableId).innerHTML = newContent;
                    // Re-attach event handlers if needed
                    attachDeleteHandlers();
                })
                .catch(error => console.error('Error updating table content:', error));
        }

        function attachDeleteHandlers() {
            // Attach delete handler for items
            $('.deleteItemForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var id = form.data('id');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                            refreshTableContent('#thingsToBringTableBody');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                        }
                    }
                });
            });

            // Attach delete handler for rules
            $('.deleteRuleForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var id = form.data('id');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                            refreshTableContent('#rulesRegulationsTableBody');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                        }
                    }
                });
            });
        }

        $(document).ready(function() {
            // AJAX for Adding Things to Bring
            $('#thingsToBringForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });

                            // Refresh the Things to Bring table
                            refreshTableContent('#thingsToBringTableBody');
                            document.getElementById('thingsToBringInput').value = '';
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                        }
                    }
                });
            });

            // AJAX for Adding Rules
            $('#rulesRegulationsForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });

                            // Refresh the Rules and Regulations table
                            refreshTableContent('#rulesRegulationsTableBody');
                            document.getElementById('rulesRegulationsInput').value = '';
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                        }
                    }
                });
            });

            // AJAX for Updating Terms and Conditions
            $('#termsConditionsForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                        }
                    }
                });
            });

            // AJAX for Updating Home Settings
            $('#homeSettingsForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,  // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false,  // Set content type to false so jQuery doesn't add content type header
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: false, // This hides the OK button
                                timer: 1000
                            });
                        }
                    }
                });
            });

            // Initial attachment of delete handlers
            attachDeleteHandlers();
        });
    </script>
</body>
</html>
