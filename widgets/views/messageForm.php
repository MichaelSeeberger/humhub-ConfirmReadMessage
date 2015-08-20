<?php
/**
 * messageForm.php
 * Created by: Michael Seeberger
 * Date: 18.08.15
 * Time: 17:26
 */

echo CHtml::textArea("message",
    "",
    array(
        'id'=>'contentForm_message',
        'class' => 'form-control autosize contentForm',
        'rows' => '1',
        "tabindex" => "1",
        "placeholder" => Yii::t('ConfirmReadMessageModule.widgets_views_messageForm', "Post something...")
    )
);
