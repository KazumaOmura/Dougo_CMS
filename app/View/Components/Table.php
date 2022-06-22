<?php

namespace App\View\Components;

use Illuminate\View\Component;
use function App\Http\Controllers\convSnake;

class Table extends Component
{
    public $columns;
    public $values;
    public $title;
    public $repository_name_snake;
    public $index;


    public function __construct(string $column, string $reponame, string $title, string $index)
    {
        $repository_name = "App\ORM\Generated\Repository\\".$reponame."Repository";
        $this->values = $repository_name::getAll();
        $this->columns = explode (",",$column);
        $this->title = $title;
        $this->index = explode (",",$index);

        //　modelクラス名からテーブル名に変換(キャメルケース->スネークケース)
        $this->repository_name_snake = strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($reponame))).PHP_EOL;
//        $this->repository_name_snake = strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($repository_name))).PHP_EOL;
    }

    public function render()
    {
        return view('components.table');
    }
}
