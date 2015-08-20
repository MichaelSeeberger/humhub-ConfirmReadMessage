<?php
/**
 * entry.php
 * Created by: Michael Seeberger
 * Date: 18.08.15
 * Time: 17:41
 *
 * This view represents a wall entry of a message.
 * Used by ConfirmReadMessageWallEntryWidget.
 *
 * @package humhub.modules.ConfirmReadMessage.widgets.views
 * @since 0.1
 */
?>

<div class="panel panel-default">
    <div class="panel-body">
        <?php $this->beginContent('application.modules_core.wall.views.wallLayout', array('object' => $message)); ?>

        <?php echo CHtml::beginForm(); ?>

        <div style="margin-bottom: 2em;">
            <?php print nl2br($message->message); ?>
        </div>

        <?php
        if (!$message->hasUserConfirmed() && !Yii::app()->user->isGuest) {
            echo HHtml::ajaxSubmitButton(
                Yii::t('ConfirmReadMessageModule.widgets_views_entry', 'Confirm as Read'),
                $contentContainer->createUrl('/ConfirmReadMessages/ConfirmReadMessage/confirm', array('messageID' => $message->id)),
                array(
                    'dataType' => 'json',
                    'success' => "function(json) {  $('#wallEntry_'+json.wallEntryId).html(parseHtml(json.output)); }",
                ), array('id' => "ConfirmReadMessageConfirmButton_" . $message->id, 'class' => 'btn btn-primary', 'style' => 'margin-bottom: 1.5em;')
            );
        } else if ($message->hasUserConfirmed() && !Yii::app()->user->isGuest) {
            ?>
            <div style="margin-bottom: 1.5em;">
                <span class="btn btn-success"><?php echo Yii::t('ConfirmReadMessageModule.widgets_views_entry', 'Read'); ?></span>
            </div>
            <?php
        }

        echo CHtml::endForm();

        if (Yii::app()->user->isGuest) {
            echo HHtml::link(Yii::t('ConfirmReadMessageModule.widgets_views_entry', 'Vote'), Yii::app()->user->loginUrl, array('class' => 'btn btn-primary', 'data-target' => '#globalModal', 'data-toggle' => 'modal'));
        } else {
            $confirmedList = "";
            $unconfirmedList = "";
            $maxListItems = 5;

            for ($confirmedIndex = 0; $confirmedIndex < $confirmationsCount; $confirmedIndex++) {
                if ($confirmedIndex == $maxListItems) {
                    $confirmedList .= Yii::t('ConfirmReadMessageModule.widgets_views_entry', 'and {count} more', array('{count}' => (intval($confirmationsCount - $maxListItems))));
                    break;
                } else {
                    $confirmedList .= "<strong>".CHtml::encode($confirmations[$confirmedIndex]->user->displayName)."</strong><br>";
                }
            }

            for ($unconfirmedIndex = 0; $unconfirmedIndex < $unconfirmedUsersCount; $unconfirmedIndex++) {
                if ($unconfirmedIndex == $maxListItems) {
                    $unconfirmedList .= Yii::t('ConfirmReadMessageModule.widgets_views_entry', 'and {count} more', array('{count}' => (intval($unconfirmedUsersCount - $maxListItems))));
                    break;
                } else {
                    $unconfirmedList .= "<strong>".CHtml::encode($unconfirmedUsers[$unconfirmedIndex]->displayName)."</strong><br>";
                }
            }
            ?>

            <h5>
                <?php
                if ($confirmationsCount == 0) {
                    echo Yii::t('ConfirmReadMessageModule.widgets_views_entry', 'No confirmations yet');
                } else {
                    echo Yii::t('ConfirmReadMessageModule.widgets_views_entry', 'Read by:');
                    ?>

                    <a href="<?php echo $contentContainer->createUrl('//ConfirmReadMessages/ConfirmReadMessage/userListConfirmed', array('messageID' => $message->id));; ?>"
                       class="tt" data-toggle="modal" data-placement="top" title="" data-target="#globalModal"
                       data-original-title="<?php echo $confirmedList; ?>">
                        <?php echo Yii::t('ConfirmReadMessageModule.widgets_views_entry',
                            $confirmationsCount == 1 ? '{users_count} user' : '{users_count} users',
                            array('{users_count}' => $confirmationsCount)); ?>
                    </a>

                    <?php
                }
                ?>
            </h5>
            <h5>
                <?php
                if ($unconfirmedUsersCount == 0) {
                    echo Yii::t('ConfirmReadMessageModule.widgets_views_entry', 'No outstanding read confirmations');
                } else {
                    echo Yii::t('ConfirmReadMessageModule.widgets_views_entry', 'Unconfirmed by:');
                    ?>

                    <a href="<?php echo $contentContainer->createUrl('//ConfirmReadMessages/ConfirmReadMessage/userListUnconfirmed', array('messageID' => $message->id));; ?>"
                       class="tt" data-toggle="modal" data-placement="top" title="" data-target="#globalModal"
                       data-original-title="<?php echo $unconfirmedList; ?>">
                        <?php echo Yii::t('ConfirmReadMessageModule.widgets_views_entry',
                            $unconfirmedUsersCount == 1 ? '{users_count} user' : '{users_count} users',
                            array('{users_count}' => $unconfirmedUsersCount)); ?>
                    </a>

                    <?php
                }
                ?>
            </h5>

            <?php
        }

        $this->endContent();

        ?>
    </div>
</div>
