<?php

namespace xz1mefx\adminlte\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class ContentHeader
 * (include breadcrumb widget)
 * @package xz1mefx\adminlte\widgets
 */
class ContentHeader extends Widget
{
    public $title = '&nbsp;';
    public $titleSmall = '';
    public $breadcrumbsConfig = [];

    public function run()
    {
        if (empty($this->title)) {

        }
        $content = '';

        $content .= Html::beginTag('section', ['class' => 'content-header']);
        if (!empty($this->title)) {
            $content .= Html::beginTag('h1');
            $content .= $this->title;
            if (!empty($this->titleSmall)) {
                $content .= Html::beginTag('small');
                $content .= $this->titleSmall;
                $content .= Html::endTag('small');
            }
            $content .= Html::endTag('h1');
        }
        $content .= Breadcrumbs::widget($this->breadcrumbsConfig);
        $content .= Html::endTag('section');

        echo $content;
    }
}
