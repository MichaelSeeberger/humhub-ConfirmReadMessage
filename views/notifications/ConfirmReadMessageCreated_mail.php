<?php
/**
 * ConfirmReadMessageCreated_mail.php
 * Created by: michaelseeberger
 * Date: 18.08.15
 * Time: 21:38
 */
?>
<?php $this->beginContent('application.modules_core.notification.views.notificationLayout', array('notification' => $notification)); ?>
<?php

echo Yii::t('PollsModule.views_notifications_ConfirmReadMessageCreated', '{userName} created a new poll and assigned you.', array(
    '{userName}' => '<strong>' . CHtml::encode($creator->displayName) . '</strong>'
));
?>
<?php $this->endContent(); ?>
