<?php 
	namespace backend\controllers;

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
			$this->_ValidUser = new ValidUsers;
			$this->_ValidUser->AccesControl([1,2]);
			// 1 = Users Admin
			// 2 = Users moderador

			$data = Yii::$app->session->get('UserData');
			$this->layout = $data['LayoutUser'];
			// $this->layout = "/main";


			switch ($data['TypeUser']){
				case '1':
					return $this->render('homeadmin',$data);
					break;
				case '2':
					return $this->render('homemod',$data);
					break;
				case '3':
					return $this->render('homeguest',$data);
					break;
				default:
					return $this->redirect(Yii::$app->urlManager->createUrl('/'));
				break;
			}
		}
       
	}