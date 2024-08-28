<?php
use App\Models\HikingAct;

$acts = HikingAct::orderBy('activity_id', 'desc')->paginate(5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Offered Activities</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <style>
        .delete-btn {
            position: absolute;
            top: 0.25em;
            right: 0.25em;
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
            color: #555;
            cursor: pointer;
            padding: 0.25em;
            border-radius: 50%;
            font-size: 0.8em;
        }

        .delete-btn:hover {
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
        }

        .img-wrapper {
            position: relative;
            display: inline-block;
            margin-right: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .preview img {
            width: 100px;
            height: auto;
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="card">
    <h2 class="card-header">Offered Activities</h2>
    <div class="card-body">
        <div id="act_post" class="container my-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead style="background-color: #2E8B57; color: white;">
                        <tr class="text-center align-middle">
                            <th>Activity ID</th>
                            <th>Activity Name</th>
                            <th>Description</th>
                            <th>Picture</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($acts as $act)
                        <tr class="text-center align-middle">
                            <td class="activity-id">{{ $act->activity_id }}</td>
                            <td class="activity-name">{{ $act->act_name }}</td>
                            <td class="description">{{ $act->desc }}</td>
                            <td>
                                <?php
                                $images = is_string($act->act_picture) ? json_decode($act->act_picture, true) : [];
                                if ($images && is_array($images)) {
                                    foreach ($images as $image) {
                                        echo '<div class="img-wrapper">
                                                  <img src="' . asset('storage/' . str_replace('public/', '', $image)) . '" style="width: 100px; height: auto;">
                                              </div>';
                                    }
                                }
                                ?>
                            </td>
                            <td class="text-center align-middle">
                                <a href="#" class="text-primary mx-2 edit-activity" data-id="{{ $act->activity_id }}">
                                    <i class="fas fa-edit" style="font-size: 1.5em;"></i>
                                </a>
                                <a href="#" class="text-danger mx-2 delete-activity" data-id="{{ $act->activity_id }}">
                                    <i class="fas fa-trash-alt" style="font-size: 1.5em;"></i>
                                </a>
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end" id="activity-pagination">
                @if ($acts->onFirstPage())
                    <li class="page-item disabled">
                        <a class="page-link previous" href="#" tabindex="-1">Previous</a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link previous" href="{{ $acts->previousPageUrl() }}">Previous</a>
                    </li>
                @endif

                @php
                    $currentPage = $acts->currentPage();
                    $lastPage = $acts->lastPage();
                    
                    // Calculate which pages to show around the current page
                    $showPages = [];
                    
                    // Always show the first page
                    $showPages[] = 1;
                    
                    // Calculate the start and end of the range around the current page
                    $start = max($currentPage - 2, 2);
                    $end = min($currentPage + 2, $lastPage - 1);
                    
                    // Add the range of pages
                    for ($i = $start; $i <= $end; $i++) {
                        $showPages[] = $i;
                    }
                    
                    // Always show the last page
                    $showPages[] = $lastPage;
                    
                    // Add ellipses where necessary
                    if (!in_array(2, $showPages)) {
                        array_splice($showPages, 1, 0, '...');
                    }
                    
                    if (!in_array($lastPage - 1, $showPages)) {
                        array_splice($showPages, -1, 0, '...');
                    }
                @endphp

                @foreach ($showPages as $page)
                    @if ($page == $currentPage)
                        <li class="page-item active">
                            <span class="page-link" style="background-color: green; border-color: green;">{{ $page }}</span>
                        </li>
                    @elseif ($page == '...')
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $acts->url($page) }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($acts->hasMorePages())
                    <li class="page-item">
                        <a class="page-link next" href="{{ $acts->nextPageUrl() }}">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link next" href="#">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>

<!-- Include the modal here -->
@include('LandingPage.modals.update_acts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById("activityModal");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    function openModal() {
        modal.style.display = "block";
    }

    function addImagePreview(file, previewContainer) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            const deleteButton = document.createElement('button');
            deleteButton.className = 'delete-btn';
            deleteButton.textContent = 'X';
            deleteButton.addEventListener('click', function() {
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

    var fileInput = document.getElementById('updt_act_img');
    fileInput.addEventListener('change', function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('updt_activityPreview');

        // Clear previous previews
        previewContainer.innerHTML = '';

        Array.from(files).forEach(file => {
            addImagePreview(file, previewContainer);
        });

        // Log selected file paths
        for (let file of files) {
            console.log('Selected file:', file.name);
        }
    });

    var editLinks = document.querySelectorAll('.edit-activity');
    editLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const id = this.dataset.id;

            // Update form action URL with the correct ID
            const formAction = "{{ route('activities.update', ['id' => '__ID__']) }}".replace('__ID__', id);
            document.getElementById('actForm').action = formAction;

            fetch(`/activities/${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Fetched activity details:', data);
                    document.getElementById('updt_act_name').value = data.act_name;
                    document.getElementById('updt_desc').value = data.desc;

                    const previewContainer = document.getElementById('updt_activityPreview');
                    previewContainer.innerHTML = '';

                    if (data.act_picture && Array.isArray(data.act_picture)) {
                        data.act_picture.forEach(img => {
                            const imgElement = document.createElement('img');
                            imgElement.src = '/storage/' + img.replace('public/', '');
                            const deleteButton = document.createElement('button');
                            deleteButton.className = 'delete-btn';
                            deleteButton.textContent = 'X';
                            deleteButton.addEventListener('click', function() {
                                previewContainer.removeChild(imgWrapper);
                            });
                            const imgWrapper = document.createElement('div');
                            imgWrapper.className = 'preview-item';
                            imgWrapper.appendChild(imgElement);
                            imgWrapper.appendChild(deleteButton);
                            previewContainer.appendChild(imgWrapper);
                        });
                    }

                    openModal();
                })
                .catch(error => {
                    console.error('Error fetching activity details:', error);
                });
        });
    });

    document.getElementById('actForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        // Log the form data
        for (let [key, value] of formData.entries()) {
            if (value instanceof File) {
                console.log(`${key}:`, value.name);
            } else {
                console.log(`${key}:`, value);
            }
        }

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (response.headers.get('content-type')?.includes('application/json')) {
                return response.json();
            } else {
                return response.text().then(text => { throw new Error(text) });
            }
        })
        .then(data => {
            console.log('Update success:', data);
             modal.style.display = "none";

            Swal.fire({
                icon: 'success',
                title: 'Activity updated successfully!',
                showConfirmButton: false,
                timer: 1500
            });

            // Optionally update the UI or reload the page
            //  $('#act_post').load(location.href + ' #act_post');
            // attachDeleteListeners();
            refreshActivityTable();
        })
        .catch(error => {
            console.error('Error updating activity:', error);

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please try again later.',
                showConfirmButton: true
            });
        });
    });

    document.querySelectorAll('.edit-activity').forEach(function(editIcon) {
            editIcon.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.dataset.id;

                // Fetch activity data and populate the form
                fetch(`/activities/edit/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('act_name').value = data.act_name;
                        document.getElementById('desc').value = data.desc;

                        // Optionally, change the form's action to include the ID
                        document.getElementById('activityForm').action = `/activities/update/${id}`;
                    });
            });
        });

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

        // Pagination
        function loadPage(url) {
            $.ajax({
                url: url,
                type: 'get',
                beforeSend: function() {
                    $('#act_post').fadeOut(300, function() {
                        $(this).html('Loading...').fadeIn(300);
                    });
                }
            }).done(function(data) {
                $('#act_post').fadeOut(300, function() {
                    $(this).html($(data).find('#act_post').html()).fadeIn(300);
                    attachEditListeners();
                    window.history.pushState(null, null, url);

                    // Update active class
                    $('#activity-pagination .page-item').removeClass('active');
                    $('#activity-pagination').html($(data).find('#activity-pagination').html());
                    attachDeleteListeners();
                });
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('No response from server');
            });
        }

        $(document).on('click', '#activity-pagination a.page-link', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            loadPage(url);
        });
        
});

</script>

</body>
</html>
