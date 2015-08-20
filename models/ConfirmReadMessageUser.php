<?php

/**
 * Created by PhpStorm.
 * User: Michael Seeberger
 * Date: 18.08.15
 * Time: 08:06
 */
class ConfirmReadMessageUser extends HActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'confirm_read_message_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('confirm_read_message_id, created_at, created_by, updated_at, updated_by', 'required'),
            array('confirm_read_message_id, created_by, updated_by', 'numerical', 'integerOnly' => true),
        );
    }

    public function relations()
    {
        return array(
            'confirm_read_message' => array(self::BELONGS_TO, 'confirm_read_message', 'id'),
            'user' => array(self::BELONGS_TO, 'User', 'created_by'),
        );
    }

}