<?php 
    namespace common\models;

    use yii;
    use yii\base\Model;
    use yii\base\NotSupportedException;
    use yii\db\ActiveRecord;
    use yii\web\UploadedFile;

    class Maquinas extends ActiveRecord
    {
        public $PhotoMaquinas;
        public static function tableName()
        {
            return '{{%Maquinas}}';
        }
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['Description', 'Numero', 'Name'], 'required'],
                [['ImageUrl','Description','Name','Numero'], 'string'],
                [['PhotoMaquinas'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            ];
        }

        public function upload()
        {
            if ($this->validate()) {
                $this->ImageUrl = $this->PhotoMaquinas->baseName . "-" . substr(md5(uniqid(rand())),0,6) . '.' . $this->PhotoMaquinas->extension;
                $this->PhotoMaquinas->saveAs(Yii::$app->basePath . '/../images/Maquinas/' . $this->ImageUrl );
                $this->PhotoMaquinas = null;

                return true;
            } else {
                return false;
            }
        }

        public function attributeLabels()
        {
            return [
                'Description' => 'Descripción',
                'Name' => 'Nombre',
                'Numero' => 'Número',
                'Preview target' => 'Vista previa',
                'PhotoMaquinas' => 'Foto de máquina',
                'Numero de maquinas' => 'Número',
            ];
        }

        /**
        * @return \yii\db\ActiveQuery
        */
        public function getMBproducts()
        {
            return $this->hasOne(MBproducts::className(), ['MaquinasID' => 'MaquinasID']);
        }
 
    }

?>