<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use Log;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function getAll(){
        try{
            return response()->json((new User())->getAll());
        }
        catch(Exception $error){
            Log::info($error);
        }
    }

    public function login(Request $request){
        try{
            return response()->json((new User())->login($request) > 0 ? true : false);
        }
        catch(Exception $error){
            Log::info($error);
        }
    }

    public function register(Request $request){
        try{
            if($request->hasFile('photo') && $this->uploadPhoto($request->photo)){
                return response()->json((new User())->register($request));
            }else{
                return response()->json((new User())->register($request, true));
            }
        }
        catch(Exception $error){
            Log::info($error);
        }
    }

    public function uploadPhoto($photo){
        try{
            return $photo->move('images', $photo->getClientOriginalName());
        }
        catch(Exception $e){
            Log::info($error);
        }
    }
    //
}
