<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

use App\User;

class SettingController extends Controller
{
    public function change_pass_store()
    {
        

        $user_id = Auth::user()->id;

        $this->checkOldConfirmPass();

        $data = request()->validate([
            'password' => 'required'
        ]);

        $data['password'] = bcrypt(request()->password);
        
        User::where('id', $user_id)->update($data);

        return back();
    }

    public function checkOldConfirmPass() {

        $real_old_pass = Auth::user()->password;
        $old_pass = request()->input('old_password');

        $new_pass = request()->input('password');
        $confirm_new_pass = request()->input('confirm_password');

        if (!($old_pass == $real_old_pass && $new_pass == $confirm_new_pass))
            return back();
    }
}
