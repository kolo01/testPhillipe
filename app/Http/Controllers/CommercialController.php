<?php

namespace App\Http\Controllers;

use App\Http\Traits\fondManager;
use App\Models\commercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommercialController extends Controller
{
  use fondManager;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

          // $commercial = DB::table("users")->where('id', request()->user()->id)->first();
          // $affiler = $commercial->GetAllAffilited;

          $marchands= DB::table("marchands")->where('commercial_id', request()->user()->id)->get();
          $total= $marchands->count();
          // dd($marchands);
          $allAmount= $this->soldeTransaction2();
          $result = $marchands->map(function ($item){
            
            $item->solde = $this->soldeByCompte($item->id);

            return $item;
        });

          return view('commercial.index', compact('marchands','total','allAmount'));



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('commercial.ajouter-commercial');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $request->validate([
        //     'nom' =>'required',
        //     'prenom' =>'required',
        //     'email' =>'required|email|unique:users',
        //     'password' => 'required|min:8|confirmed',
        //     'phone' =>'required|numeric',
        //     'adresse' =>'required',
        // ]);

        // $commercial = new commercial;
        // $commercial->nom = $request->nom;
        // $commercial->prenom = $request->prenom;
        // $commercial->email = $request->email;
        // $commercial->password =  bcrypt($request->password);
        // $commercial->phone = $request->phone;
        // $commercial->adresse = $request->adresse;
        // $commercial->marchand_id = $request->marchand_id;
        // $commercial->save();

        // return redirect()->route('commercial.index')->with('success', 'Commercial added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function show(commercial $commercial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function edit(commercial $commercial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, commercial $commercial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function destroy(commercial $commercial)
    {
        //
    }
}
