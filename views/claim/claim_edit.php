<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Users;

$this->title = 'Изменение статуса';
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-6">

            <h1>Изменение статуса</h1>
  
             <div class="col-lg-6">
                <label>Дата создания:<p><?= $claim->date ?></p></label>
                <br>
                <label>Название:<h2><?= $claim->title ?></h2></label>
                <br>
                <h2>Описание</h2>
                <p><?= $claim->description ?></p>
                <label>Категория:<h3><?= $claim->category->name ?></h3></label>
                <br>
 <div id ='photo-block'>               
                <img class="img-thumbnail" src="<?=  Yii::getAlias('@web').'/data/images/' . $claim->photo ?>">
  </div>                
                <?php if($claim->status =='Новая' || $is_post):?>

                 <?php
                $form = ActiveForm::begin([
                            'layout' => 'horizontal',
                            'enableAjaxValidation' => true,
                            'fieldConfig' => [
                                'template' => '{label}<div>{input}</div><div>{error}</div>',
                                'labelOptions' => ['class' => 'control-label'],
                            ],
                ]);
                ?>

                <?php $status_id = array_search($claim->status, $status); ?>

                <?= $form->field($claim, 'status')->dropDownList($status,['options' => [
            "{$status_id}" => ['Selected' => true]
        ]]) ?>
                <div id ='photo-field' style="display:<?= ($claim->status =='Решена' && $is_post)?'block':'none' ?>">
                    <?= $form->field($claim, 'photo')->fileInput() ?>
                </div>
                <div id ='cause-field' style="display:<?= ($claim->status =='Отклонена' && $is_post)?'block':'none' ?>">
                    <?= $form->field($claim, 'cause')->textArea() ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Изменить статус', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            <?php else: ?>
                <label>Статус:<h3><?= $claim->status ?></h3></label>
                <?php if($claim->status =='Решена'):?>
                <?php else: ?>
                <br>
                <label>Причина:<h2><?= $claim->cause ?></h2></label>
                <?php endif; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
