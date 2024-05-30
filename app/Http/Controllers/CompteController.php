<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Traits\sendSMS;

class CompteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use sendSMS;

    public function changePassword()
    {   
        return view('compte.change-password');
    }


    public function profil()
    {   
        $user = auth('web')->user();

        return view('compte.profil', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function updatePassword(Request $request)
     {
         // Valider les données du formulaire
         $request->validate([
             'current_password' => 'required',
             'new_password' => 'required|min:8',
             'confirm_password' => 'required|same:new_password',
         ]);
     
         // Obtenir l'utilisateur authentifié
         $getuser = auth('web')->user();
     
         // Vérifier si le mot de passe actuel correspond
         if (!Hash::check($request->current_password, $getuser->password)) {
             return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect.');
         }
     
         // Mettre à jour le mot de passe de l'utilisateur
         $user = User::find($request->user_id);
         $user->code = $request->new_password;
         $user->password = Hash::make($request->new_password);
         $user->save();
     
         return redirect()->back()->with('success', 'Le mot de passe a été modifié avec succès.');
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sms()
    {
       $sms = $this->getSmsOtp();
       $totalSms = $sms[0]->availableUnits;
       return $totalSms;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
