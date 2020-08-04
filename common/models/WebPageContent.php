<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	use yii\web\UploadedFile;
	
	class WebPageContent extends ActiveRecord
	{
		public $UploadImage;
		public static function tableName()
		{
			return '{{%WebPageContent}}';
		}

		/**
	    * @return \yii\db\ActiveQuery
	     */

		public function rules() {
			return [
				[['Identify','Description'], 'required'],			
				[['TextShort','Description','TextLong','Tittle','Url'], 'string','max' => 1255],
				[['Identify'], 'string','max' => 20],
				[['UploadImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
			];
		}

		public function upload()
	    {
	        if ($this->validate()) {
	            $this->ImageUrl = $this->UploadImage->baseName . "-" . substr(md5(uniqid(rand())),0,6) . '.' . $this->UploadImage->extension;
	            $this->UploadImage->saveAs(Yii::$app->basePath . '/../images/site/' . $this->ImageUrl );
	            $this->UploadImage = null;

	            return true;
	        } else {
	            return false;
	        }
	    }


	}

?>