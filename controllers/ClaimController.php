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
use yii\web\NotFoundHttpException;

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
            $model->scenario = 'ajax';

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
    }

    public function actionMyclaim()
    {
        return $this->render('myclaim', ['claims' => Claim::find(['user_id'=>Yii::$app->user->id])->orderBy([
      'date' => SORT_DESC
   ])->all()]);
    }

    public function actionAllclaim()
    {
        return $this->render('allclaim', ['claims' => Claim::find()->orderBy([
      'date' => SORT_DESC
   ])->all()]);
    }

    public function actionEdit($claim_id = null)
    {   
        if($model = Claim::findOne($claim_id))
        {   
            $status = preg_replace('/(^enum\(\')|(,\'\')|\)$/','',$model->tableSchema->columns['status']->dbType);

            $status = explode("','", substr($status, 0, -1));

            $photo = $model->photo;

            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
            {
                $model->status = $status[$model->status];

                if($model->status=='Отклонена')
                {
                    $model->scenario = 'editcause';
                }

                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($model);
            }

            if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()))
            {
                $model->status = $status[$model->status];
 
                if($model->status=='Отклонена')
                {
                    $model->scenario = 'editcause';
                }
                else if ($model->status=='Решена')
                {               
                    $model->scenario = 'editphoto'; 

                    $model->photo = UploadedFile::getInstance($model, 'photo');
                }  

                if($model->edit())
                {
                    return $this->redirect(['claim/allclaim']);
                }
                else
                {
                    $model->photo = $photo;
                }
            }

            return $this->render('claim_edit', ['claim' => $model, 'status' => $status, 'is_post' => Yii::$app->request->isPost]);
        }

        throw new NotFoundHttpException('Заявка не найдена');
    }   
}
