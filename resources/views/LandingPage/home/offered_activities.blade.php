<?php
use App\Models\HikingAct;

$user = Auth::guard('hiker')->user();
$acts = HikingAct::all();
$username = $user ? $user->username : 'Login/Register';
?>

<style>
#act_disp {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
    justify-content: center;
}

.card2 {
    position: relative;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    width: 100%;
    height: 300px; /* Set a fixed height or adjust as needed */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card2:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card2-header {
    height: 100%;
    width: 100%;
    background-size: cover;
    background-position: center;
    position: absolute;
    top: 0;
    left: 0;
    transition: background-size 0.3s;
}

.card2-header:hover {
    background-size: 110%;
}

.card2-body {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.8); /* Semi-transparent background for text */
    box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1); /* Optional shadow for better text visibility */
}

.card2-title {
    font-size: 1.5rem;
    margin: 0;
    transition: color 0.3s;
}

.card2-desc {
    font-size: 1rem;
    color: #555;
}

.try-it-now-button {
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, transform 0.3s;
}

.try-it-now-button:hover {
    background-color: #218838;
    transform: scale(1.1);
}

.try-it-now-button:active {
    transform: scale(1);
}
</style>

<div class="container">
    <h2 class="title">Offered Activities</h2>
    <div id="act_disp">
        @foreach ($acts as $act)
            <div class="card2">
                <?php
                    $images = is_string($act->act_picture) ? json_decode($act->act_picture, true) : [];
                    if ($images && is_array($images)) {
                        $firstImage = asset('storage/' . str_replace('public/', '', $images[0]));
                    } else {
                        $firstImage = '';
                    }
                ?>
                <div class="card2-header" style="background-image: url('{{ $firstImage }}');"></div>
                <div class="card2-body">
                    <h3 class="card2-title">{{ $act->act_name }}</h3>
                    <!-- <p class="card2-desc">{{ $act->desc }}</p> -->
                    <button class="try-it-now-button" onclick="checkLoginStatus()">Try it now</button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function checkLoginStatus() {
        <?php if ($username === 'Login/Register') { ?>
            Swal.fire({
                icon: 'warning',
                title: 'Login First',
                text: 'You need to log in before you can register for a hike.',
                confirmButtonText: 'OK'
            });
        <?php } else { ?>
            $('#hike_reg_modal').modal('show');
        <?php } ?>
    }
</script>

