<?php

class ConfirmReadMessageController extends ContentContainerController
{
	public function actions()
	{
		return array(
			'stream' => array(
				'class' => 'ConfirmReadMessageStreamAction',
				'contentContainer' => $this->contentContainer
			),
		);
	}

	public function init()
	{
		/**
		 * Fallback for older versions
		 */
		if (Yii::app()->request->getParam('containerClass') == 'Space') {
			$_GET['sguid'] = Yii::app()->request->getParam('containerGuid');
		} elseif (Yii::app()->request->getParam('containerClass') == 'User') {
			$_GET['uguid'] = Yii::app()->request->getParam('containerGuid');
		}

		return parent::init();
	}

	public function actionShow()
	{
		$this->render('show', array());
	}

	/**
	 * Create a new post through via the form.
	 */
	public function actionCreate()
	{
		$this->forcePostRequest();
		$_POST = Yii::app()->input->stripClean($_POST);

		$theMessage = new ConfirmReadMessage();
		$theMessage->content->populateByForm();
		$theMessage->message = Yii::app()->request->getParam('message');

		if ($theMessage->validate()) {
			$theMessage->save();
			$this->renderJson(array('wallEntryId' => $theMessage->content->getFirstWallEntryId()));
		} else {
			$this->renderJson(array('errors' => $theMessage->getErrors()), false);
		}
	}

	public function actionConfirm()
	{
		$theMessage = $this->getMessageByParameter();
		$theMessage->confirm();

		$this->getMessageOut($theMessage);
	}

	public function actionResetConfirm()
	{
		$theMessage = $this->getMessageByParameter();
		$theMessage->resetConfirm();

		$this->getMessageOut($theMessage);
	}

	public function actionUserListConfirmed()
	{
		$message = $this->getMessageByParameter();

		$confirmations = $message->confirmations;
		$confirmationsTotal = count($confirmations);
		$confirmationsCount = $confirmationsTotal;

		$page = (int) Yii::app()->request->getParam('page', 1);
		$maxPageSize = HSetting::Get('paginationSize');
		if ($confirmationsCount > $maxPageSize) {
			$confirmations = array_slice($confirmations, ($page-1)*$maxPageSize, $maxPageSize);
		}

		$pagination = new CPagination($confirmationsTotal);
		$pagination->setPageSize($maxPageSize);

		$output = $this->renderPartial(
			'application.modules.ConfirmReadMessage.views.ConfirmReadMessage._listConfirms',
			array(
				'title' => Yii::t('ConfirmReadMessageModule.controllers_ConfirmReadMessageController', "Users that have read the message"),
				'confirmations' => $confirmations,
				'pagination' => $pagination
			)
		);

		Yii::app()->clientScript->render($output);
		echo $output;
		Yii::app()->end();
	}

	public function actionUserListUnconfirmed()
	{
		$message = $this->getMessageByParameter();

		$page = (int) Yii::app()->request->getParam('page', 1);
		$maxPageSize = HSetting::Get('paginationSize');
		$userList = $message->unconfirmedUsers(array(
			'start' => ($page-1)*$maxPageSize,
			'count' => $maxPageSize
		));
		$usersCount = $message->unconfirmedusersCount();

		$pagination = new CPagination($usersCount);
		$pagination->setPageSize(HSetting::Get('paginationSize'));

		$output = $this->renderPartial(
			'application.modules_core.user.views._listUsers',
			array(
				'title' => Yii::t('ConfirmReadMessageModule.controllers_ConfirmReadMessageController', "Users that have not read the message"),
				'users' => $userList,
				'pagination' => $pagination
			), true);

		Yii::app()->clientScript->render($output);
		echo $output;
		Yii::app()->end();
	}

	private function listUsers($aUserList, $aTitle)
	{
		$pagination = new CPagination(count($aUserList));
		$pagination->setPageSize(HSetting::Get('paginationSize'));

		$output = $this->renderPartial(
			'application.modules_core.user.views._listUsers',
			array(
				'title' => $aTitle,
				'users' => $aUserList,
				'pagination' => $pagination
			), true);

		Yii::app()->clientScript->render($output);
		echo $output;
		Yii::app()->end();
	}

	private function getMessageByParameter()
	{
		$theMessageID = (int)Yii::app()->request->getParam('messageID');
		$theMessage = ConfirmReadMessage::model()->contentContainer($this->contentContainer)->findByPk($theMessageID);

		if ($theMessage == null) {
			throw new CHttpException(401, Yii::t('ConfirmReadMessageModule.controllers_ConfirmableMessageController', 'Could not load message!'));
		}

		if (!$theMessage->content->canRead()) {
			throw new CHttpException(401, Yii::t('ConfirmReadMessageModule.controllers_ConfirmableMessageController', 'You have insufficient permissions to perform that operation!'));
		}

		return $theMessage;
	}

	private function getMessageOut($aMessage)
	{
		$output = $aMessage->getWallOut();
		Yii::app()->clientScript->render($output);

		$json = array();
		$json['output'] = $output;
		$json['wallEntryId'] = $aMessage->content->getFirstWallEntryId(); // there should be only one
		echo CJSON::encode($json);
		Yii::app()->end();
	}
}