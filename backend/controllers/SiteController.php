<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
 use common\components\ValidUsers;

/**
 * Site controller 
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'rules' => [
                     [
                         'actions' => ['login', 'error'],
                         'allow' => true,
                     ],
                     [
                         'actions' => ['logout', 'index'],
                         'allow' => true,
                         'roles' => ['@'],
                     ],
                 ],
             ],
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     // 'logout' => ['post'],
                 ],
             ],
         ];
     }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        // $data = Yii::$app->session->get('UserData');
        // $this->layout = "/admin";
        // (!Yii::$app->user->isGuest)? $this->layout = "404" :  $this->layout = "/main";
        $this->layout = false;
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
        if (!Yii::$app->user->isGuest) {
             return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
             }
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
       $this->layout = false;
            $data = [];
            if (!Yii::$app->user->isGuest) {
             return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
             }
              $model = new LoginForm();
              if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
            }else {
            $data['model'] =$model;
            // $post = Post::find()->asArray()->all();
            /*var_dump(Yii::$app->user->LayoutUser);exit;*/
            return $this->render('login',$data);
        }
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
