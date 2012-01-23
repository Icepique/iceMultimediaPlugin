<?php

class ajaxAction extends IceAjaxAction
{
  protected function getObject(sfWebRequest $request)
  {
    $multimedia = new iceModelMultimedia();

    if ($request->getParameter('id'))
    {
      $multimedia = iceModelMultimediaPeer::retrieveByPK($request->getParameter('id'));
    }
    
    return $multimedia;
  }

 /**
  * @param sfWebRequest $request
  * @return sfView::NONE
  */
  public function executeReorder(sfWebRequest $request)
  {
    $items = $request->getParameter('items');
    $key   = $request->getParameter('key');
    parse_str($items, $order);

    if (is_array($order[$key]))
    foreach ($order[$key] as $position => $id)
    {
      $multimedia = iceModelMultimediaPeer::retrieveByPk($id);
      if ($multimedia && $multimedia->getPosition() != $position)
      {
        $multimedia->setIsPrimary($position == 0);
        $multimedia->setPosition($position);
        $multimedia->save();
      }
    }

    return sfView::NONE;
  }

 /**
  * @param sfWebRequest $request
  * @return sfView::NONE
  */
  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404if(!$this->object || $this->object->isNew());

    // Do the delete
    $this->object->delete();
    
    return sfView::NONE;
  }

 /**
  * @param sfWebRequest $request
  * @return sfView::NONE
  */
  public function executeUpload(sfWebRequest $request)
  {
    $model    = $request->getParameter('model');
    $model_id = $request->getParameter('model_id');

    if ($object = call_user_func(array($model.'Peer', 'retrieveByPk'), $model_id))
    {
      $files = $request->getFiles();

      if (isset($files['Filedata']))
      {
        iceModelMultimediaPeer::createMultimediaFromFile($object, $files['Filedata']);
      }
    }

    return sfView::NONE;
  }
}
