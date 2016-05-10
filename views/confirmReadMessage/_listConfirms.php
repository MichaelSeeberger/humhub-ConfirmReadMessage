<?php
/**
 * _listConfirms.php
 * Created by: michaelseeberger
 * Date: 19.08.15
 * Time: 22:52
 */
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel">
                <?php echo $title; ?>
            </h4>
            <br/>
        </div>


<div id="userlist-content">
    <ul class="media-list">
        <!-- BEGIN: Results -->
        <?php foreach ($confirmations as $confirmation) : ?>
            <?php
            // Check for null user, if there are "zombies" in search index
            if ($confirmation == null)
                continue;

            $user = $confirmation->user;
            //$dateFormatter = new CDateFormatter();
            ?>
            <li>
                <a href="<?php echo $user->getUrl(); ?>">

                    <div class="media">
                        <img class="media-object img-rounded pull-left"
                             src="<?php echo $user->getProfileImage()->getUrl(); ?>" width="50"
                             height="50" alt="50x50" data-src="holder.js/50x50"
                             style="width: 50px; height: 50px;">


                        <div class="media-body">
                            <h4 class="media-heading"><?php echo CHtml::encode($user->displayName); ?>
                                <?php if ($user->group != null) { ?>
                                    <small>(<?php echo CHtml::encode($user->group->name); ?>)</small><?php } ?>
                            </h4>
                            <h5>
                                <?php echo Yii::t('ConfirmReadMessageModule.views_ConfirmReadMessage__listConfirms', 'Read on') ?>
                                <?php echo Yii::app()->dateFormatter->formatDateTime($confirmation->created_at, 'medium', false); ?>
                                <?php echo Yii::t('ConfirmReadMessageModule.views_ConfirmReadMessage__listConfirms', 'at') ?>
                                <?php echo Yii::app()->dateFormatter->formatDateTime($confirmation->created_at, false, 'medium'); ?>
                                <small>
                                    (<?php
                                    $translationTable = 'ConfirmReadMessageModule.views_ConfirmReadMessage__listConfirms';
                                    $createdDate = new DateTime($messageCreatedAt);
                                    $readDate = new DateTime($confirmation->created_at);
                                    $interval = $createdDate->diff($readDate);
                                    $hasPrevious = false;
                                    if ($interval->y > 0) {
                                        $hasPrevious = true;

                                        echo $interval . " ";
                                        echo Yii::t($translationTable, $interval->y > 1 ? 'years' : 'year');
                                    }

                                    if ($interval->m > 0) {
                                        if ($hasPrevious) {
                                            echo " ";
                                        }
                                        $hasPrevious = true;

                                        echo $interval->m . " ";
                                        echo Yii::t($translationTable, $interval->m > 1 ? 'months' : 'month');
                                    }

                                    if ($interval->d > 0) {
                                        if ($hasPrevious) {
                                            echo " ";
                                        }
                                        $hasPrevious = true;

                                        echo $interval->d . " ";
                                        echo Yii::t($translationTable, $interval->d > 1 ? 'days' : 'day');
                                    }

                                    if ($interval->h > 0) {
                                        if ($hasPrevious) {
                                            echo " ";
                                        }

                                        echo $interval->i >= 30 ?  $interval->h + 1 : $interval->h . " ";
                                        echo Yii::t($translationTable, $interval->h > 1 ? 'hours' : 'hour');
                                    } else if ($interval->i > 0) {
                                        if ($hasPrevious) {
                                            echo " ";
                                        }
                                        echo $interval->i . " ";
                                        echo Yii::t($translationTable, $interval->i > 1 ? 'minutes' : 'minute');
                                    } else {
                                        echo "1 " . Yii::t('ConfirmReadMessageModule.views_ConfirmReadMessage__listConfirms', 'minute');
                                    }
                                    ?>)
                                </small>
                            </h5>
                        </div>
                    </div>
                </a>
            </li>


        <?php endforeach; ?>
        <!-- END: Results -->

    </ul>

    <div class="pagination-container">
        <?php
        $this->widget('HAjaxLinkPager', array(
            'currentPage' => $pagination->getCurrentPage(),
            'itemCount' => $pagination->getItemCount(),
            'pageSize' => HSetting::Get('paginationSize'),
            'maxButtonCount' => 5,
            'ajaxContentTarget' => '.modal-dialog',
            'nextPageLabel' => '<i class="fa fa-step-forward"></i>',
            'prevPageLabel' => '<i class="fa fa-step-backward"></i>',
            'firstPageLabel' => '<i class="fa fa-fast-backward"></i>',
            'lastPageLabel' => '<i class="fa fa-fast-forward"></i>',
            'header' => '',
            'htmlOptions' => array('class' => 'pagination'),
        ));
        ?>
    </div>


</div>


</div>

</div>

<script type="text/javascript">

    // scroll to top of list
    $(".modal-body").animate({ scrollTop: 0 }, 200);

</script>

