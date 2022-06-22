<?php

namespace App\Http\Controllers\Default;

use Illuminate\Http\Request;
use App\Models\AdminUsers;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {
        $email= $request['email'];
        $password= $request['password'];

        $user_array = AdminUsers::where("email",$email)->first();

        if(!$user_array){
            $request->session()->flash('message', 'メールアドレスとパスワードが一致しません');
            $request->session()->flash('type', 'danger');
            return view('admin.login');
        } else {
            if(password_verify ( $password , $user_array->password ) ){
                // セッション
                session(['id' => $user_array->id]);
                session(['role' => 'admin']);

                $request->session()->flash('message', 'ログインしました');
                $request->session()->flash('type', 'success');
                return redirect('/');
            }
            else{
                $request->session()->flash('message', 'メールアドレスとパスワードが一致しません');
                $request->session()->flash('type', 'danger');
                return view('admin.login');
            }
        }
    }
}
