<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Editor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <style>

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 0.5em;
            margin-bottom: 0.5em;
        }
        .form-group button {
            background-color: #4CAF50;
            color: white;
            padding: 0.5em 1em;
            border: none;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
        .post img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .preview {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5em;
            margin-top: 1em;
        }
        .preview-item {
            position: relative;
        }
        .preview img {
            width: 100%;
            height: auto;
            display: block;
        }
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
        .file-label {
            display: inline-block;
            margin-top: 0.5em;
            font-size: 0.9em;
            color: #555;
        }
        input[type="file"] {
            display: none;
        }
        .file-input-wrapper {
            position: relative;
            display: inline-block;
        }
        .file-input-wrapper .file-label {
            cursor: pointer;
            display: block;
            padding: 0.5em;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 5px;
        }
    </style>
</head>
<body id="editspot_body">
    <div class = "card">
        <h2 class = "card-header">Offered Activities</h2>
        <div class = "container">
            <form id="postForm" action="{{ route('spot.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="desc">Type Description:</label>
                    <textarea id="desc" name="desc" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="spot_img">Upload Images:</label>
                    <div class="file-input-wrapper">
                        <label class="file-label" for="spot_img">Choose Files</label>
                        <input type="file" id="spot_img" name="spot_img[]" accept="image/*" multiple>
                    </div>
                    <div class="preview" id="preview"></div>
                </div>
                <div class="form-group">
                    <button type="submit">Post</button>
                </div>
            </form>
    
            <div class="posts" id="posts"></div>
        </div>
    </div>

    <div class = "card">
    <h2 class = "card-header">Posts</h2>
        <div id="spotPost">
            @include('LandingPage.spot_view')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        // Store selected files in an array
        let filesArray = [];

        // Function to create image preview and add delete button
        function addImagePreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                const deleteButton = document.createElement('button');
                deleteButton.className = 'delete-btn';
                deleteButton.textContent = 'X';
                deleteButton.addEventListener('click', function() {
                    // Remove image from filesArray
                    const index = filesArray.indexOf(file);
                    if (index !== -1) {
                        filesArray.splice(index, 1);
                    }
                    // Remove image preview from DOM
                    preview.removeChild(previewItem);
                });
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.appendChild(img);
                previewItem.appendChild(deleteButton);
                preview.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        }

        // Preview images and display selected file names
        document.getElementById('spot_img').addEventListener('change', function(event) {
            const files = event.target.files;
            const preview = document.getElementById('preview');

            Array.from(files).forEach(file => {
                filesArray.push(file);
                addImagePreview(file);
            });

            // Clear the file input for additional selections
            event.target.value = '';
        });

        document.getElementById('postForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);
            filesArray.forEach(file => {
                formData.append('spot_img[]', file);
            });

            // Perform AJAX submission
            fetch(this.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                swal("Posted!", data.message, "success").then(function() {
                    // Reset form fields and image previews
                    document.getElementById('desc').value = '';
                    filesArray = [];
                    document.getElementById('preview').innerHTML = '';
                    // Update the posts section
                    fetch(location.href)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.querySelector('#spotPost').innerHTML;
                        document.getElementById('spotPost').innerHTML = newContent;
                    });
                });
            })
            .catch(error => {
                swal("Error!", "Oops! Something went wrong.", "error");
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
