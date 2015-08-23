<?php

/**
 * ConfigurationController.php
 * Created by: Michael Seeberger
 * Date: 23.08.15
 * Time: 16:13
 */
class ConfigurationController extends Controller
{
    public $subLayout = "application.modules_core.admin.views._layout";

    public function filters()
    {
        return array('accessControl'); // Perform acces control (we only want admins to change settings)
    }

    // make sure only admins have access to the config
    public function accessRules()
    {
        return array(
            array('allow', 'expression' => 'Yii::app()->user->isAdmin()'),
            array('deny', 'users' => array('*'))
        );
    }

    /**
     * Show the configuration form.
     */
    public function actionIndex()
    {
        Yii::import('ConfirmReadMessages.forms.*');

        $form = new ConfigurationForm;

        // Allow ajax based validation
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'configure-form') {
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }

        if (isset($_POST['ConfigurationForm'])) {
            $_POST['ConfigurationForm'] = Yii::app()->input->stripClean($_POST['ConfigurationForm']);
            $form->attributes = $_POST['ConfigurationForm'];

            if ($form->validate()) {
                $form->markCreatorAsRead = HSetting::Set('markCreatorAsRead', $form->markCreatorAsRead, 'ConfirmReadMessage');
                $this->redirect(Yii::app()->createUrl('ConfirmReadMessages/configuration/index'));
            }
        } else {
            $form->markCreatorAsRead = HSetting::Get('markCreatorAsRead', 'ConfirmReadMessage');
        }

        $this->render('index', array('model' => $form));
    }
}