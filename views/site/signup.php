<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @param $invited Object User Referal | null
 */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Пожалуйста для регистрации заполните форму:</p>
    <?php
        if($invited != null):
    ?>
        <h3>
            Вы пришли от пользователя: <b><?=$invited->email ?></b>
        </h3>

    <?php
    endif;
    ?>
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "{input} {label}</div>\n<div class=\"col-lg-8\">{error}",
            ]) ?>
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>