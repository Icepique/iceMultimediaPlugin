<?php

require 'plugins/iceMultimediaPlugin/lib/model/om/BaseiceModelMultimedia.php';

/**
 * Skeleton subclass for representing a row from the 'multimedia' table.
 *
 * @package    propel.generator.plugins.iceMultimediaPlugin.lib.model
 */
class iceModelMultimedia extends BaseiceModelMultimedia
{
  private static $_file_exists = array();

  /**
   * @param  string  $type
   */
  public function __construct($type = 'image')
  {
    parent::__construct();
    $this->setType($type);
  }

  /**
   * @param PropelPDO $con
   */
  public function save(PropelPDO $con = null)
  {
    if ($this->isNew())
    {
      $this->setName($this->getName());
      $this->createDirectory();
    }

    parent::save($con);
  }
  
  public function postSave(PropelPDO $con = null) 
  {
    /**
     * Update the Eblob cache
     */
    if ($model = $this->getModelObject())
    {
      /** @var $m iceModelMultimedia */
      $m = iceModelMultimediaPeer::retrieveByModel($model);

      $model->setEblobElement('multimedia', $m->toXML());
      $model->save();
    }

    parent::postSave($con);
  }

  /**
   * @param  string  $which
   * @return string
   */
  public function getFileSize($which = 'original')
  {
    $unit = array(' Bytes', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB');
    $size = @filesize($this->getAbsolutePath($which));
    $size = $size ? round($size/pow(1024, ($i = (int) floor(log($size, 1024)))), 2) . $unit[$i] : '0 Bytes';

    return $size;
  }

  /**
   * @param  string  $which
   * @return array
   */
  public function getImageInfo($which = 'original')
  {
    if ($this->getType() != 'image')
    {
      return false;
    }

    list($width, $height, $type) = @getimagesize($this->getAbsolutePath($which));

    return array(
      'width'  => $width,
      'height' => $height,
      'size'   => $this->getFileSize(),
      'type'   => $type
    );
  }

  /**
   * @param  string  $which
   * @return int
   */
  public function getImageHeight($which = 'original')
  {
    if ($this->getType() != 'image')
    {
      return false;
    }

    list(,$height,) = @getimagesize($this->getAbsolutePath($which));

    return (int) $height;
  }

  /**
   * @param  string  $which
   * @return int
   */
  public function getImageWidth($which = 'original')
  {
    if ($this->getType() != 'image')
    {
      return false;
    }

    list($width,,) = @getimagesize($this->getAbsolutePath($which));

    return (int) $width;
  }

  /**
   * @return string
   */
  public function getName()
  {
    if (!$name = parent::getName())
    {
      $name = hash('md5', uniqid($this->getModel().'-'.$this->getModelId()));
      $this->setName($name);
    }

    return $name;
  }

  /**
   * @return object
   */
  public function getModelObject()
  {
    $object = null;

    $class = $this->getModel().'Peer';
    if (method_exists($class, 'retrieveByPk'))
    {
      $object = call_user_func(array($class, 'retrieveByPk'), $this->getModelId());
    }

    return $object;
  }

  /**
   * @param  string   $model
   * @param  integer  $id
   */
  public function setModel($model, $id = null)
  {
    if (is_object($model))
    {
      /** @var $model iceBaseObject */
      parent::setModel(get_class($model));
      $this->setModelId($model->getId());
    }
    else
    {
      parent::setModel($model);
      $this->setModelId($id);
    }
  }

  /**
   * Determines if the given $which size exists as file on the server
   *
   * NOTE: This is a slow method because it depends on the hard drive performace!
   *
   * @param  string  $which
   * @return boolean
   */
  public function fileExists($which)
  {
    $file = $this->getAbsolutePath($which);

    if (!isset(self::$_file_exists[$file]))
    {
      self::$_file_exists[$file] = is_file($file);
    }

    return self::$_file_exists[$file];
  }

  /**
   * @param  string  $which
   * @return string
   */
  public function getAbsolutePath($which = 'original')
  {
    $dir = sfConfig::get('sf_upload_dir') .'/'. $this->getModel();
    $dir .= '/'. ((!$this->getCreatedAt()) ? strftime('%Y/%m/%d', time()) : $this->getCreatedAt('Y/m/d'));

    return implode('.', array($dir.'/'.$this->getMd5(), $which, $this->getFileExtension()));
  }

  /**
   * @param  string  $which
   * @return string
   */
  public function getRelativePath($which = 'original')
  {
    $dir = '/uploads/'. $this->getModel();
    $dir .= '/'. (($this->isNew()) ? strftime('%Y/%m/%d', time()) : $this->getCreatedAt('Y/m/d'));

    return implode('.', array($dir.'/'.$this->getMd5(), $which, $this->getFileExtension() .'?'. $this->getCreatedAt('U')));
  }

  /**
   * Make a thumbnail for the Multimedia object with the special name 'thumbnail'
   *
   * @param  integer  $width
   * @param  integer  $height
   * @param  string   $method  Can be ('fit', 'scale', 'inflate','deflate', 'left' ,'right', 'top', 'bottom', 'center')
   * @param  boolean  $watermark
   *
   * @return Multimedia
   */
  public function makeThumb($width, $height, $method = 'fit', $watermark = false)
  {
    return $this->makeCustomThumb($width, $height, 'thumbnail', $method, $watermark);
  }

  /**
   *
   * @param  integer  $width
   * @param  integer  $height
   * @param  string   $which
   * @param  string   $method  Can be ('fit', 'scale', 'inflate','deflate', 'left' ,'right', 'top', 'bottom', 'center')
   * @param  boolean  $watermark
   *
   * @return Multimedia|false
   */
  public function makeCustomThumb($width, $height, $which, $method = 'fit', $watermark = true)
  {
    if ($this->getType() != 'image')
    {
      throw new LogicException('Only multimedia of type "image" can have thumbnails');
    }

    $original = $this->getAbsolutePath('original');
    if (is_readable($original))
    {
      try
      {
        $image = new sfImage($original);
        $image->setQuality(90);
        $image->thumbnail($width, $height, $method);

        /**
         * Add optional watermark to the image
         */
        if ($watermark === true && is_file(sfConfig::get('sf_web_dir').'/images/watermark.png') && $image->getWidth() > 200)
        {
          $watermark = new sfImage(sfConfig::get('sf_web_dir').'/images/watermark.png');
          $watermark->opacity(50);
          $image->overlay($watermark, 'bottom-right');
        }

        // Save the thumb
        $image->saveAs($this->getAbsolutePath($which));

        return true;
      }
      catch (Exception $e)
      {
        return false;
      }
    }

    return false;
  }

  /**
   * @param  string  $which
   * @param  int     $degrees
   * @param  bool    $queue
   *
   * @return bool
   */
  public function rotate($which = 'original', $degrees = 90, $queue = false)
  {
    if (false && $queue == true)
    {
      // @todo: add this task to the queue
    }

    // We need a valid file name to rotate
    if ($src = $this->getAbsolutePath($which))
    {
      // Do the actual rotate
      $image = new sfImage($src);
      $image->rotate($degrees);
      $image->saveAs($this->getAbsolutePath($which));

      // Now recreate the thumbnails
      if ($which = 'original' && $object = $this->getModelObject())
      {
        $object->createMultimediaThumbs($this);
      }
    }

    return true;
  }

  /**
   * @param  string  $url
   * @return bool
   */
  public function downloadOriginalFromUrl($url)
  {
    try
    {
      $b = IceWebBrowser::getBrowser();
      $b->get($url);
    }
    catch (Exception $e)
    {
      return false;
    }

    if (!$b->responseIsError())
    {
      @file_put_contents($this->getAbsolutePath('original'), $b->getResponseText());
      return true;
    }

    return false;
  }

  /**
   * @return string
   */
  public function getFileExtension()
  {
    switch ($this->getType())
    {
      case 'pdf':
        $extension = 'pdf';
        break;
      case 'video':
        $extension = 'swf';
        break;
      case 'image':
      default:
        $extension = 'jpg';
        break;
    }

    return $extension;
  }

  /**
   * @return bool
   */
  public function createDirectory()
  {
    $dir = dirname($this->getAbsolutePath());
    if (is_dir($dir) && is_writable($dir))
    {
      return true;
    }

    umask(022);
    return @mkdir($dir, 0755, true);
  }

  /**
   * @param PropelPDO $con
   */
  public function delete(PropelPDO $con = null)
  {
    $original = $this->getAbsolutePath('original');

    $files = sfFinder::type('file')
           ->name(str_replace('original', '*', basename($original)))
           ->in(dirname($original));

    if ($files)
    foreach ($files as $file)
    {
      @unlink($file);
    }

    $model = $this->getModelObject();
    
    parent::delete($con);

    /**
     * Update the Eblob cache
     */
    if ($model)
    {
      $m = iceModelMultimediaPeer::retrieveByModel($model);

      $model->setEblobElement('multimedia', $m->toXML());
      $model->save();
    }
  }
}
