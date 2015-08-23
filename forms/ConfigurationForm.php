<?php

/**
 * ConfigurationForm.php
 * Created by: Michael Seeberger
 * Date: 23.08.15
 * Time: 16:21
 */
class ConfigurationForm extends CFormModel
{
    public $markCreatorAsRead;

    public function rules()
    {
        return array(
            array('markCreatorAsRead', 'required')
        );
    }

    public function attributeLabels()
    {
        return array(
            'markCreatorAsRead' => Yii::t('ConfirmReadMessageModule.widgets_ConfigurationForm', 'Mark the creator as read')
        );
    }
}