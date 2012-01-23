<?php

require 'plugins/iceMultimediaPlugin/lib/model/om/BaseiceModelMultimediaQuery.php';


/**
 * Skeleton subclass for performing query and update operations on the 'multimedia' table.
 *
 * @package    propel.generator.plugins.iceMultimediaPlugin.lib.model
 */
class iceModelMultimediaQuery extends BaseiceModelMultimediaQuery
{
  /**
   * @param  BaseObject  $model
   * @param  string  $comparison
   *
   * @return iceModelMultimediaQuery
   */
  public function filterByModel($model = null, $comparison = null)
  {
    if ($model instanceof BaseObject && method_exists($model, 'getId'))
    {
      return $this->filterByModel(get_class($model), $comparison)->filterByModelId($model->getId(), $comparison);
    }
    else
    {
      return parent::filterByModel($model, $comparison);
    }
  }
}
