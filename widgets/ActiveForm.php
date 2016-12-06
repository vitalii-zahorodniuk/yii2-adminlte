<?php

namespace xz1mefx\adminlte\widgets;

/**
 * @inheritdoc
 */
class ActiveForm extends \yii\bootstrap\ActiveForm
{
    /**
     * @var string
     */
    public $fieldClass = 'xz1mefx\adminlte\widgets\ActiveField';

    /**
     * @inheritdoc
     * @return ActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }
}
