<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Users;

$this->title = 'Регистрация';
?>


            <h1>Список ваших заявок</h1>
            <br>
            <br>
  <div class="body-content">

        <div class="row">
        <?php if (empty($claims)):?>
            <h2>У вас пока что нет заявок</h2>
        <?php else:?>
            <?php foreach ($claims as $claim):?>           
            <div class="col-lg-6" style ="border: 1px solid gray">
                <label>Дата создания:<p><?= $claim->date ?></p></label>
                <br>
                <label>Название:<h2><?= $claim->title ?></h2></label>
                <br>
                <h2>Описание</h2>
                <p><?= $claim->description ?></p>
                <label>Категория:<h3><?= $claim->category->name ?></h3></label>
                <br>
                <label>Статус:<h3><?= $claim->status ?></h3></label>
            </div>
            <?php endforeach;?>
        <?php endif;?>
        </div>
    </div>
