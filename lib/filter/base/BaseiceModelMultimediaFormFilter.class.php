<?php

/**
 * iceModelMultimedia filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseiceModelMultimediaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'model'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'model_id'   => new sfWidgetFormFilterInput(),
      'type'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'md5'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'source'     => new sfWidgetFormFilterInput(),
      'is_primary' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'position'   => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'model'      => new sfValidatorPass(array('required' => false)),
      'model_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'type'       => new sfValidatorPass(array('required' => false)),
      'name'       => new sfValidatorPass(array('required' => false)),
      'slug'       => new sfValidatorPass(array('required' => false)),
      'md5'        => new sfValidatorPass(array('required' => false)),
      'source'     => new sfValidatorPass(array('required' => false)),
      'is_primary' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'position'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('ice_model_multimedia_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'iceModelMultimedia';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'model'      => 'Text',
      'model_id'   => 'Number',
      'type'       => 'Text',
      'name'       => 'Text',
      'slug'       => 'Text',
      'md5'        => 'Text',
      'source'     => 'Text',
      'is_primary' => 'Boolean',
      'position'   => 'Number',
      'created_at' => 'Date',
    );
  }
}
