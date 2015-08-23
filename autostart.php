<?php

Yii::app()->moduleManager->register(array(
    'id' => 'ConfirmReadMessages',
    'class' => 'application.modules.ConfirmReadMessage.ConfirmReadMessageModule',
    'import' => array(
        'application.modules.ConfirmReadMessage.models.*',
        'application.modules.ConfirmReadMessage.behaviors.*',
        'application.modules.ConfirmReadMessage.notifications.*',
        'application.modules.ConfirmReadMessage.*',
    ),
    'configRoute' => '//ConfirmReadMessages/configuration/index',
    // Events to Catch 
    'events' => array(
        array('class' => 'User', 'event' => 'onBeforeDelete', 'callback' => array('ConfirmReadMessageModule', 'onUserDelete')),
        array('class' => 'SpaceMenuWidget', 'event' => 'onInit', 'callback' => array('ConfirmReadMessageModule', 'onSpaceMenuInit')),
    ),
));
?>