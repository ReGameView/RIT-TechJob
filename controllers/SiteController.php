<?php

namespace app\controllers;

use app\models\Referal;
use app\models\SignupForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

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
        if(Yii::$app->request->get('user'))
        {
            Yii::$app->session->set('invited', Yii::$app->request->get('user'));
            return $this->redirect('/site/signup');
        }
        return $this->render('index');
    }

    public function actionSignup()
    {
        if(!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $invited = null;
        if(Yii::$app->session->get('invited'))
            $invited = User::find()->where(['username' => Yii::$app->session->get('invited')])->one();

        $model = new SignupForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate())
        {
            if($model->signup())
            {
                if(Yii::$app->session->get('invited'))
                {
                    $referal = new Referal();
                    $referal->id_invited = Yii::$app->user->identity->getId();
                    $referal->id_referal = $invited->id;
                    if($referal->save())
                        Yii::$app->session->remove('invited');
                }
                return $this->redirect('profile');
            }
        }

        $model->password = '';
        return $this->render('signup', [
            'invited' => $invited,
            'model' => $model
        ]);
    }

    public function actionProfile()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $dataProvider = Referal::getObjectInvited(Yii::$app->user->id);
        $user = User::findByUsername(Yii::$app->user->identity->username);
//        echo "<pre>";  var_dump(Referal::find()->joinWith('invited')->where(['id_referal' => Yii::$app->user->getId()])->all()[0]["invited"]->username); die;
        return $this->render('profile', [
            'user' => $user,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
