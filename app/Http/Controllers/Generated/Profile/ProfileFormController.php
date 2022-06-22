<?php

namespace App\Http\Controllers\Generated\Profile;

use App\Http\Controllers\Default\Controller;

class ProfileFormController extends Controller
{
    public function index(int $id)
    {
        //  ページのタイトルを定義する
        $title = 'profile編集';
        //  表のカラム名を文字列で定義する
        $column = 'id,name';
        //  Repositoryの名前をここで宣言する
        $repository_name = 'Profile';

        return view('profile.profile_form', compact(
            'title',
            'column',
            'repository_name',
            'id',
        ));
    }
}