<?php

namespace App\Http\Controllers;

use App\Models\Marchand;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users  = User::where('id','!=', auth()->user()->id)->orderby('created_at','desc')->get();

        return view('user.liste-user', ['users' => $users ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $marchands = Marchand::all();
        return view('user.ajouter-user',['marchands' => $marchands ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //  dd($request->input('marchand_id'));
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789jhefbiueqjbfwqiubfhiuyf47832urb32yfbe2fy2beufjb23yfb23iufkb21234567890';
        
        $checking = User::where('username', $request->input('username'))
                            ->orwhere('telephone', $request->input('telephone'))
                            ->orwhere('email', $request->input('email'))
                            ->exists();
        //Je vérifie si l'utilisateur est un segond compte marchand
        $firstMarchandAccount = User::where('marchand_id', $request->input('marchand_id'))->count();                    

       if (!$checking) {

            $password = Str::random(7);

            $user = User::create([
                'username' => $request->input('username'),
                'password' => Hash::make($password),
                'code' => $firstMarchandAccount == 0 ? $password : null,
                'email' => $request->input('email'),
                'telephone' => $request->input('telephone'),
                'marchand_id' => $request->input('marchand_id'),
                'role' => $request->input('role'),
            ]);

            return back()->with('success', 'Enregistrement effectué avec succès');

        } else {

            return back()->with('error', "L'utilisateur existe déjà");
        
        } 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $marchands = Marchand::all();

        return view('user.modifier-user', ['user' => $user, 'marchands' => $marchands ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $user = User::find($request->id);
       
            if ($user) {
               
                $user->username = $request->input('username');
                $user->email = $request->input('email');
                $user->telephone = $request->input('telephone');
                $user->marchand_id = $request->input('marchand_id');
                $user->role = $request->input('role');
                $user->save();
            }

        return back()->with('success', 'Utilisateur mise à jour avec succès');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {    
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }

        return back()->with('success', 'Utilisateur supprimé avec succès');
    }
}
