<?php

namespace rashedalkhatib\datatables;

use yii\base\Widget;
use yii\helpers\Json;

/**
 * Class DataTable
 * @package app\widgets
 * @author Rashed Alkhatib
 * @email alkhatib.rashed@gmail.com
 */
class DataTable extends Widget
{
    public $ajaxConfig;
    public $columns = [];
    public $data = [];
    public $processing = true;
    public $serverSide = true;
    public $pageLength = 10;
    public $dom = 'Btip';
    public $buttons = [];
    public $id ;

    public function run()
    {
        $this->registerClientScript();
    }

    protected function registerClientScript()
    {
        $id = $this->id;
        $options = Json::encode([
            'data' => $this->data,
            'ajax' => $this->ajaxConfig,
            'columns' => $this->columns,
            'processing' => $this->processing,
            'serverSide' => $this->serverSide,
            'pageLength' => $this->pageLength,
            'dom' => $this->dom,
            'buttons' => $this->buttons,
        ]);

        $this->getView()->registerJs("$('#{$id}').DataTable($options);");
    }
}
