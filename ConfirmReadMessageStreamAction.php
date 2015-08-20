<?php

/**
 * ConfirmReadMessageStreamAction.php
 * Created by: michaelseeberger
 * Date: 18.08.15
 * Time: 21:51
 */
class ConfirmReadMessageStreamAction extends ContentContainerStreamAction
{
    public function setupFilters()
    {
        $this->criteria->condition .= " AND object_model='ConfirmReadMessage'";

        /*if (in_array('ConfirmReadMessage_notAnswered', $this->filters) || in_array('ConfirmReadMessage_mine', $this->filters)) {

            $this->criteria->join .= " LEFT JOIN confirm_read_message ON content.object_id=confirm_read_message.id AND content.object_model = 'ConfirmReadMessage'";

            if (in_array('ConfirmReadMessage_notAnswered', $this->filters)) {
                $this->criteria->join .= " LEFT JOIN confirm_read_message_user ON confirm_read_message.id=confirm_read_message_user.confirm_read_message_id AND confirm_read_message_answer_user.created_by = '" . Yii::app()->user->id . "'";
                $this->criteria->condition .= " AND confirm_read_message_user.id is null";
            }
        }*/
    }
}
