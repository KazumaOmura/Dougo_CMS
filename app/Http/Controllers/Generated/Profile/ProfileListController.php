<?php

namespace App\Http\Controllers\Generated\Profile;

use App\Http\Controllers\Default\Controller;

class ProfileListController extends Controller
{
    public function index()
    {
        //  ページのタイトルを定義する
        $title = 'profile一覧';
        //  表のカラム名を文字列で定義する
        $column = 'id,name';
        //  表のindexを文字列で定義する
        $index = 'ID,名前';
        //  Repositoryの名前をここで宣言する
        $repository_name = 'Profile';

        return view('profile.profile_list', compact(
            'title',
            'column',
            'repository_name',
            'index'
        ));
    }
}
