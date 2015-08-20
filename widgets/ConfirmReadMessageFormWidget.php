<?php

/**
 * ConfirmReadMessageFormWidget.php
 * Created by: Michael Seeberger
 * Date: 18.08.15
 * Time: 21:17
 */
class ConfirmReadMessageFormWidget extends ContentFormWidget {
    public function renderForm()
    {
        $this->submitUrl = 'ConfirmReadMessages/ConfirmReadMessage/create';
        $this->submitButtonText = Yii::t('ConfirmReadMessageModule.widgets_ConfirmReadMessageFormWidget', 'Post');

        $this->form = $this->render('messageForm', array(), true);
    }
}
