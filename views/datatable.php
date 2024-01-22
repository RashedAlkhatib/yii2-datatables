<?php
/**
 * @author Rashed Alkhatib
 * @email alkhatib.rashed@gmail.com
 */
use rashedalkhatib\datatables\DataTable;
use yii\helpers\Url;
use yii\web\JsExpression;

$searchFormSelector = '#searchForm';
$ajaxUrl = Url::to(['your/data-table']); // Adjust the URL based on your routes

// Define your DataTable columns
$columns = [
    [
        'title' => 'ID',
        'data' => 'id',
        'visible' => true,
    ],
    [
        'title' => 'Name',
        'data' => 'name',
        'visible' => true,
    ],
    // Add other columns as needed
    [
        'title' => 'Actions',
        'data' => 'id',
        'visible' => true,
        'render' => new JsExpression('function(data, type, row) {
            return \'<a class="showSomething" data-id="\' + row.id + \'">View</a>\';
        }'),
    ],
];

// Configure other DataTable parameters
$processing = true;
$serverSide = true;
$pageLength = 10;
$dom = 'Btip';
$buttons = [
    [
        'extend' => 'excel',
        'exportOptions' => [
            'columns' => [0, 1],
        ],
        'text' => 'Excel',
        'titleAttr' => 'Excel',
        'action' => new JsExpression('exportAll'), // Assuming exportAll is a JavaScript function
    ],
];

// Configure Ajax settings
$ajaxConfig = [
    'url' => $ajaxUrl,
    'bdestroy' => true,
    'type' => 'POST',
    'data' => new JsExpression('function(d) {
        var searchForm = $("' . $searchFormSelector . '").serializeArray();
        // Add other data manipulation logic as needed
        return searchForm;
    }'),
    'dataSrc' => new JsExpression('function(d) {
        var searchForm = $("' . $searchFormSelector . '").serializeArray();
        if (d.validation) {
            searchForm.yiiActiveForm("updateMessages", d.validation, true);
            return [];
        }
        return d.data;
    }'),
];

// Use the DataTableWidget with configured parameters
DataTable::widget([
    'ajaxConfig' => $ajaxConfig,
    'columns' => $columns,
    'processing' => $processing,
    'serverSide' => $serverSide,
    'pageLength' => $pageLength,
    'dom' => $dom,
    'buttons' => $buttons,
]);

// The HTML container for your DataTable
echo '<table id="yourDataTable" class="display"></table>';
// Add any other necessary JavaScript code
