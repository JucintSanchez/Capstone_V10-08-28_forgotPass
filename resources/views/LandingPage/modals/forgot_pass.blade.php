<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
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
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
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
        .modal input[type="email"],
        .modal input[type="text"],
        .modal input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        .modal button {
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .modal button:hover {
            background-color: #45a049;
        }
        /* Button to open the modal */
        #openModalBtn:hover {
            background-color: #0056b3;
        }
        p {
            color: black;
        }
    </style>
</head>
<body>

<!-- First Modal: Email Input -->
<div id="emailModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('emailModal')">&times;</span>
        <h2 style="color: black;">Enter Your Email</h2>
        <p>Please provide a valid email address to send a verification code.</p>
        <input type="email" id="email" placeholder="Enter your email">
        <button onclick="validateEmail()">Send</button>
    </div>
</div>

<!-- Second Modal: Verification Code -->
<div id="codeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('codeModal')">&times;</span>
        <h2 style="color: black;">Enter Verification Code</h2>
        <p>We've sent a verification code to your email.</p>
        <input type="text" id="code" placeholder="Enter verification code">
        <button onclick="validateCode()">Next</button>
    </div>
</div>

<!-- Third Modal: Username and Password -->
<div id="passwordModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('passwordModal')">&times;</span>
        <h2 style="color: black;">Create a Password</h2>
        <input type="password" id="new_password" placeholder="Enter new password">
        <input type="password" id="confirm_Password" placeholder="Re-enter new password">
        <button onclick="saveChanges()">Save Changes</button>
    </div>
</div>




</body>
</html>
