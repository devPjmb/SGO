<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\UserAccount;
use common\components\ValidUsers;


/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe;

    private $_user;
    public $_userData;
    private $_setdata;
    private $bandera = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            [['UserName'], 'string'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    //el que trajo original
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Usuario o Clave Incorrecta');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    //el que trajo original
    public function login()
    {
        if ($this->getUser()) {
            /**
            Yii::$app->user->login($this->_user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            */
            return true;
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_userData = UserAccount::findOne(['UserName' => $this->username]);
            if($this->_userData){
                if($this->_userData->UserPassword === md5($this->password)){
                    if(Yii::$app->user->login($this->_userData, $this->rememberMe ? 3600 * 24 * 30 : 0)){
                         $this->_user = Yii::$app->user->identity;
                    }else{
                        $this->addError('error', 'No pudo ingresar a su cuenta.');
                        $this->_user = null;
                    }
                }else{
                    $this->addError('error', 'Contraseña Incorrecta');
                    $this->_user = null;
                }

            }else{
                 $this->addError('error', 'Usuario Incorrecto');
                 $this->_user = null;
            }
        }
        return $this->_user;
    }
    /**
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_userData = UserAccount::findOne(['UserName' => $this->username]);
            if($this->_userData){
                if($this->_userData->UserPassword === md5($this->password)){
                    $this->_setdata = new ValidUsers(['_userData'=>$this->_userData]);
                    $this->_setdata->Setdata();
                    $this->_user = $this->_userData;
                }else{
                    $this->addError('error', 'Contraseña Incorrecta');
                    $this->_user = null;
                }

            }else{
                 $this->addError('error', 'Usuario Incorrecto');
                 $this->_user = null;
            }
        }
        return $this->_user;
    }
    */

}

    
