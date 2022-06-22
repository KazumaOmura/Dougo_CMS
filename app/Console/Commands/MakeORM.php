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
    protected $signature = 'make:orm {--name=} {--how=} {--blade} {--controller}';
    protected $description = 'Reoisitory,Modelの作成';

    public function handle()
    {
        $new_blade_flag=false;
        $new_controller_flag=false;

        if ($this->input->hasParameterOption('--how')) {
            $this->line('');
            $this->line('Sample:');
            $this->line('   php artisan make:orm --name [<AppName>]');
            $this->line('');
            $this->line('Options:');
            $this->line('   --name [<AppName>]              アプリ名を指定します');
            $this->line('   --controller                    controllerを再生成します');
            $this->line('   --blade                         bladeを再生成します');
            $this->line('');
            exit;
        }

        if (!$this->input->hasParameterOption('--name')) {
            $this->line('--nameオプションは与えられていません');
            exit;
        }
        if($this->option('name') == NULL){
            $this->line('--nameオプションの中身がありません');
            exit;
        }

        if ($this->input->hasParameterOption('--blade')) {
            $new_blade_flag=true;
        }

        if ($this->input->hasParameterOption('--controller')) {
            $new_controller_flag=true;
        }
            
        $app_name = $this->option('name');



        // login ヘッダー作成
        $login_header_value = <<< EOF
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">{$app_name} CMS</a>
        </div>
    </nav>
</header>
EOF;

        $fpath = './resources/views/';
        $blade_dir_name = $fpath . "layouts";
        $fname = $blade_dir_name . "/login_header.blade.php";
        if(!file_exists($blade_dir_name)){
            mkdir($blade_dir_name); // ディレクトリ作成
            echo "【ディレクトリ作成】";
            echo $blade_dir_name . "\n";
        }
            // ファイルを開く（'a'は追記モード）
            $fp = fopen($fname, "w");
            // ファイルに書き込む
            fputs($fp, $login_header_value);
            // ファイルを閉じる
            fclose($fp);
            echo "【ログインヘッダー作成】";
            echo $fname."\n";









        // ヘッダー作成
        $header_value = <<< EOF
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">{$app_name} CMS</a>
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

    <title>{$app_name} CMS</title>
</head>

<body>
@include('layouts.header')
@if(session('message'))
    <div class="alert alert-{{session('type')}}">{{session('message')}}</div>
@endif
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
Route::get('/login', function () {
    return view('admin.login');
})->middleware('already_admin_login');

use App\Http\Controllers\Default\AdminLoginController;
Route::post('/login', [AdminLoginController::class, 'login']);

use App\Http\Controllers\Default\LogoutController;
Route::get('/logout', [LogoutController::class, 'logout'])->middleware('admin_login');

Route::get('/', function () {
    return view('index');
})->middleware('admin_login');

use App\Http\Controllers\Default\UpdateController;
Route::post('{any}/update', [UpdateController::class, 'save'])->middleware('admin_login');

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

use App\Http\Controllers\Generated\\${tableNameCamel}\\${tableNameCamel}ListController;
use App\Http\Controllers\Generated\\${tableNameCamel}\\${tableNameCamel}FormController;
use App\Http\Controllers\Generated\\${tableNameCamel}\\${tableNameCamel}DetailController;
Route::get('/${tableName}', [${tableNameCamel}ListController::class, 'index'])->middleware('admin_login');
Route::get('/${tableName}/edit/{id}', [${tableNameCamel}FormController::class, 'index'])->middleware('admin_login');
Route::get('/${tableName}/detail/{id}', [${tableNameCamel}DetailController::class, 'index'])->middleware('admin_login');

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

namespace App\Http\Controllers\Generated\\${tableNameCamel};

use App\Http\Controllers\Default\Controller;

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
        //  編集ボタンの有無(int)
        \$edit_flag = 1;
        //  詳細ボタンの有無(int)
        \$detail_flag = 1;

        return view('${tableName}.${tableName}_list', compact(
            'title',
            'column',
            'repository_name',
            'index',
            'edit_flag',
            'detail_flag'
        ));
    }
}

EOF;

            $fpath = './app/Http/Controllers/Generated/'.$tableNameCamel;
            $fname = $fpath . "/".$tableNameCamel."ListController.php";
            
            // ディレクトリがない場合
            $blade_dir_name = $fpath;
            if (!file_exists($blade_dir_name)) {
                mkdir($blade_dir_name); // ディレクトリ作成
                echo "【ディレクトリ作成】";
                echo $blade_dir_name . "\n";
            }

            echo '-------------';
            echo "\n\n";
            echo $fname;
            echo "\n\n";
            echo '-------------';
            // ファイルがない場合
            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $list_controller_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル作成】";
                echo $fname . "\n";
            }
            // 再生成する場合
            else if($new_controller_flag){
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $list_controller_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル再生成】";
                echo $fname . "\n";
            }










            // FormController作成
            $form_controller_value = <<< EOF
<?php

namespace App\Http\Controllers\Generated\\${tableNameCamel};

use App\Http\Controllers\Default\Controller;

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

            $fpath = './app/Http/Controllers/Generated/'.$tableNameCamel;;
            $fname = $fpath . "/".$tableNameCamel."FormController.php";

            // ディレクトリがない場合
            $blade_dir_name = $fpath;
            if (!file_exists($blade_dir_name)) {
                mkdir($blade_dir_name); // ディレクトリ作成
                echo "【ディレクトリ作成】";
                echo $blade_dir_name . "\n";
            }
            // ファイルがない場合
            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $form_controller_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
            }
            // 再生成する場合
            else if($new_controller_flag){
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $form_controller_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル再生成】";
                echo $fname . "\n";
            }










            // DetailController作成
            $detail_controller_value = <<< EOF
<?php

namespace App\Http\Controllers\Generated\\${tableNameCamel};

use App\Http\Controllers\Default\Controller;

class ${tableNameCamel}DetailController extends Controller
{
    public function index(int \$id)
    {
        //  ページのタイトルを定義する
        \$title = '${tableName}詳細';

        return view('${tableName}.${tableName}_detail', compact(
            'id',
            'title',
        ));
    }
}

EOF;

            $fpath = './app/Http/Controllers/Generated/'.$tableNameCamel;
            $fname = $fpath . "/".$tableNameCamel."DetailController.php";
            
            // ディレクトリがない場合
            $blade_dir_name = $fpath;
            if (!file_exists($blade_dir_name)) {
                mkdir($blade_dir_name); // ディレクトリ作成
                echo "【ディレクトリ作成】";
                echo $blade_dir_name . "\n";
            }

            echo '-------------';
            echo "\n\n";
            echo $fname;
            echo "\n\n";
            echo '-------------';
            // ファイルがない場合
            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $detail_controller_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル作成】";
                echo $fname . "\n";
            }
            // 再生成する場合
            else if($new_controller_flag){
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $detail_controller_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル再生成】";
                echo $fname . "\n";
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
    <x-table column="{{ \$column }}" reponame="{{ \$repository_name }}" title="{{ \$title }}" index="{{ \$index }}" editflag="{{ \$edit_flag }}" detailflag="{{ \$detail_flag }}"/>
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

            // blade ファイルがない場合
            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $blade_list_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル作成】";
                echo $fname . "\n";
            }
            // 再生成する場合
            else if($new_blade_flag){
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $blade_list_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル再生成】";
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
            // 再生成する場合
            else if($new_blade_flag){
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $blade_list_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル再生成】";
                echo $fname . "\n";
            }








            // detail blade作成
            $blade_detail_value = <<< EOF
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
{{ Breadcrumbs::render('${tableName}.detail') }}

</body>
<script src="{{ asset('js/bootstrap.js') }}"></script>
</html>
EOF;

            $fpath = './resources/views/';
            $blade_dir_name = $fpath . $tableName;
            $fname = $blade_dir_name . "/" . $tableName . "_detail.blade.php";
            if (!file_exists($blade_dir_name)) {
                mkdir($blade_dir_name); // ディレクトリ作成
                echo "【ディレクトリ作成】";
                echo $blade_dir_name . "\n";
            }

            // blade ファイルがない場合
            if (!file_exists($fname)) {
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $blade_detail_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル作成】";
                echo $fname . "\n";
            }
            // 再生成する場合
            else if($new_blade_flag){
                $fhandle = fopen($fname, "w"); //ファイルを書き込みモードで開く。
                fwrite($fhandle, $blade_detail_value); //ファイルをバイナリモードで書き込む。第二引数に書き込みたい文字列
                fclose($fhandle); //ファイルポインタを閉じる
                echo "【ファイル再生成】";
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
    \$trail->push('${tableName}編集', url('/'));
});
Breadcrumbs::for('${tableName}.detail', function (\$trail) {
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
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/logout">ログアウト</a>
                    </li>
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
