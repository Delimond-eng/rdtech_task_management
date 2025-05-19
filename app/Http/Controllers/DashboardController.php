<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Currencie;
use App\Models\Facture;
use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psy\Util\Json;

class DashboardController extends Controller
{

   
    /**
     * Count dashboard
     * @return int
    */
    private function count($key):int
    {
        $dateNow = Carbon::now()->toDateString();
        return match ($key){
            "daily"=> 0,
            "pending"=> 0,
            "costumers"=> 0,
            "completed"=> 0,
            default=>null
        };
    }


}