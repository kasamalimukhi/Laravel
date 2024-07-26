<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class mycontroller extends Controller
{
    public function index()
    {
        $data=[
            'name'=>"kasamali",
            'email'=>"abc@gmail.com"

        ];
        return view('info')->with($data);
        // return view('info');
    }
}
