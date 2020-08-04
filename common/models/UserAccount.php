<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

class UserAccount extends ActiveRecord implements IdentityInterface
{
    public $PhotoProfile;
    public $auth_key;
    public $layoutUse;
    public static function tableName()
    {
        return '{{%UserAccount}}';
    }

    public function rules()
    {
        return [
            [['UserName'], 'required'],
            [['UserName'], 'string'],
            [['UserPassword','PhotoUrl'], 'string'],
            [['TypeUser'],'integer', 'integerOnly'=>true],
            [['PhotoProfile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

        ];
    }
     public function upload()
    {
        if ($this->validate()) {
            $this->PhotoUrl = $this->PhotoProfile->baseName . "_". substr(md5(uniqid(rand())),0,6) . '.' . $this->PhotoProfile->extension;
            $this->PhotoProfile->saveAs(Yii::$app->basePath.'/../images/profile/' .$this->PhotoUrl );
            $this->PhotoProfile = null;

            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'UserName' => 'Nombre de usuario',
            'UserPassword' => 'Clave de usuario',
            'TypeUser' => 'Tipo de Usuario',
            'PhotoProfile' => 'Foto de perfil',
        ];
    }

    public function getLayout()
    {
        /*switch ($this->TypeUser){
                         case '1':
                             $this->layoutUse = "/admin";
                             break;
                         case '2':
                             $this->layoutUse = "/main";
                             break;
                         case '3':
                             $this->layoutUse = "/";
                             break;
                     }*/
        return $this->typeUsers->Layout;
    }
        
     public function validatePassword($password)
    {
        return static::findOne(['UserPassword' => md5($password)]);
    }
    
    public static function findIdentity($id)
    {
        return static::findOne(['UserName' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
        /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
    * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['AccountID' => 'AccountID']);
    }
    public function getTypeUsers()
    {
        return $this->hasOne(TypeUsers::className(), ['TypeUsersID' => 'TypeUser']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
     */
    public function getUserByRole()
    {
        return $this->hasMany(UserByRole::className(), ['UserName' => 'UserName']);
    }

}
?>