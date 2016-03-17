<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static $mortals  = ['employee'];
    public static $admins   = ['manager','president'];

    public static function isAdmin($id)
    {
        // Revisar que usuario y agregarlo en el insert

        $user = self::find($id);


        return in_array( $user->membership, self::$admins);
    }

    public static function isPresident($id)
    {
        // Revisar que usuario y agregarlo en el insert


        return self::find($id)->membership == "president" ;
    }

    public static function alreadyExists($email)
    {
        // Revisar que usuario y agregarlo en el insert

        $exists = ! self::where('email',$email)->get()->isempty();


        return $exists;
    }


    public function forms()
    {
        return $this->belongsToMany('App\Models\Form');
    }

    public static function getAllWithRole( $role )
    {
        if (! in_array($role, array_merge(self::$admins,self::$mortals)))
        {
            return collect([]);
        }

        return self::where('membership', $role)->get();
    }

    // public static function getAllCreatedBy( $user )
    // {
    //     if ( is_a($user, 'App\User') )
    //         $id = $user->id;

    //     else if ( is_integer($user) )
    //         $id = $user;

    //     else
    //         return collect([]);

    //     return self::where('user_id', $id)
    //         ->get();
    // }
}
