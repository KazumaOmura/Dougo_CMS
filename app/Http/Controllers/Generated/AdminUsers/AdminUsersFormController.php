<?php

namespace App\Http\Controllers\Generated\AdminUsers;

use App\Http\Controllers\Default\Controller;

class AdminUsersFormController extends Controller
{
    public function index(int $id)
    {
        //  ページのタイトルを定義する
        $title = 'admin_users編集';
        //  表のカラム名を文字列で定義する
        $column = 'id,name';
        //  Repositoryの名前をここで宣言する
        $repository_name = 'AdminUsers';

        return view('admin_users.admin_users_form', compact(
            'title',
            'column',
            'repository_name',
            'id',
        ));
    }
}