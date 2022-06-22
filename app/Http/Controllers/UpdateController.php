<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ORM\Generated\Repository\UsersRepository;

class UpdateController extends Controller
{
    public function save(Request $request)
    {
        // モデルのクラス名を取得
        $model_class_name = $request->input('reponame');

        // モデル呼び出し
        $model_para = "\App\Models\\".$model_class_name;
        $model = new $model_para;

        $update_param = NULL;

        // POSTされたデータを取得し整列
        $column = $request->all();
        $keys = array_keys($column);
        foreach ($keys as $index => $key){
            if ($index === array_key_first($keys)) {
                continue;
            }
            if ($index === array_key_last($keys)) {
                continue;
            }
            $update_param .= $key."="."'".$request->$key."'".",";
        }
        $update_param = substr($update_param, 0, -1);

        //　modelクラス名からテーブル名に変換(キャメルケース->スネークケース)
        function convSnake($str) {
            return strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($str)));
        }
        $table_name = convSnake($model_class_name).PHP_EOL;

        // update実行
        $model_para = "\App\Models\\".$model_class_name;
        $model = new $model_para;
        $query = "UPDATE $table_name SET ".$update_param." WHERE id = ".$request->id;
        $model->getConnection()->statement($query);

        // redirect_url 生成
        $redirect_url = "/".substr($table_name, 0, -1)."/".$request->id;
        echo $redirect_url;
        return redirect($redirect_url);
    }
}
