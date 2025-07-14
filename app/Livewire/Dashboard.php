<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
class Dashboard extends Component
{
    public function render()
    {
        $totalPatient   =   Patient::count();
        $todayPatient = Patient::whereDate('created_at', today())->count();
        return view('dashboard',['totalPatient'=>$totalPatient,'todayPatient'=>$todayPatient]);
    }
}
