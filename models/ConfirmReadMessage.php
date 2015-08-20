<?php

/**
 * Created by PhpStorm.
 * User: michaelseeberger
 * Date: 18.08.15
 * Time: 08:06
 */
class ConfirmReadMessage extends HActiveRecordContent
{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $theClassName
     * @return CActiveRecord
     */
    public static function model($theClassName = __CLASS__)
    {
        return parent::model($theClassName);
    }

    /**
     * @return string The associated DB table name.
     */
    public function tableName()
    {
        return 'confirm_read_message';
    }

    /**
     * @return array Validation rules for the model.
     */
    public function rules()
    {
        return array(
            array('message', 'required'),
            array('created_by, updated_by', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'message' => Yii::t('ConfrimReadMessageModule.models_ConfirmReadMessage', 'Message')
        );
    }

    /**
     * @return array The relations
     */
    public function relations()
    {
        return array(
            'confirmations' => array(self::HAS_MANY, 'ConfirmReadMessageUser', 'confirm_read_message_id'),
        );
    }

    public function afterSave()
    {
        parent::afterSave();

        if (!$this->isNewRecord) {
            return true;
        }

        $activity = Activity::CreateForContent($this);
        $activity->type = "ConfirmReadMessageCreated";
        $activity->module = "ConfirmReadMessages";
        $activity->save();
        $activity->fire();

        return true;
    }

    /**
     * Delete dependencies
     * @return bool
     */
    public function beforeDelete()
    {
        foreach ($this->confirmations as $aConfirmation) {
            $aConfirmation->delete();
        }

        Notification::remove('ConfirmReadMessage', $this->id);

        return parent::beforeDelete();
    }

    /**
     * Check if a user has already confirmed the message as read, false otherwise.
     *
     * @param string $aUserID
     * @return bool true if the user has confirmed the message as read, false otherwise.
     */
    public function hasUserConfirmed($aUserID = "")
    {
        if ($aUserID == "")
            $aUserID = Yii::app()->user->id;

        $theConfirmation = ConfirmReadMessageUser::model()->findByAttributes(array('created_by' => $aUserID, 'confirm_read_message_id' => $this->id));

        return $theConfirmation != null;
    }

    /**
     * Let the user confirm the message.
     *
     * @throws CHttpException
     */
    public function confirm()
    {
        if ($this->hasUserConfirmed())
            return;

        $theConfirmation = new ConfirmReadMessageUser();
        $theConfirmation->confirm_read_message_id = $this->id;

        if (!$theConfirmation->save())
            return;

        $theActivity = Activity::CreateForContent($this);
        $theActivity->type = "ConfirmReadMessageConfirmed";
        $theActivity->module = "ConfirmReadMessages";
        $theActivity->save();
        $theActivity->fire();
    }

    /**
     * Let a user "unconfirm" a message.
     *
     * @param string $aUserID
     * @throws CDbException
     */
    public function resetConfirm($aUserID = "")
    {
        if ($aUserID == "")
            $aUserID = Yii::app()->user-id;

        if (!$this->hasUserConfirmed($aUserID))
            return;

        $theConfirmation = ConfirmReadMessageUser::model()->findByAttributes(array('created_by' => $aUserID, 'confirm_read_message_id' => $this->id));
        $theConfirmation->delete();

        $activity = Activity::model()->findByAttributes(array(
            'type' => 'MessageConfirmed',
            'object_model' => "ConfirmReadMessage",
            'created_by' => $aUserID,
            'object_id' => $this->id
        ));

        if ($activity)
            $activity->delete();
    }

    public function getWallOut()
    {
        return Yii::app()->getController()->widget('application.modules.ConfirmReadMessage.widgets.ConfirmReadMessageWallEntryWidget', array('message' => $this), true);
    }

    public function getContentTitle()
    {
        return Yii::t('ConfirmReadMessageModule.models_ConfirmReadMessage', "Message") . " \"" . Helpers::truncateText($this->message, 25) . "\"";
    }

    /**
     * @param array|false $limit Two keys: start for the start index and count for number of results.
     * @return CActiveRecord[]
     */
    public function unconfirmedUsers($limit = false)
    {
        $sql = $this->unconfirmedUsersSQL();
        if ($limit != false) {
            $sql .= " LIMIT ".$limit['start'].",".$limit['count'];
        }

        return User::model()->findAllBySql($sql, array(
            ':sid' => $this->content->space_id,
            ':mid' => $this->id
        ));
    }

    public function unconfirmedUsersCount()
    {
        return count($this->unconfirmedUsers());
    }

    private function unconfirmedUsersSQL()
    {
        return "
          SELECT user.* FROM user
	        JOIN space_membership
                ON user.id=space_membership.user_id
            JOIN space
                ON space.id=space_membership.space_id AND space.id=:sid
            WHERE user.id NOT IN (
                SELECT user.id FROM user
                    JOIN space_membership
                        ON user.id=space_membership.user_id
                    JOIN space
                        ON space.id=space_membership.space_id AND space.id=:sid
                    JOIN confirm_read_message_user
                        ON confirm_read_message_user.created_by=user.id AND confirm_read_message_user.confirm_read_message_id=:mid
            )
            ORDER BY user.username ";
    }
}