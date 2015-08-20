<?php
/**
 * show.php
 * Created by: Michael Seeberger
 * Date: 18.08.15
 * Time: 16:29
 *
 * This view is shown when a user clicks on the "Confirmable" Navigation Item in the space navigation.
 *
 * It shows an FormWidget to create a new confirmable message and a stream widget which shows all existing messages.
 *
 * @package humhub.modules.ConfirmReadMessage.views
 * @since 0.1
 */
?>

<?php $this->widget('application.modules.ConfirmReadMessage.widgets.ConfirmReadMessageFormWidget', array('contentContainer' => $this->contentContainer)); ?>

<?php
//Yii::log($this->contentContainer->getDisplayName(), 'error');
$this->widget('application.modules.ConfirmReadMessage.widgets.ConfirmReadMessageStreamWidget', array(
    'contentContainer' => $this->contentContainer,
    'streamAction' => '//ConfirmReadMessages/ConfirmReadMessage/stream',
    'messageStreamEmpty' => ($this->contentContainer->canWrite()) ?
        Yii::t('ConfirmReadMessageModule.widgets_views_stream', '<b>There are no messages yet!</b><br>Be the first and create one...') :
        Yii::t('ConfirmReadMessageModule.widgets_views_stream', '<b>There are no messages yet!</b>'),
    'messageStreamEmptyCss' => ($this->contentContainer->canWrite()) ? 'placeholder-empty-stream' : '',
));
?>