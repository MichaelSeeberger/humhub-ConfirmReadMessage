<?php

class ConfirmReadMessageModule extends HWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'application.modules.ConfirmReadMessage.models.*',
			'application.modules.ConfirmReadMessage.behaviors.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	public function behaviors()
	{
		return array(
			'SpaceModuleBehavior' => array(
				'class' => 'application.modules_core.space.behaviors.SpaceModuleBehavior',
			),
		);
	}

	/**
	 * Delete all content when module is globally disabled.
	 *
	 * @return bool
	 * @throws CDbException
	 */
	public function disable()
	{
		if (!parent::disable()) {
			return false;
		}

		foreach (Content::model()->findAllByAttributes(array('object_model' => 'ConfirmReadMessage')) as $theContent) {
			$theContent->delete();
		}

		return true;
	}

	/**
	 * Delete all content created in the space when disabled.
	 *
	 * @param Space $space
	 * @throws CDbException
	 */
	public function disableSpaceModule(Space $space)
	{
		foreach (Content::model()->findAllByAttributes(array('space_id' => $space->id, 'object_model' => 'ConfirmReadMessage')) as $content) {
			$content->delete();
		}
	}

	/**
	 * When a user is deleted, delete all of her posts.
	 *
	 * @param $theEvent
	 * @return bool
	 */
	public static function onUserDelete($theEvent)
	{
		foreach (ConfirmReadMessageUser::model()->findAllByAttributes(array('created_by' => $theEvent->sender->id)) as $aConfirmation) {
			$aConfirmation->delete();
		}

		return true;
	}

	/**
	 * When building the Space Navigation, check if this module is enabled and add a menu item if it is.
	 *
	 * @param type $theEvent
	 */
	public static function onSpaceMenuInit($theEvent)
	{
		$space = Yii::app()->getController()->getSpace();

		if ($space->isModuleEnabled('ConfirmReadMessages')) {
			$theEvent->sender->addItem(array(
				'label' => Yii::t('ConfirmReadMessageModule.base', 'Confirmation'),
				'group' => 'modules',
				'url' => $space->createUrl('//ConfirmReadMessages/ConfirmReadMessage/show'),
				'icon' => '<i class="glyphicon glyphicon-ok" style="margin-right: 4px;"></i>',
				'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'ConfirmReadMessages'),
			));
		}
	}
}
