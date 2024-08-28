<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<title>Edit Hiking Activity</title>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    /* Modal styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from {opacity: 0;}
        to {opacity: 1;}
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

    header {
        background-color: #4CAF50;
        color: white;
        text-align: center;
        padding: 1em 0;
        border-radius: 10px 10px 0 0;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 0.5em;
        margin-bottom: 0.5em;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-group button {
        background-color: #4CAF50;
        color: white;
        padding: 0.5em 1em;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .form-group button:hover {
        background-color: #45a049;
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

<!-- The Modal -->
<div id="activityModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <header> 
            <h1>Edit Hiking Activity</h1>
        </header>
        <div class="container">
            <h2>Update Activity</h2>
            <form id="actForm" action="{{ route('activities.update', ['id' => '__ID__']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="updt_act_name">Activity Name:</label>
                    <input type="text" id="updt_act_name" name="updt_act_name" required>
                </div>
                <div class="form-group">
                    <label for="updt_desc">Description:</label>
                    <textarea id="updt_desc" name="updt_desc" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="updt_act_img">Upload Images:</label>
                    <div class="file-input-wrapper">
                        <label class="file-label" for="updt_act_img">Choose Files</label>
                        <input type="file" id="updt_act_img" name="updt_act_img[]" accept="image/*" multiple>
                    </div>
                    <div class="preview" id="updt_activityPreview"></div>
                </div>
                <div class="form-group">
                    <button type="submit">Update</button>
                </div>
            </form>
            <div class="posts" id="activityPosts"></div>
        </div>
    </div>
</div>

