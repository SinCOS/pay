<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function getSystemSetting(){

    }
    public function getRegisterSetting(){
        return ['success'=>true,
        'msg'=>'success','code'=> 200,'timestamp'=>time(),
        'data' => [
            'registerEnabled' => true,
            'inviteRegisterEnabled' => true,
        ]
        ];
    }
}
