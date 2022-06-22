<?php

namespace App\Http\Controllers\Generated\Users;

use App\Http\Controllers\Default\Controller;

class UsersFormController extends Controller
{
    public function index(int $id)
    {
        //  ページのタイトルを定義する
        $title = 'users編集';
        //  表のカラム名を文字列で定義する
        $column = 'id,name';
        //  Repositoryの名前をここで宣言する
        $repository_name = 'Users';

        return view('users.users_form', compact(
            'title',
            'column',
            'repository_name',
            'id',
        ));
    }
}