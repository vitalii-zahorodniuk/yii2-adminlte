<?php

/* @var $this yii\web\View */
/* @var $model \backend\models\forms\LoginForm */

use xz1mefx\adminlte\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-box">

    <div class="login-logo">
        <a href="/"><b>Y2</b>Shop</a>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form
            ->field($model, 'email')
            ->textInput([
                'type' => 'email',
                'placeholder' => $model->getAttributeLabel('email'),
            ])
            ->glyphIcon('user')
            ->label(false)
        ?>

        <?= $form
            ->field($model, 'password')
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
            ->glyphIcon('lock')
            ->label(false)
        ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
