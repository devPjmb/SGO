<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
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
	
	class Menu extends ActiveRecord
	{
		use \common\components\RelationTrait;

		 /**
	     * @inheritdoc
	     */
		public static function tableName()
		{
			return '{{%Menu}}';
		}
		/**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            [['MenuName', 'ControllerUse','Type','ClassIcon'], 'required'],
	            [['MenuName','ClassIcon','Path','ControllerUse'], 'string', 'max' => 74],
	        ];
	    }

		/**
	    * @return \yii\db\ActiveQuery
	     */
	    public function getMenuByRole()
	    {
	        return $this->hasMany(MenuByRole::className(), ['MenuID' => 'MenuID']);
	    }
	    /**
	    * @return \yii\db\ActiveQuery
	     */
	    public function getPage()
	    {
	        return $this->hasMany(Page::className(), ['MenuID' => 'MenuID']);
	    }
	}

?>