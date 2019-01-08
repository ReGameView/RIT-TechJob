<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Профиль '. Yii::$app->user->identity->username;;
$this->params['breadcrumbs'][] = $this->title;
/**
 * @param $user Object User
 */
?>

<h1>Профиль пользователя: <?=Yii::$app->user->identity->username ?></h1>
<hr>
    Реферальная ссылка: <?= $_SERVER['HTTP_HOST'] . '/site/?user=' . Yii::$app->user->identity->username?>
<hr>
    <h2>
        От вас пришли:
    </h2>
<?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'invited.email',
            'created_at'
        ]
    ]);
?>