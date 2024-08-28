<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/hiking_acts.css') }}">
</head>
<body>
<div class="card">
    <h2 class="card-header">Add Activity</h2>
    <div class="card-body">
        <form id="activityForm" action="{{ route('activity.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label for="act_name">Activity Name:</label>
                    <input type="text" id="act_name" name="act_name" required>
                    <div class="form-group" style="grid-column: span 1;">
                        <label for="desc">Description:</label>
                        <textarea id="desc" name="desc" rows="4" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="act_img">Upload Images:</label>
                    <div class="file-input-wrapper" onclick="document.getElementById('act_img').click();">
                        <span>Drag files to upload</span>
                    </div>
                    <input type="file" id="act_img" name="act_img[]" accept="image/*" multiple style="display:none;">
                    <div>

                        <button type="button" class="choose-files" onclick="document.getElementById('act_img').click();">Choose Files</button>
                    </div>
                    <div class="preview" id="activityPreview"></div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit">Add</button>
            </div>
        </form>
    </div>
</div>

@include('LandingPage.Hiking_Act.view_acts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    // Store selected files in an array
    let activityFilesArray = [];

    // Function to create image preview and add delete button
    function addActivityImagePreview(file, previewContainer) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            previewContainer.innerHTML = '';
            const deleteButton = document.createElement('button');
            deleteButton.className = 'delete-btn';
            deleteButton.textContent = 'X';
            deleteButton.addEventListener('click', function() {
                // Remove image from activityFilesArray
                const index = activityFilesArray.indexOf(file);
                if (index !== -1) {
                    activityFilesArray.splice(index, 1);
                }
                // Remove image preview from DOM
                previewContainer.removeChild(previewItem);
            });
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            previewItem.appendChild(img);
            previewItem.appendChild(deleteButton);
            previewContainer.appendChild(previewItem);
        };
        reader.readAsDataURL(file);
    }

    // Preview images and display selected file names for activity
    document.getElementById('act_img').addEventListener('change', function(event) {
        const files = event.target.files;
        const activityPreview = document.getElementById('activityPreview');

        Array.from(files).forEach(file => {
            activityFilesArray.push(file);
            addActivityImagePreview(file, activityPreview);
        });

        // Clear the file input for additional selections
        event.target.value = '';
    });

    // Close modal on click outside of modal content
    window.addEventListener('click', function(event) {
        const modal = document.getElementById("activityModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Function to refresh the activity table
    function refreshActivityTable() {
        fetch(location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('#act_post').innerHTML;
                document.getElementById('act_post').innerHTML = newContent;

                // Reattach event listeners after updating content
                attachEditListeners();
                attachDeleteListeners();
            })
            .catch(error => console.error('Error updating activity table:', error));
    }

    // Submit form via AJAX
    document.getElementById('activityForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        const formData = new FormData(this);

        // Append images from the array to formData
        activityFilesArray.forEach(file => {
            formData.append('act_img[]', file);
        });

        // Fetch API to submit the form data
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json', // Expecting JSON response
            },
        })
        .then(response => {
            if (!response.ok) {
                throw response;
            }
            return response.json();
        })
        .then(data => {
            swal("Added!", data.message, "success");
            document.getElementById('activityForm').reset(); // Reset form after successful submission
            activityFilesArray = []; // Clear the file array
            document.getElementById('activityPreview').innerHTML = ''; // Clear the preview
            // Fetch and update the activity table
            refreshActivityTable();
            // attachDeleteListeners();
        })
        .catch(error => {
            swal("Error!", "Oops! Something went wrong.", "error");
            console.error('Error:', error);
        });
    });

    // Function to attach event listeners to edit activity links
    function attachEditListeners() {
        var editLinks = document.querySelectorAll('.edit-activity');
        editLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.dataset.id;

                // Fetch the specific activity data
                fetch(`/activities/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate the form fields with the data
                        document.getElementById('updt_act_name').value = data.act_name;
                        document.getElementById('updt_desc').value = data.desc;

                        // Handle images if they are part of the response
                        const previewContainer = document.getElementById('updt_activityPreview');
                        previewContainer.innerHTML = ''; // Clear existing previews

                        if (data.act_picture && Array.isArray(data.act_picture)) {
                            data.act_picture.forEach((imgSrc, index) => {
                                const imgElement = document.createElement('img');
                                imgElement.src = '/storage/' + imgSrc.replace('public/', ''); // Assuming public path

                                const deleteButton = document.createElement('button');
                                deleteButton.className = 'delete-btn';
                                deleteButton.textContent = 'X';
                                deleteButton.addEventListener('click', function() {
                                    // Remove image preview from DOM
                                    previewContainer.removeChild(imgWrapper);
                                });

                                const imgWrapper = document.createElement('div');
                                imgWrapper.className = 'preview-item';
                                imgWrapper.appendChild(imgElement);
                                imgWrapper.appendChild(deleteButton);
                                previewContainer.appendChild(imgWrapper);
                            });
                        }

                        document.getElementById('activityModal').style.display = 'block'; // Open the modal after populating the data
                    })
                    .catch(error => {
                        console.error('Error fetching activity details:', error);
                    });
            });
        });
    }

    function attachDeleteListeners() {
    var deleteLinks = document.querySelectorAll('.delete-activity');
    deleteLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const id = this.dataset.id;

            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this activity!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform deletion if the user confirms
                    fetch(`/activities/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw response;
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire(
                            'Deleted!',
                            'Your activity has been deleted.',
                            'success'
                        );
                        // Fetch and update the activity table
                        refreshActivityTable();
                    })
                    .catch(error => {
                        Swal.fire("Error!", "Oops! Something went wrong.", "error");
                        console.error('Error:', error);
                    });
                } 
            });
        });
    });
}

    // Initial attachment of event listeners
    attachEditListeners();
    attachDeleteListeners();
</script>
</body>
</html>
