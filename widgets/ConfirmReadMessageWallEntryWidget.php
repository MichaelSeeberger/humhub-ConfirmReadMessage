<?php
/**
 * Created by: Michael Seeberger
 * Date: 18.08.15
 * Time: 11:58
 */

/**
 * Class ConfirmReadMessageWallEntryWidget is used to display a message inside the stream.
 *
 * This widget will be used by the ConfirmReadMessage Model in the method getWallOut.
 */
class ConfirmReadMessageWallEntryWidget extends HWidget {
    public $message;

    public function run()
    {
        $confirmations = $this->message->confirmations();
        $confirmationsCount = count($confirmations);

        $unconfirmedUsers = $this->message->unconfirmedUsers();
        $unconfirmedUsersCount = count($unconfirmedUsers);

        $this->render('entry', array(
            'message' => $this->message,
            'user' => $this->message->content->user,
            'contentContainer' => $this->message->content->container,
            'confirmationsCount' => $confirmationsCount,
            'unconfirmedUsersCount' => $unconfirmedUsersCount,
            'confirmations' => $confirmations,
            'unconfirmedUsers' => $unconfirmedUsers
        ));
    }
}