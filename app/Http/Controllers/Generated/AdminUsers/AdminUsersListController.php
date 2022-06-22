<?php

namespace App\Http\Controllers\Generated\AdminUsers;

use App\Http\Controllers\Default\Controller;

class AdminUsersListController extends Controller
{
    public function index()
    {
        //  ページのタイトルを定義する
        $title = 'admin_users一覧';
        //  表のカラム名を文字列で定義する
        $column = 'id,name';
        //  表のindexを文字列で定義する
        $index = 'ID,名前';
        //  Repositoryの名前をここで宣言する
        $repository_name = 'AdminUsers';

        return view('admin_users.admin_users_list', compact(
            'title',
            'column',
            'repository_name',
            'index'
        ));
    }
}
