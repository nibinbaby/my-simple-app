<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;


    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','password', 'image'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function getAll(){
        return $this::all();
    }

    public function login($request){
        return $this::where('email', $request->email)
                    ->where('password', $request->password)
                    ->count();
    }

    public function register($request, $base64){
        $this->name = $request->name;
        $this->email = $request->email;
        $this->password = $request->password;
        if(!$base64){
            $this->image = './images/'.$request->photo->getClientOriginalName();
        }else{
            $this->uploadBase64($request);
        }
        return $this->save();
    }

    public function uploadBase64($request){
        $base64_string = str_replace('data:image/png;base64,', '', $request->photo);
        $base64_string = str_replace(' ', '+', $base64_string);
        $decoded = base64_decode($base64_string);
        $this->image = './images/'.$request->name.'.png';
        file_put_contents($this->image,$decoded);
    }
}
