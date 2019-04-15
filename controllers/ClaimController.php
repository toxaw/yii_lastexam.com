<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
//use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\components\Controller;

use app\models\Claim;

use app\models\Category;

use yii\bootstrap\ActiveForm;


use yii\web\UploadedFile;

class ClaimController extends Controller
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionAdd()
    {
        $model = new Claim();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) 
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()))
        {
            $model->scenario = 'notajax';

            $model->photo = UploadedFile::getInstance($model, 'photo');

            if($model->create())
            {
                return $this->redirect(['claim/myclaim']);
            }
        }

        return $this->render('claim_create', [
                    'model' => $model,
                    'categories' => \yii\helpers\ArrayHelper::map(Category::find()->all(), 'id', 'name')
        ]);

       /* if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) 
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
                    return $this->goHome();
                }
            }
        }
        
        $model->password = '';
        
        return $this->render('login', [
                    'model' => $model,
        ]);*/

    }
}
