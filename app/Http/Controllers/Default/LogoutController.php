<?php

namespace App\Http\Controllers\Default;

use Illuminate\Http\Request;
use App\Models\Users;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        session()->forget('id');
        session()->forget('role');
        return view('admin.login');
    }
}
