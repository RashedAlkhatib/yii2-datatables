# DataTable Widget

## Overview

The DataTable widget is used to create interactive and dynamic data tables. The provided JavaScript code demonstrates how to initialize DataTable with server-side processing, custom data handling, and column rendering and with full serverside Export .
## installation
### in your Yii2 application :
- Run : ``composer require rashedalkhatib/yii2-datatables:1.0.0``
- go to your ``../frontend/assets/AppAsset.php``
    - add `rashedalkhatib\datatables\DataTableAsset` your `$depends` array
    - Ex: 
  ```phpregexp
              public $depends = [
                'yii\web\YiiAsset',
                'yii\bootstrap\BootstrapAsset',
                'yii\bootstrap\BootstrapPluginAsset',
                'rashedalkhatib\datatables\DataTableAsset'
        ];

## Usage Example (PHP Widget)
### - application side
```phpregexp
$searchFormSelector = '#searchForm';
$ajaxUrl = Url::to(['api/yourEndPoint']); // Adjust the URL based on your routes

// Define your DataTable columns
$columns = [
    [
        'title' => 'ID',
        'data' => 'id',
        'visible' => true,
        'render' => new JsExpression('function(data, type, row) {
            return "demo";
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
        'text' => 'Excel',
        'titleAttr' => 'Excel',
        'action' => new JsExpression('exportAll') // this is required 
    ],
];

// Configure Ajax settings
$ajaxConfig = [
    'url' => $ajaxUrl,
    'bdestroy' => true,
    'type' => 'POST',
    'data' => new JsExpression('function(d) {
            var searchForm = $('body').find('#searchForm').serializeArray();
            
            searchForm[searchForm.length] = { name: 'YourModel[page]', value: d.start }; // required
            searchForm[searchForm.length] = { name: 'YourModel[length]', value: d.length }; // required
            searchForm[searchForm.length] = { name: 'YourModel[draw]', value: d.draw }; // required
            
            var order = {
                'attribute': d.columns[d.order[0]['column']]['data'],
                'dir': d.order[0]['dir']
            }; // required
            
            searchForm[searchForm.length] = { name: 'YourModel[order]', value: JSON.stringify(order) };
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
    'id' => 'yourDataTable',
    'ajaxConfig' => $ajaxConfig,
    'columns' => $columns,
    'processing' => $processing,
    'serverSide' => $serverSide,
    'pageLength' => $pageLength,
    'dom' => $dom,
    'buttons' => $buttons,
]);

// The HTML container for your DataTable
echo '<form id="searchForm">// your inputs </form>';
echo '<table id="yourDataTable" class="display"></table>';
```
## Usage Example (Java Script)
### - application side
#### front end
```html
<form id="searchForm">
// your inputs 
</form>

<table id="yourDataTable" class="display" style="width:100%">


</table>
```
```javascript
var arrayToExport = [0,1];
$('#yourDataTable').DataTable({
    "ajax": {
        // Server-side processing configuration
        "url": "../api/yourEndPoint",
        "bdestroy": true, // this allows you to re init the dataTabel and destory it 
        "type": "POST", // request method
        "data": function (d) { // this represent the data you are sending with your ajax request
            // Custom function for sending additional parameters to the server
            var searchForm = $('body').find('#searchForm').serializeArray();
            
            searchForm[searchForm.length] = { name: "YourModel[page]", value: d.start }; // required
            searchForm[searchForm.length] = { name: "YourModel[length]", value: d.length }; // required
            searchForm[searchForm.length] = { name: "YourModel[draw]", value: d.draw }; // required
            
            var order = {
                'attribute': d.columns[d.order[0]['column']]['data'],
                'dir': d.order[0]['dir']
            }; // required
            
            searchForm[searchForm.length] = { name: "YourModel[order]", value: JSON.stringify(order) };
            return searchForm;
        },
        dataSrc: function (d) {
            // Custom function to handle the response data
            // EX:
            var searchForm = $('body').find('#searchForm').serializeArray();
            if (d.validation) {
                searchForm.yiiActiveForm('updateMessages', d.validation, true);
                return [];
            }
            return d.data;
        }
    },
    "columns": [{
        // Column configurations
        "title": "ID",
        "data": "id",
        "visible": true // visablity of column 
    },
    // ... (other columns)
    {
        "title": "Actions",
        "data": "id",
        "visible": actionCol,
        "render": function (data, type, row) {
            // Custom rendering function for the "Actions" column
            return '<a class="showSomething" data-id="' + row.id + '">View</a>';
        }
    }],
    processing: true,
    serverSide: true,
    "pageLength": 10,
    dom: "Btip",
    "buttons": [{
        // "Excel" button configuration
        "extend": 'excel',
        exportOptions: {
            columns: arrayToExport
        },
        "text": '  Excel',
        "titleAttr": 'Excel',
        "action": exportAll // newexportaction this action is to allow you exporting with server side without rendaring data 
    }],
});
```
### application back end
#### these params should be sent to the API
```injectablephp
// in your HTTP request you want to include these params 
   $_postData = [
   'page' => $this->page == 0 ? 0 : $this->page / $this->length, // this equation is required to handle Yii2 Data provider Logic
   'limit' => $this->length,
   'export' => $this->export,
   'order' => $this->order,
   // add your custom params .....
   ];
```
#### these params should be returned to the Datatable endpoint
```phpregexp
return $this->asJson(
                    [
                        'data' => $_scoreData->data,
                        'draw' => $_scoreSearchForm->draw,
                        'recordsTotal' => $_scoreData->count, 
                        'recordsFiltered' => $_scoreData->count
                ]);
```
## Usage API Side
#### yourEndPoint action
```injectablephp
    public function actionYourEndPoint()
    {

        $searchModel = new SearchModel();

        $dataProvider = $searchModel->search(Yii::$app->request->get());
        return $this->asJson(
            array(
                'data' => $dataProvider['data'],
                'count' => $dataProvider['count']
            )
        );

    }
```
#### search function
```injectablephp
    public function search($params)
    {
        $this->load($params, ''); // load your values into the model
        $query = Data::find(); // Data model is your link to the database

        $_order = json_decode($this->order);
        if ($this->export == 'true') {
            $dataProvider = new ActiveDataProvider([
                'query' => $query
                // we removed the page and pageSize keys to allow all data to be exported
            ]);
        } else {
            $_orderType = SORT_ASC;
            if ($_order->dir == 'desc')
                $_orderType = SORT_DESC;
            $query->orderBy([$_order->attribute => $_orderType]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => $this->limit,
                    'page' => $this->page,
                ],
            ]);
        }


        return array(
            'data' => $dataProvider->getModels(),
            'count' => $dataProvider->getTotalCount()
        );
    }
```

## Feel Free to contact me : alkhatib.rashed@gmail.com
