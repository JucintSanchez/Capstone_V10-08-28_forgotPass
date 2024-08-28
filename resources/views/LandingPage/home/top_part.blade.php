<style>
    .top-part {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -1;
           
        border-bottom-left-radius: 100px;
        border-bottom-right-radius: 100px;
    }

    .content-center {
        position: absolute;
        top: 50%;
        left: 10%;
        transform: translateY(-50%);
        text-align: left;
        color: #fff;
    }

    @media (max-width: 768px) {
        .content-center {
            left: 5%;
            text-align: center;
            width: 90%;
        }
    }

    @media (max-width: 576px) {
        .content-center {
            left: 5%;
            text-align: center;
            width: 90%;
            top: 40%;
        }
    }
</style>

<?php
    use App\Models\HomeSettings;

    $homeSettings = HomeSettings::first();
?>

<body>
<div class="top-part" style="background-image: url('{{ asset('images/' . $homeSettings->landing_photo) }}');">        
    </div>
    <div class="content-center">
        <div class="container">
           
            <div class="text-center">
               
            </div>
        </div>
        <!-- <a href="#register" class="btn btn-success btn-icon btn-register">
            <i class="fas fa-user-plus"></i> Register Now
        </a> -->
    </div>
</body>
