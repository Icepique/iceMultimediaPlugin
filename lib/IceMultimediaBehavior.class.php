<?php

class IceMultimediaBehavior
{
  protected static
    $_multimedia = array(),
    $_counts = array();

  public function postSave(BaseObject $object)
  {
    return true;
  }

  /**
   * Get the primary image
   *
   * @param  BaseObject  $object
   * @param  string  $mode
   *
   * @return iceModelMultimedia
   */
  public function getPrimaryImage(BaseObject $object, $mode = Propel::CONNECTION_READ)
  {
    $multimedia = array_merge(self::$_multimedia, $object->_multimedia);

    $key = md5(serialize(array(get_class($object), $object->getId(), 1, 'image', true)));
    if (!array_key_exists($key, $multimedia))
    {
      // Trying to avoid a MySQL query here
      if ($this->getMultimediaCount($object, 'image') > 0)
      {
        $multimedia[$key] = $this->getMultimedia($object, 1, 'image', true, $mode);
      }
      else
      {
        $multimedia[$key] = null;
      }
    }

    return self::$_multimedia[$key] = $multimedia[$key];
  }

  /**
   * A proxy method to iceModelMultimediaPeer::createMultimediaFromFile()
   *
   * @see iceModelMultimediaPeer::createMultimediaFromFile()
   *
   * @param  BaseObject  $object
   * @param  string|sfValidatedFile  $file
   * @param  array  $options
   *
   * @return iceModelMultimedia
   */
  public function setPrimaryImage(BaseObject $object, $file, $options = array())
  {
    // First we need to delete the old multimedia records
    if ($_multimedia = $this->getMultimedia($object))
    foreach ($_multimedia as $m)
    {
      $m->delete();
    }

    $key = md5(serialize(array(get_class($object), $object->getId(), 1, 'image', true)));
    self::$_multimedia[$key] = iceModelMultimediaPeer::createMultimediaFromFile($object, $file, $options);

    return self::$_multimedia[$key];
  }

  /**
   * Proxy method for MultimediaPeer::retrieveByModel()
   *
   * @see iceModelMultimediaPeer::createMultimediaFromFile()
   * @see iceModelMultimediaPeer::createMultimediaFromUrl()
   *
   * @param  BaseObject  $object
   * @param  string|sfValidatedFile  $file
   * @param  array  $options
   *
   * @return iceModelMultimedia
   */
  public function addMultimedia(BaseObject $object, $file, $options = array())
  {
    if (is_string($file) && IceWebBrowser::isUrl($file))
    {
      $_multimedia = iceModelMultimediaPeer::createMultimediaFromUrl($object, $file, $options);
    }
    else
    {
      $_multimedia = iceModelMultimediaPeer::createMultimediaFromFile($object, $file, $options);
    }

    /**
     * Clear the static variables
     *
     * @todo  Maybe here we can just increment the $count and add to the $_multimedia array?
     */
    $this->clearStaticCache();

    return $_multimedia;
  }

  /**
   * Proxy method for MultimediaPeer::retrieveByModel()
   *
   * @see iceModelMultimediaPeer::retrieveByModel()
   */
  public function getMultimedia(BaseObject $object, $limit = 0, $type = null, $primary = null, $mode = Propel::CONNECTION_READ)
  {
    $multimedia = array_merge(self::$_multimedia, $object->_multimedia);

    $key = md5(serialize(array(get_class($object), $object->getId(), $limit, $type, $primary)));
    if (!array_key_exists($key, $multimedia))
    {
      $multimedia[$key] = null;

      if ($mode == Propel::CONNECTION_READ && ($element = $object->getEblobElement('multimedia')))
      {
        $collection = new PropelObjectCollection(array());
        $collection->setModel('iceModelMultimedia');
        
        $_collection = new PropelObjectCollection(array());
        $_collection->setModel('iceModelMultimedia');
        $_collection->fromXML($element->asXml());

        foreach ($_collection as $k => $m)
        {
          $true = true;

          if ($type && $m->getType() != $type)
          {
            $true = false;
          }
          else if ($primary !== null && (bool) $m->getIsPrimary() !== $primary)
          {
            $true = false;
          }

          if ($true)
          {
            $collection->append($m);
          }

          if ($limit > 0 && count($collection) >= $limit)
          {
            break;
          }
        }

        $multimedia[$key] = ($primary === true || $limit == 1) ? $collection->getFirst() : $collection;
      }

      /**
       * Failback to quering the database before all Model classes implement the eblob behavior
       */
      if (count($multimedia[$key]) == 0)
      {
        $multimedia[$key] = iceModelMultimediaPeer::retrieveByModel($object, $limit, $type, $primary);
      }
    }

    return self::$_multimedia[$key] = $multimedia[$key];
  }

  /**
   * Proxy method for iceModelMultimediaPeer::countByModel()
   *
   * @see iceModelMultimediaPeer::countByModel()
   */
  public function getMultimediaCount(BaseObject $object, $type = null)
  {
    $counts = array_merge(self::$_counts, $object->_counts);

    $key = md5(serialize(array(get_class($object), $object->getId(), $type)));
    if (!array_key_exists($key, $counts))
    {
      $multimedia = $this->getMultimedia($object, 0, $type, null, Propel::CONNECTION_READ);
      $counts[$key] = ($multimedia instanceof PropelObjectCollection) ? $multimedia->count() : 0;
    }

    return self::$_counts[$key] = $counts[$key];
  }

 /**
  * @param  BaseObject  $object
  */
  public function preDelete(BaseObject $object)
  {
    if ($_multimedia = $this->getMultimedia($object))
    foreach ($_multimedia as $m)
    {
      $m->delete();
    }
  }

  protected function clearStaticCache()
  {
    // Reset the local multimedia and counts cache
    self::$_multimedia = array();
    self::$_counts = array();
  }
}
