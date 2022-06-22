# Dougo

## Model,Repositoryを作成
```
$ php artisan make:orm
```

## 役割ごとにTOPページを作成
`/resources/views/user/[~]_list.blade.php`

`/resources/views/user/[~]_form.blade.php`

※変数名はスネークケース

## Controllerを作成
`/app/Http/Controllers/[~]ListController.php`

`/app/Http/Controllers/[~]FormController.php`

※変数名はキャメルケース

## Routeを追加
`/rotes/web.php`
```
use App\Http\Controllers\[~]ListController;
use App\Http\Controllers\[~]FormController;

Route::get('/[~]', [[~]ListController::class, 'index']);
Route::get('/[~]/{[~]_id}', [[~]FormController::class, 'index']);
```
