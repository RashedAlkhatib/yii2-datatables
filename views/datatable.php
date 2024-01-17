<?php

use rashedalkhatib\datatable\DataTable;
use yii\helpers\Json;

// Render the DataTable widget with options and clientOptions
DataTable::widget([
    'options' => ['class' => 'table'],
    'columns' => ['Name', 'Email'],
    'clientOptions' => [
        'data' => $data,
        'paging' => true,
        'ordering' => true,
        // Add more DataTable options as needed
    ],
]);
