<?php

/**
 * ConfirmReadMessageCreatedNotification.php
 * Created by: Michael Seeberger
 * Date: 18.08.15
 * Time: 21:42
 */
class ConfirmReadMessageCreatedNotification extends Notification
{
    // Path to Web View of this Notification
    public $webView = "ConfirmReadMessage.views.notifications.ConfirmReadMessageCreated";
    // Path to Mail Template for this notification
    public $mailView = "application.modules.ConfirmReadMessage.views.notifications.ConfirmReadMessageCreated_mail";
}