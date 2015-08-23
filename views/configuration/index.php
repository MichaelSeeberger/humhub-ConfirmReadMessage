<?php
/**
 * index.php
 * Created by: Michael Seeberger
 * Date: 23.08.15
 * Time: 17:08
 */
?>

<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('ConfirmReadMessagesModule.views_configuration_index', 'Confirmation Configuration'); ?></div>
<div class="panel-body">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'configure-form',
            'enableAjaxValidation' => true,
        ));
        ?>

        <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <label>
            <?php
            $attributes = array();
            if ($model->markCreatorAsRead) {
                $attributes['checked'] = 'checked';
            }
            ?>
            <?php echo $form->checkBox($model, 'markCreatorAsRead', $attributes); ?> <?php
            echo $model->attributeLabels()['markCreatorAsRead'];
            ?>
        </label>
        <?php echo $form->error($model, 'markCreatorAsRead'); ?>
    </div>

    <hr>
    <?php echo CHtml::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-primary')); ?>
    <a class="btn btn-default" href="<?php echo $this->createUrl('//admin/module'); ?>"><?php echo Yii::t('AdminModule.base', 'Back to modules'); ?></a>

    <?php $this->endWidget(); ?>
</div>
</div>