<?php

class iceMultimediaPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    sfPropelBehavior::registerHooks('IceMultimediaBehavior', array(
      ':save:post' => array('IceMultimediaBehavior', 'postSave'),
      ':delete:pre' => array('IceMultimediaBehavior', 'preDelete')
    ));

    sfPropelBehavior::registerMethods('IceMultimediaBehavior', array(
      array('IceMultimediaBehavior', 'getPrimaryImage'),
      array('IceMultimediaBehavior', 'setPrimaryImage'),
      array('IceMultimediaBehavior', 'addMultimedia'),
      array('IceMultimediaBehavior', 'getMultimedia'),
      array('IceMultimediaBehavior', 'getMultimediaCount')
    ));

    return parent::initialize();
  }
}
