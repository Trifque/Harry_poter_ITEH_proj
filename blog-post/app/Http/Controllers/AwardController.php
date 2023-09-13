<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    /* SVE ZA NAGRADE */

    /* GET-eri */
        public function getAllAwards()
        {
            $awards = Award::all();
            
            if(is_null($awards)){
                return response() -> json('Data not found', 404);
            }
            return response()->json($awards);
        }
}
