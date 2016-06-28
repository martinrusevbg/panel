<?php

namespace Serverfireteam\Panel;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Input;

class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

use HasRoles;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admins';
    protected $remember_token_name = 'remember_token';

    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

    public function getRememberToken() {
        return $this->remember_token;
    }

    public function setRememberToken($value) {
        $this->remember_token = $value;
    }

    public function getReminderEmail() {
        $email = Input::only('email');
        return $email['email'];
    }

    public function getRememberTokenName() {
        return $this->remember_token_name;
    }

    protected $fillable = array('first_name', 'last_name', 'email', 'password');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    public function delete() {
        $user = \Auth::guard('panel')->user();
        if (is_null($user)) {
            return false;
        }
        if (!$user->hasRole("super")) {
            return false;
        }
        parent::delete();
    }

//    public function save(array $options = []) {
//        $currentUser = \Auth::guard('panel')->user();
//        $user_roles = $currentUser->roles()->get()->toArray();
//        $min = min($user_roles);
//
//        $updatedUser = Admin::find(($this->original['id']));
//        $user_roles_updated = $updatedUser->roles()->get()->toArray();
//        $min_updated = min($user_roles_updated);
//
//        if($min_updated < $min) {
//            return false;
//        }
//        else {
//            parent::save();        
//        }
//    }

    public function save(array $options = []) {
        if (!empty($_REQUEST['_token']) && $_REQUEST['save'] === '1') {
            $currentUser = \Auth::guard('panel')->user();
            $user_roles = $currentUser->roles()->get()->toArray();
            unset($min);
            if (!is_null($user_roles) && is_array($user_roles)) {
                foreach ($user_roles as $role) {
                    if (!isset($min) || $min < $role['id']) {
                        $min = $role['id'];
                    }
                }
            }
            if (!isset($min)) {
                return false;
            }
            if (key_exists('update', $_REQUEST)) {
                $updatedUser = Admin::find($_REQUEST['update']);
                if (is_null($updatedUser)) {
                    return false;
                }
                $roles = $updatedUser->roles()->get()->toArray();
                if (!is_null($roles) && is_array($roles)) {
                    foreach ($roles as $role) {
                        if ($role['id'] < $min) {
                            return false;
                        }
                    }
                }
            }
            if (key_exists('roles', $_REQUEST)) {
                $newRoles = $_REQUEST['roles'];
                if (!is_null($newRoles) && is_array($newRoles)) {
                    foreach ($newRoles as $role) {
                        if ($role < $min) {
                            return false;
                        }
                    }
                }
            }
        }
        parent::save();
    }

}
