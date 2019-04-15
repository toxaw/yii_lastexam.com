<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>
    
    
    <div class='errors' style="color:red;opacity:0" >
    </div>
    
    <div class='success' style="color:green">
    </div>
    
    <form id="login-form-ajax">
        <input type="text" name="login">
        <input type="password" name="password">
        <input type="checkbox" name="remember">
        <input type="submit">
    </form>
</div>