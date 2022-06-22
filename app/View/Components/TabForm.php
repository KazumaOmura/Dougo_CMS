<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabForm extends Component
{
    public $columns;
    public $values;
    public $repository_name;

    public function __construct(string $column, string $reponame, int $userid)
    {
        $repository_name = "App\ORM\Generated\Repository\\".$reponame."Repository";
        $this->repository_name = $reponame;
        $this->values = $repository_name::getValueByID($userid);
        $this->columns = explode (",",$column);
    }

    public function render()
    {
        return view('components.tab_form');
    }
}
