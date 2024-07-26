<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Rules\Uppercase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //
    public function showview()
    {
        return view('addcity');
    }
    public function getallcities()
    {
        $cdata = DB::table('cities')->get();
        return $cdata;
    }
    public function getallcitiesstate()
    {
        $cdata = DB::table('cities')->where('state', 'maharashtra')->get();
        return $cdata;
    }
    public function addcities(Request $request)
    {

        $validatedata = $request->validate([
            'cname' => ['required|string|max:16',new Uppercase],
            'state' => 'required|string|max:16'
        ]);
        
        DB::table('cities')->insert([
            'cname' => $validatedata['cname'],
            'state' => $validatedata['state']
        ]);

        return $request->all();
        // return redirect()->route('addcity.create')->with('success','city added succesfully');
    }
}
