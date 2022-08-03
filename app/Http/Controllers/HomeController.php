<?php

namespace App\Http\Controllers;

use App\Models\items;
use App\Models\personels;
use App\Models\depts;
use App\Models\his_tokens;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $Asset = items::select('*')->count();
        $Available = items::select('*')->where('availability','=','Available')->count();
        $Deployed = items::select('*')->where('availability','=','Deployed')->count();
        $Personel = personels::select('*')->count();
        $depts = depts::all();
        $items = items::all();
        $personels = personels::all();

        $his_tokens = his_tokens::select('*')->join('personels','his_tokens.personel_id','=','personels.id')->get();
       
        return view('home',compact('Asset','Available','Deployed','Personel','depts','items','his_tokens','personels'));
    }

  
}
