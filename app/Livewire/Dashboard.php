<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctors;
use App\Models\OnlineAppointment;
use Illuminate\Support\Facades\DB;
class Dashboard extends Component
{
    public function render()
    {
        $doctors                    =   Doctors::count();
        $todayOnlineAppointment     =   OnlineAppointment::whereDate('date_time', today())->count();
        $totalOnlineAppointment     =   OnlineAppointment::count();

        return view('dashboard',['doctors'=>$doctors,'todayOnlineAppointment'=>$todayOnlineAppointment,'totalOnlineAppointment'=>$totalOnlineAppointment]);
    }
}
