<?php

namespace App\Http\Controllers\Generated\Users;

use App\Http\Controllers\Default\Controller;

class UsersListController extends Controller
{
    public function index()
    {
        //  ページのタイトルを定義する
        $title = 'users一覧';
        //  表のカラム名を文字列で定義する
        $column = 'id,name';
        //  表のindexを文字列で定義する
        $index = 'ID,名前';
        //  Repositoryの名前をここで宣言する
        $repository_name = 'Users';

        return view('users.users_list', compact(
            'title',
            'column',
            'repository_name',
            'index'
        ));
    }
}
