<?php

namespace App\Admin\Actions\Education;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class AddExam extends RowAction
{
    public $name = 'copy';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }
}