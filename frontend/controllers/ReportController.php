<?php 
	namespace frontend\controllers;
	use Yii;

	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;
    
    use common\models\UserAccount;
    use common\models\Orders;

	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\data\BaseDataProvider;
	
	use yii\db\Expression;

	class ReportController extends Controller
	{
		private $_valiUser;

		public function actionIndex()
		{
			$UserData = Yii::$app->AccessControl->Verify([4]);
			$this->layout = $UserData->getLayout();
			
			$data = array();

			if($_POST){
				$userID = Yii::$app->request->post('userID');
				$starDate = Yii::$app->request->post('startDate');
				$endDate  = Yii::$app->request->post('endDate');
				$status  = Yii::$app->request->post('status');

				if($status > 0){
					$ordersFind = Orders::find()->where(['AccountID'=>$userID])->andwhere(['between', 'DeliveryDate', $starDate, $endDate])->andwhere(['Status'=>$status]);
				}else{
					$ordersFind = Orders::find()->where(['AccountID'=>$userID])->andwhere(['between', 'DeliveryDate', $starDate, $endDate]);
				}

				$data['dataReport']  = new ActiveDataProvider([
					'query' => $ordersFind,
					'pagination' => [
						'pageSize' => 20,
					],
				]);
			}

			$data['listUser'] = ArrayHelper::map(UserAccount::find()->all(), 'AccountID', function ($data){
				return $data->UserName;
			});
			return $this->render('index', $data);
		}
	}