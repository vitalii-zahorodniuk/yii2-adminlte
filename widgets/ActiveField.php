<?php

namespace xz1mefx\adminlte\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class ActiveField
 * @package xz1mefx\adminlte\widgets
 */
class ActiveField extends \yii\bootstrap\ActiveField
{
    /**
     * @inheritdoc
     */
    public $template = "{label}\n{input}\n{glyphIcon}\n{hint}\n{error}";

    private $_glyphIconAllowed = false;

    /**
     * @inheritdoc
     */
    public function render($content = NULL)
    {
        if ($content === NULL) {
            if (!isset($this->parts['{beginWrapper}'])) {
                $options = $this->wrapperOptions;
                $tag = ArrayHelper::remove($options, 'tag', 'div');
                $this->parts['{beginWrapper}'] = Html::beginTag($tag, $options);
                $this->parts['{endWrapper}'] = Html::endTag($tag);
            }
            if ($this->enableLabel === false) {
                $this->parts['{label}'] = '';
                $this->parts['{beginLabel}'] = '';
                $this->parts['{labelTitle}'] = '';
                $this->parts['{endLabel}'] = '';
            } elseif (!isset($this->parts['{beginLabel}'])) {
                $this->renderLabelParts();
            }
            if ($this->enableError === false) {
                $this->parts['{error}'] = '';
            }
            if ($this->inputTemplate) {
                $input = isset($this->parts['{input}']) ?
                    $this->parts['{input}'] : Html::activeTextInput($this->model, $this->attribute, $this->inputOptions);
                $this->parts['{input}'] = strtr($this->inputTemplate, ['{input}' => $input]);
            }
        }
        return parent::render($content);
    }

    /**
     * @inheritdoc
     */
    public function begin()
    {
        if ($this->form->enableClientScript) {
            $clientOptions = $this->getClientOptions();
            if (!empty($clientOptions)) {
                $this->form->attributes[] = $clientOptions;
            }
        }

        $inputID = $this->getInputId();
        $attribute = Html::getAttributeName($this->attribute);
        $options = $this->options;
        $class = isset($options['class']) ? [$options['class']] : [];
        $class[] = "field-$inputID";
        if ($this->model->isAttributeRequired($attribute)) {
            $class[] = $this->form->requiredCssClass;
        }
        if ($this->model->hasErrors($attribute)) {
            $class[] = $this->form->errorCssClass;
        }
        $options['class'] = implode(' ', $class);
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        if (!empty($this->parts['{glyphIcon}'])) {
            $options['class'] = $options['class'] . (empty($options['class']) ? '' : ' ') . 'has-feedback';
        }

        return Html::beginTag($tag, $options);
    }

    /**
     * @inheritdoc
     */
    public function label($label = NULL, $options = [])
    {
        if (is_bool($label)) {
            $this->enableLabel = $label;
            if ($label === false && $this->form->layout === 'horizontal') {
                Html::addCssClass($this->wrapperOptions, $this->horizontalCssClasses['offset']);
            }
        } else {
            $this->enableLabel = true;
            $this->renderLabelParts($label, $options);
            parent::label($label, $options);
        }
        return $this;
    }

    /**
     * Working only with inputs where type is text or password
     *
     * You must set field first
     *
     * @param $glyphIcon string Icon name
     * @return $this
     */
    public function glyphIcon($glyphIcon)
    {
        if (empty($glyphIcon) || !$this->_glyphIconAllowed) {
            $this->parts['{glyphIcon}'] = '';
            return $this;
        }

        $this->parts['{glyphIcon}'] = Html::tag('span', '', ['class' => "glyphicon glyphicon-$glyphIcon form-control-feedback"]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function input($type, $options = [])
    {
        $this->_glyphIconAllowed = true;
        return parent::input($type, $options);
    }

    /**
     * @inheritdoc
     */
    public function textInput($options = [])
    {
        $this->_glyphIconAllowed = true;
        return parent::textInput($options);
    }

    /**
     * @inheritdoc
     */
    public function passwordInput($options = [])
    {
        $this->_glyphIconAllowed = true;
        return parent::passwordInput($options);
    }
}
