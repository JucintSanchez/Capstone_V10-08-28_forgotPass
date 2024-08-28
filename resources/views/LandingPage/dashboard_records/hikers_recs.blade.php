
<!-- @extends('LandingPage.layouts.dashboardlayout') -->

@section('title', 'Administrator')

<?php
        use App\Models\HikerInfo;
        $hikers = HikerInfo::all(); 
        
        ?>
        
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center align-middle">#</th>
                        <th class="text-center align-middle">Last Name</th>
                        <th class="text-center align-middle">First Name</th>
                        <th class="text-center align-middle">Email</th>
                        <th class="text-center align-middle">Age</th>
                        <th class="text-center align-middle">Contact</th>
                        <th class="text-center align-middle">Username</th>

                    </tr>
                </thead>
                <tbody>
                @foreach($hikers as $hiker_info)
                <tr>
                    <td class="text-center align-middle">{{ $loop->iteration }}</td> 
                    <td class="text-center align-middle">{{ $hiker_info->last_name }}</td>
                    <td class="text-center align-middle">{{ $hiker_info->first_name }}</td>
                    <td class="text-center align-middle">{{ $hiker_info->email }}</td>
                    <td class="text-center align-middle">{{ $hiker_info->age }}</td>
                    <td class="text-center align-middle">{{ $hiker_info->contact_num }}</td>
                    <td class="text-center align-middle">{{ $hiker_info->username }}</td>
                </tr>
            @endforeach
        </tbody>
            </table>
