<?php

namespace RashedAlkhatib\DataTable;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;

class DataTable extends Widget
{
    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $options = [];

    /**
     * @var array the configuration options for the DataTable plugin.
     * @see https://datatables.net/reference/option/
     */
    public $clientOptions = [];

    /**
     * @var array the data to be used in the DataTable.
     */
    public $data = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Register DataTable assets
        DataTableAsset::register($this->getView());
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $tableOptions = empty($this->options) ? ['class' => 'table'] : $this->options;
        echo Html::beginTag('table', $tableOptions);
        echo Html::endTag('table');

        // Register the DataTable initialization script
        $this->registerClientScript();
    }

    /**
     * Registers the DataTable initialization script.
     */
    protected function registerClientScript()
    {
        $id = $this->getId();
        $options = empty($this->clientOptions) ? '{}' : Json::encode($this->clientOptions);

        $js = "jQuery('#$id').DataTable($options);";
        $this->getView()->registerJs($js, View::POS_READY, 'datatable-' . $id);
    }
}
