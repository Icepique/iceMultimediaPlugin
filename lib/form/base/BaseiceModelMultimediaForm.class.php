<?php

/**
 * iceModelMultimedia form base class.
 *
 * @method iceModelMultimedia getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseiceModelMultimediaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'model'      => new sfWidgetFormInputText(),
      'model_id'   => new sfWidgetFormInputText(),
      'type'       => new sfWidgetFormInputText(),
      'name'       => new sfWidgetFormInputText(),
      'slug'       => new sfWidgetFormInputText(),
      'md5'        => new sfWidgetFormInputText(),
      'source'     => new sfWidgetFormInputText(),
      'is_primary' => new sfWidgetFormInputCheckbox(),
      'position'   => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'model'      => new sfValidatorString(array('max_length' => 64)),
      'model_id'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'type'       => new sfValidatorString(),
      'name'       => new sfValidatorString(array('max_length' => 128)),
      'slug'       => new sfValidatorString(array('max_length' => 128)),
      'md5'        => new sfValidatorString(array('max_length' => 32)),
      'source'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_primary' => new sfValidatorBoolean(array('required' => false)),
      'position'   => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'iceModelMultimedia', 'column' => array('slug'))),
        new sfValidatorPropelUnique(array('model' => 'iceModelMultimedia', 'column' => array('model', 'model_id', 'md5'))),
      ))
    );

    $this->widgetSchema->setNameFormat('ice_model_multimedia[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'iceModelMultimedia';
  }


}
