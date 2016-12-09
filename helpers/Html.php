<?php

namespace xz1mefx\adminlte\helpers;

use yii\bootstrap\BaseHtml;
use yii\helpers\ArrayHelper;

/**
 * @inheritdoc
 */
class Html extends BaseHtml
{
    /**
     * @param string $bgClass it's can be:
     *
     *      label-default,
     *      label-primary,
     *      label-success,
     *      label-info,
     *      label-warning,
     *      label-danger,
     *      bg-red,
     *      bg-yellow,
     *      bg-aqua,
     *      bg-blue,
     *      bg-light-blue,
     *      bg-green,
     *      bg-navy,
     *      bg-teal,
     *      bg-olive,
     *      bg-lime,
     *      bg-orange,
     *      bg-fuchsia,
     *      bg-purple,
     *      bg-maroon,
     *      bg-black
     * @param string $label
     * @param array $options
     * @return string
     */
    public static function infoLabel($bgClass, $label, $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'span');
        static::addCssClass($options, ['label']);
        static::addCssClass($options, $bgClass);
        return static::tag($tag, $label, $options);
    }
}
