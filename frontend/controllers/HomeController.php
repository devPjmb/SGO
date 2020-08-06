<?php 
	namespace frontend\controllers;

	use Yii;
	use yii\web\Controller;
    use common\components\ValidUsers;


	class HomeController extends Controller
	{
		private $_ValidUser;
		public $_MenuController = "";
		public $_PagePath = "";

		public function actionIndex()
		{	

			$UserData =  Yii::$app->AccessControl->Verify();
			
			$this->layout = $UserData->getLayout();
			// $this->layout = "/main";
			$data = [];
			return $this->render($UserData->typeUsers->UserHome,$data);
		}
       
	}