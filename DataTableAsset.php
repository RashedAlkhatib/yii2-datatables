<?php

namespace rashedalkhatib\datatables;

use yii\web\AssetBundle;

/**
 * Class DataTableAsset
 * @package rashedalkhatib\datatables
 * @author Rashed Alkhatib
 * @email alkhatib.rashed@gmail.com
 */
class DataTableAsset extends AssetBundle
{

    public $sourcePath = '@vendor/rashedalkhatib/yii2-datatables';
    /**
     * @var array the CSS files that this bundle contains.
     */
    public $css = [
        'assets/css/jquery.dataTables.css',
    ];

    /**
     * @var array the JavaScript files that this bundle contains.
     */
    public $js = [
        'assets/js/jquery.dataTables.min.js',
        'assets/js/dataTables.buttons.min.js',
        'assets/js/buttons.flash.min.js',
        'assets/js/jszip.min.js',
        'assets/js/pdfmake.min.js',
        'assets/js/vfs_fonts.min.js',
        'assets/js/buttons.html5.min.js',
        'assets/js/custom.min.js'
    ];

    /**
     * @var array the options that are passed to \yii\web\View::registerJsFile() when registering the JS files.
     */
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];

    /**
     * @var array the options that are passed to \yii\web\View::registerCssFile() when registering the CSS files.
     */
    public $cssOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
    public $depends = [
        'yii\web\JqueryAsset', 
    ];
}
