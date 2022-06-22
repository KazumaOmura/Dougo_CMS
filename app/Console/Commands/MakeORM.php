<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;

use App\ORM\Generated\Repository\SampleRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class MakeORM extends Command
{
    protected $signature = 'make:orm';
    protected $description = 'Reoisitory,Modelの作成';

    public function handle()
    {







        // ヘッダー作成
        $header_value = <<< EOF
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">DougoCMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">

EOF;

        $fpath = './resources/views/';
        $blade_dir_name = $fpath . "layouts";
        $fname = $blade_dir_name . "/header.blade.php";
        if(!file_exists($blade_dir_name)){
            mkdir($blade_dir_name); // ディレクトリ作成
            echo "【ディレクトリ作成】";
            echo $blade_dir_name . "\n";
        }
            // ファイルを開く（'a'は追記モード）
            $fp = fopen($fname, "w");
            // ファイルに書き込む
            fputs($fp, $header_value);
            // ファイルを閉じる
            fclose($fp);
            echo "【ヘッダー作成】";
            echo $fname."\n";





        // パンクズ作成
        $breadcrumbs_value = <<< EOF

<?php

Breadcrumbs::for('home', function (\$trail) {
    \$trail->push('Home', url('/'));
});

EOF;

        $filename = './routes/breadcrumbs.php';
        // ファイルを開く（'a'は追記モード）
        $fp = fopen($filename, "w");
        // ファイルに書き込む
        fputs($fp, $breadcrumbs_value);
        // ファイルを閉じる
        fclose($fp);
        echo "【パンクズ作成】";
        echo $filename."\n";









        // index作成
        $breadcrumbs_value = <<< EOF
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" media="all" href="{{ asset('css/bootstrap.css') }}">

    <title>Dougo CMS</title>
</head>

<body>
@include('layouts.header')
<main class="container-xxl">
    <h3>Menu</h3>
    <ul class="list-group list-group-flush" style="max-width: 400px;">

EOF;

        $filename = './resources/views/index.blade.php';
        // ファイルを開く（'a'は追記モード）
        $fp = fopen($filename, "w");
        // ファイルに書き込む
        fputs($fp, $breadcrumbs_value);
        // ファイルを閉じる
        fclose($fp);
        echo "【index作成】";
        echo $filename."\n";








        // web.php作成
        $route_value = <<< EOF

<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('index');
});

use App\Http\Controllers\UpdateController;
Route::post('{any}/update', [UpdateController::class, 'save']);

EOF;

        $filename = './routes/web.php';
        // ファイルを開く（'a'は追記モード）
        $fp = fopen($filename, "w");
        // ファイルに書き込む
        fputs($fp, $route_value);
        // ファイルを閉じる
        fclose($fp);
        echo "【web.php】";
        echo $filename."\n";







        // 全スキーマ情報を取得
        $schema = DB::connection()->getDoctrineSchemaManager();

        // テーブル名一覧を取得
        $tableNames = $schema->listTableNames();

        foreach ($tableNames as $tableName) {

            if ($tableName === 'migrations' || $tableName === 'personal_access_tokens') {
                continue;
            }

            $tableNameCamel = str_replace(' ', '', ucwords(str_replace('_', ' ', $tableName)));

            // テーブル情報を取得
            $table = $schema->listTableDetails($tableName);

            // カラム情報を取得
            $columns = $table->getColumns();

            $column_list = NULL;
            $column_id = NULL;
            foreach ($columns as $column) {
                if ($column->getName() != 'id') {
                    $column_list = $column_list . "'" . $column->getName() . "',";
                } else {
                    $column_id = "'id'";
                }
                // array_push($columnNames, $column->getName());
            }


            // ヘッダー追記
            $header_value = <<< EOF
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/${tableName}">${tableName}</a>
                    </li>
EOF;

            $filename = './resources/views/layouts/header.blade.php';
            // ファイルを開く（'a'は追記モード）
            $fp = fopen($filename, "a");
            // ファイルに書き込む
            fputs($fp, $header_value);
            // ファイルを閉じる
            fclose($fp);
            echo "【ヘッダーメニュー追加】";
            echo $filename . "\n";


            // web.php追記
            $route_value = <<< EOF

use App\Http\Controllers\\${tableNameCamel}ListController;
use App\Http\Controllers\\${tableNameCamel}FormController;
Route::get('/${tableName}', [${tableNameCamel}ListController::class, 'index']);
Route::get('/${tableName}/{id}', [${tableNameCamel}FormController::class, 'index']);

EOF;

            $filename = './routes/web.php';
            // ファイルを開く（'a'は追記モード）
            $fp = fopen($filename, "a");
            // ファイルに書き込む
            fputs($fp, $route_value);
            // ファイルを閉じる
            fclose($fp);
            echo "【web.php追記】";
            echo $tableName . "\n";










            // Model作成
            $model_value = <<< EOF
<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class $tableNameCamel extends Model
{
    public \$timestamps = false;

    protected \$table = '${tableName}';

    protected \$fillable = [
       $column_list
    ];

    // アプリケーション側でcreateなどできない値を記述
    protected \$guarded = [
        $column_id
    ];
}

EOF;

            $fpath = './app/Models/';
            $fname = $fpath . $tableNameCamel . ".php";
            // ファイルが存在するか判定
            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $model_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
            }


            // Repository作成
            $repo_value = <<< EOF
<?php

namespace App\ORM\Generated\Repository;

use App\Models\\${tableNameCamel};

class ${tableNameCamel}Repository
{
    public static function getAll():object
    {
        \$all = ${tableNameCamel}::get();
        return \$all;
    }

    public static function getValueByID(int \$id):object
    {
        \$value = ${tableNameCamel}::where('id', \$id)->first();
        return \$value;
    }
}
EOF;

            $fpath = './app/ORM/Generated/Repository/';
            $fname = $fpath . $tableNameCamel . "Repository.php";
            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $repo_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
            }


            // ListController作成
            $list_controller_value = <<< EOF
<?php

namespace App\Http\Controllers;

class ${tableNameCamel}ListController extends Controller
{
    public function index()
    {
        //  ページのタイトルを定義する
        \$title = '${tableName}一覧';
        //  表のカラム名を文字列で定義する
        \$column = 'id,name';
        //  表のindexを文字列で定義する
        \$index = 'ID,名前';
        //  Repositoryの名前をここで宣言する
        \$repository_name = '${tableNameCamel}';

        return view('${tableName}.${tableName}_list', compact(
            'title',
            'column',
            'repository_name',
            'index'
        ));
    }
}

EOF;

            $fpath = './app/Http/Controllers/';
            $fname = $fpath . $tableNameCamel . "ListController.php";
            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $list_controller_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
            }


            // FormController作成
            $form_controller_value = <<< EOF
<?php

namespace App\Http\Controllers;

class ${tableNameCamel}FormController extends Controller
{
    public function index(int \$id)
    {
        //  ページのタイトルを定義する
        \$title = '${tableName}編集';
        //  表のカラム名を文字列で定義する
        \$column = 'id,name';
        //  Repositoryの名前をここで宣言する
        \$repository_name = '${tableNameCamel}';

        return view('${tableName}.${tableName}_form', compact(
            'title',
            'column',
            'repository_name',
            'id',
        ));
    }
}
EOF;

            $fpath = './app/Http/Controllers/';
            $fname = $fpath . $tableNameCamel . "FormController.php";
            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $form_controller_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
            }


            // list blade作成
            $blade_list_value = <<< EOF
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" media="all" href="{{ asset('css/bootstrap.css') }}">

    <title>{{ \$title }}</title>
</head>

<body>
@include('layouts.header')
{{ Breadcrumbs::render('${tableName}.list') }}
<main class="container-xxl">
    <x-table column="{{ \$column }}" reponame="{{ \$repository_name }}" title="{{ \$title }}" index="{{ \$index }}"/>
</main>

</body>
<script src="{{ asset('js/bootstrap.js') }}"></script>
</html>
EOF;

            $fpath = './resources/views/';
            $blade_dir_name = $fpath . $tableName;
            $fname = $blade_dir_name . "/" . $tableName . "_list.blade.php";
            if (!file_exists($blade_dir_name)) {
                mkdir($blade_dir_name); // ディレクトリ作成
                echo "【ディレクトリ作成】";
                echo $blade_dir_name . "\n";
            }

            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $blade_list_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル作成】";
                echo $fname . "\n";
            }


            // form blade作成
            $blade_list_value = <<< EOF

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" media="all" href="{{ asset('css/bootstrap.css') }}">

    <title>{{ \$title }}</title>
</head>

<body>
@include('layouts.header')
{{ Breadcrumbs::render('${tableName}.form') }}
<main class="container-xxl">
    <x-tab_form column="{{ \$column }}" reponame="{{ \$repository_name }}" userid="{{ \$id }}"/>
</main>

</body>
<script src="{{ asset('js/bootstrap.js') }}"></script>
</html>

EOF;

            $fpath = './resources/views/';
            $blade_dir_name = $fpath . $tableName;
            $fname = $blade_dir_name . "/" . $tableName . "_form.blade.php";
            if (!file_exists($blade_dir_name)) {
                mkdir($blade_dir_name); // ディレクトリ作成
                echo "【ディレクトリ作成】";
                echo $blade_dir_name . "\n";
            }

            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $blade_list_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル作成】";
                echo $fname . "\n";
            }








            // index追記
            $breadcrumbs_value = <<< EOF

        <li class="list-group-item"><a href="/${tableName}">${tableName}</a></li>

EOF;

            $filename = './resources/views/index.blade.php';
            // ファイルを開く（'a'は追記モード）
            $fp = fopen($filename, "a");
            // ファイルに書き込む
            fputs($fp, $breadcrumbs_value);
            // ファイルを閉じる
            fclose($fp);
            echo "【idnex追記】";
            echo $filename."\n";












            // パンクズ追記
            $breadcrumbs_value = <<< EOF

Breadcrumbs::for('${tableName}.list', function (\$trail) {
    \$trail->parent('home');
    \$trail->push('${tableName}一覧', url('/${tableName}'));
});
Breadcrumbs::for('${tableName}.form', function (\$trail) {
    \$trail->parent('${tableName}.list');
    \$trail->push('${tableName}詳細', url('/'));
});

EOF;

            $filename = './routes/breadcrumbs.php';
            // ファイルを開く（'a'は追記モード）
            $fp = fopen($filename, 'a');
            // ファイルに書き込む
            fputs($fp, $breadcrumbs_value);
            // ファイルを閉じる
            fclose($fp);
            echo "【パンクズ[" . $tableName . "]追記】" . "\n";








        }
        // end foreach










            // ヘッダー完成
            $header_value = <<< EOF

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown link
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
EOF;

            $filename = './resources/views/layouts/header.blade.php';
            // ファイルを開く（'a'は追記モード）
            $fp = fopen($filename, "a");
            // ファイルに書き込む
            fputs($fp, $header_value);
            // ファイルを閉じる
            fclose($fp);
            echo "【ヘッダー完成】";
            echo $filename . "\n";








        // index完成
        $breadcrumbs_value = <<< EOF

   </ul>
</main>

</body>
<script src="{{ asset('js/bootstrap.js') }}"></script>
</html>

EOF;

        $filename = './resources/views/index.blade.php';
        // ファイルを開く（'a'は追記モード）
        $fp = fopen($filename, "a");
        // ファイルに書き込む
        fputs($fp, $breadcrumbs_value);
        // ファイルを閉じる
        fclose($fp);
        echo "【idnex作成】";
        echo $filename."\n";



    }
}
