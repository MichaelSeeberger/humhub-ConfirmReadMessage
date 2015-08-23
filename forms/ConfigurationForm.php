<?php

/**
 * ConfigurationForm.php
 * Created by: Michael Seeberger
 * Date: 23.08.15
 * Time: 16:21
 */
class ConfigurationForm extends CFormModel
{
    public $markCreatorAsUnread;

    public function rules()
    {
        return array(
            array('markCreatorAsUnread', 'required')
        );
    }

    public function attributeLabels()
    {
        return array(
            'markCreatorAsUnread' => Yii::t('ConfirmReadMessageModule.widgets_ConfigurationForm', 'Mark the creator as unread')
        );
    }
}