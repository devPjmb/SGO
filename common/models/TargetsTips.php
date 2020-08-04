<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	use yii\web\UploadedFile;
	/**
	 * This is the model class for table "Menu".
	 *
	 * @property integer $MenuID
	 * @property string $MenuName
	 * @property string $ClassIcon
	 * @property string $ControllerUse
	 * @property integer $Type
	 * @property string $Path
	 *
	 * @property Page[] $page
	 */
	
	class TargetsTips extends ActiveRecord
	{
		use \common\components\RelationTrait;

		 /**
	     * @inheritdoc
	     */
	    public $PhotoTarget;
		public static function tableName()
		{
			return '{{%TargetsTips}}';
		}
		/**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            [['Tittle', 'Color'], 'required'],
	            [['Tittle'], 'string', 'max' => 160],
	            [['Color'], 'string', 'max' => 70],
	            [['PhotoTarget'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
	        ];
	    }

	    public function upload()
	    {
	        if ($this->validate()) {
	            $this->ImageUrl = $this->PhotoTarget->baseName . "-". substr(md5(uniqid(rand())),0,6) . '.' . $this->PhotoTarget->extension;
	            $this->PhotoTarget->saveAs(Yii::$app->basePath.'/../images/TargetTips/' .$this->ImageUrl );
	            $this->PhotoTarget = null;

	            return true;
	        } else {
	            return false;
	        }
	    }

		/**
	    * @return \yii\db\ActiveQuery
	     */
	    public function getTips()
	    {
	        return $this->hasMany(Tips::className(), ['TargetsTipsID' => 'TargetsTipsID']);
	    }
	}

?>