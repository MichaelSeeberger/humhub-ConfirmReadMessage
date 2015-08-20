<?php
/**
 * ConfirmReadMessageConfirmed_mail.php
 * Created by: Michael Seeberger
 * Date: 18.08.15
 * Time: 21:28
 */
?>
<?php $this->beginContent('application.modules_core.activity.views.activityLayoutMail', array('activity' => $activity, 'showSpace' => true)); ?>
<?php

echo Yii::t('ConfirmReadMessageModule.views_activities_ConfirmReadMessageConfirmed', '{userName} voted the {message}.', array(
    '{userName}' => '<strong>' . CHtml::encode($user->displayName) . '</strong>',
    '{message}' => ActivityModule::formatOutput($target->getContentTitle())
));
?>
<?php $this->endContent(); ?>
