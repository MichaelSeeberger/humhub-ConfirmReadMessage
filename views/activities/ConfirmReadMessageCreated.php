<?php
/**
 * ConfirmReadMessageCreated.php
 * Created by: Michael Seeberger
 * Date: 18.08.15
 * Time: 21:29
 */
?>
<?php $this->beginContent('application.modules_core.activity.views.activityLayout', array('activity' => $activity)); ?>
<?php

echo Yii::t('ConfirmReadMessageModule.views_activities_ConfirmReadMessageCreated', '{userName} created a new {message}.', array(
    '{userName}' => '<strong>' . CHtml::encode($user->displayName) . '</strong>',
    '{message}' => ActivityModule::formatOutput($target->getContentTitle())
));
?>
<?php $this->endContent(); ?>
