<?php

namespace xz1mefx\adminlte\web;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * Class AdminLteAsset
 * @package xz1mefx\adminlte\web
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/xz1mefx/yii2-adminlte/assets';

    public $css = [
        'adminlte-2.3.8/css/AdminLTE.css',
//        'adminlte-2.3.8/css/AdminLTE.min.css',
    ];

    public $js = [
        'adminlte-2.3.8/js/app.js',
//        'adminlte-2.3.8/js/app.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
//        'xz1mefx\adminlte\web\PluginsAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = '_all-skins';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }
            $this->css[] = sprintf('adminlte-2.3.8/css/skins/%s.min.css', $this->skin);
        }
        parent::init();
    }
}