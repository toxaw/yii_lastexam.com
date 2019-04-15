<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
//use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Registr;
use app\models\Login;
use app\components\Controller;
use app\models\Claim;
use yii\bootstrap\ActiveForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['claims' => Claim::find()->where(['status'=>'Решена'])->orderBy([
          'date' => SORT_DESC
       ])->limit(8)->all()]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
   /* public function actionLogin()
    {
        $model = new Login();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) 
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) 
        {
            if ($user = $model->login()) 
            {
                if (Yii::$app->getUser()->login($user)) 
                {
                    return Yii::$app->user->identity->is_admin?$this->goHome():$this->redirect(['claim/myclaim']);
                }
            }
        }
        
        $model->password = '';
        
        return $this->render('login', [
                    'model' => $model,
        ]);

    }*/

    public function actionLogin()
    {
        $model = new Login();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) 
        {

            Yii::$app->response->format = Response::FORMAT_JSON;
            
            if($model->validate())
            {
                if ($user = $model->login()) 
                {
                    Yii::$app->getUser()->login($user);
                }
                else
                {
                    return ['login-login' => $model->getErrors()['login']];
                }
            }
            else
            {
                return ActiveForm::validate($model);
            }
        }

        if ($model->load(Yii::$app->request->post())) 
        {
            if ($user = $model->login()) 
            {
                if (Yii::$app->getUser()->login($user)) 
                {
                    return Yii::$app->user->identity->is_admin?$this->goHome():$this->redirect(['claim/myclaim']);
                }
            }
        }
        print_r($model->getErrors());
        $model->password = '';
        
        return $this->render('login', [
                    'model' => $model,
        ]);

    }

    public function actionRegistr()
    {
        $model = new Registr();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) 
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) 
        {
            if ($user = $model->registr()) 
            {
                if (Yii::$app->getUser()->login($user)) 
                {
                    return Yii::$app->user->identity->is_admin?$this->goHome():$this->redirect(['claim/myclaim']);
                }
            }
        }

        return $this->render('registr', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
