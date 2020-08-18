<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Account extends ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%Account}}';
    }

  /**
 	* @return \yii\db\ActiveQuery
	 */
	public function getUserAccount()
	{
	    return $this->hasOne(UserAccount::className(), ['AccountID' => 'AccountID']);
	}

	/**
 	* @return \yii\db\ActiveQuery
	 */
	public function getAgency()
	{
	    return $this->hasOne(Agency::className(), ['AccountID' => 'AccountID']);
	}

	public function getOrdersNoStarted()
	{
	    return $this->hasMany(Orders::className(), ['AccountID' => 'AccountID'])->andOnCondition(['Status'=>0]);
	}

	public function getOrdersStarted()
	{
	    return $this->hasMany(Orders::className(), ['AccountID' => 'AccountID'])->andOnCondition(['Status'=>1]);
	}

	public function getOrdersComplete()
	{
	    return $this->hasMany(Orders::className(), ['AccountID' => 'AccountID'])->andOnCondition(['Status'=>2]);
	}

	public function getOrdersDelivered()
	{
	    return $this->hasMany(Orders::className(), ['AccountID' => 'AccountID'])->andOnCondition(['Status'=>3]);
	}

	public function getOrdersStop()
	{
	    return $this->hasMany(Orders::className(), ['AccountID' => 'AccountID'])->andOnCondition(['Status'=>4]);
	}

	public function getOrders()
	{
	    return $this->hasMany(Orders::className(), ['AccountID' => 'AccountID']);
	}




}
?>