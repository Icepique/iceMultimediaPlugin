<?php

require 'plugins/iceMultimediaPlugin/lib/model/om/BaseiceModelMultimediaPeer.php';


/**
 * Skeleton subclass for performing query and update operations on the 'multimedia' table.
 *
 * @package    propel.generator.plugins.iceMultimediaPlugin.lib.model
 */
class iceModelMultimediaPeer extends BaseiceModelMultimediaPeer
{
  /**
   * @var array
   */
  static private $_valid_content_types = array(
    'image/jpg' => 'jpg',
    'image/jpeg' => 'jpg',
    'image/pjpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'application/pdf' => 'pdf',
    'application/x-pdf' => 'pdf',
    'application/octet-stream' => 'pdf'
  );

  /**
   * @static
   * @return array
   */
  static public function getValidContentTypes()
  {
    return self::$_valid_content_types;
  }

  /**
   * @static
   * 
   * @param  BaseObject $model
   * @param  integer    $limit
   * @param  string     $type
   * @param  null|bool  $primary
   *
   * @return null|PropelObjectCollection|iceModelMultimedia
   */
  public static function retrieveByModel(BaseObject $model, $limit = 0, $type = null, $primary = null)
  {
    if (!method_exists($model, 'getId'))
    {
      return null;
    }

    /**
     * @var iceModelMultimediaQuery $q
     */
    $q = iceModelMultimediaQuery::create()
       ->filterByModel(str_replace('Sphinx', '', get_class($model)))
       ->filterByModelId($model->getId())
       ->orderByPosition('ASC')->orderByCreatedAt('ASC')
       ->limit($limit);

    if ($type !== null)
    {
      $q->filterByType($type);
    }
    if ($primary !== null)
    {
      $q->filterByIsPrimary($primary);

      if ($primary === true)
      {
        return $q->findOne();
      }
    }

    return $q->find();
  }

  /**
   * @static
   *
   * @param  BaseObject  $model
   * @param  string  $type
   *
   * @return int
   */
  public static function countByModel(BaseObject $model, $type = null)
  {
    $c = new Criteria();
    $c->add(self::MODEL, str_replace('Sphinx', '', get_class($model)));
    $c->add(self::MODEL_ID, $model->getId());

    if ($type !== null)
    {
      $c->add(self::TYPE, $type);
    }

    return self::doCount($c);
  }

  /**
   * Create a Multimedia object for a certain model given a url
   *
   * @param  BaseObject $model
   * @param  string  $url
   * @param  array   $options
   *
   * @return iceModelMultimedia
   */
  public static function createMultimediaFromUrl(BaseObject $model, $url, $options = array())
  {
    try
    {
      $b = IceWebBrowser::getBrowser('utf-8', 30, $options);
      $b->get(trim($url));
    }
    catch (Exception $e)
    {
      return false;
    }

    if (!$b->responseIsError() && in_array($b->getResponseHeader('Content-Type'), array_keys(self::$_valid_content_types)))
    {
      $file = tempnam(sfConfig::get('sf_cache_dir'), 'product_multimedia_');
      file_put_contents($file, $b->getResponseText());

      // Set the extension option
      $options['extension'] = self::$_valid_content_types[$b->getResponseHeader('Content-Type')];

      $multimedia = self::createMultimediaFromFile($model, $file, $options);
      if ($multimedia)
      {
        $multimedia->setSource($url);
        $multimedia->save();
      }

      // Delete the temporary file
      @unlink($file);

      return $multimedia;
    }

    return false;
  }

  /**
   * Createa a multimedia record from a physical file
   *
   * @param  BaseObject  $model
   * @param  string  $file The path to the file on the filesystem
   * @param  array   $options
   *
   * @return bool|iceModelMultimedia
   */
  public static function createMultimediaFromFile(BaseObject $model, $file, $options = array())
  {
    $extension = isset($options['extension']) ? $options['extension'] : null;

    if ($file instanceof sfValidatedFile)
    {
      /** @var sfValidatedFile $file */
      $filename = $file->getOriginalName();
      $extension = self::$_valid_content_types[$file->getType()];
      $file = $file->getTempName();
    }
    else if (is_array($file))
    {
      $filename = $file['name'];
      $extension = self::$_valid_content_types[$file['type']];
      $file = $file['tmp_name'];
    }
    else
    {
      $filename = basename($file);
    }

    if (!empty($extension))
    {
      $extension = @strtolower(end(explode('.', $filename)));
    }

    // Stop right here if the file is not readable or empty
    if (!is_readable($file) || filesize($file) == 0)
    {
      return false;
    }

    $md5 = md5_file($file);

    $c = new Criteria();
    $c->add(self::MODEL, str_replace('Sphinx', '', get_class($model)));
    $c->add(self::MODEL_ID, $model->getId());
    $c->add(self::MD5, $md5);

    // Checking for the md5 hash of the file so that we can avoid duplicates
    if (0 < self::doCount($c))
    {
      return false;
    }

    $extension = (is_null($extension)) ? @end(explode(".", $file)) : $extension;
    switch($extension)
    {
      case 'pdf':
        $multimedia = new iceModelMultimedia('pdf');
        break;
      case 'jpg':
      case 'png':
      case 'gif':
      default:

        $image = new sfImage($file);
        if ($image && (false === $image->getAdapter()->hasHolder()))
        {
          return false;
        }

        $multimedia = new iceModelMultimedia('image');
        if (is_object($model) && !$model->isNew())
        {
          $c = new Criteria;
          $c->setDistinct();
          $c->add(self::MODEL, str_replace('Sphinx', '', get_class($model)));
          $c->add(self::MODEL_ID, $model->getId());
          $c->add(self::TYPE, 'image');
          $c->addDescendingOrderByColumn(self::POSITION);

          if (self::doCount($c) == 0)
          {
            $multimedia->setIsPrimary(true);
            $multimedia->setPosition(0);
          }
          else if ($m = self::doSelectOne($c))
          {
            $multimedia->setPosition((int) $m->getPosition() + 1);
          }
          else
          {
            $multimedia->setPosition(0);
          }
        }
        else
        {
          return false;
        }
        break;
    }

    $multimedia->setModel($model);
    $multimedia->setMd5($md5);
    $multimedia->setName($filename);
    if (filemtime($file))
    {
      $multimedia->setCreatedAt(filemtime($file));
    }
    
    $multimedia->createDirectory();
    if (copy($file, $multimedia->getAbsolutePath('original')))
    {
      try
      {
        $multimedia->save();
        
        // Delegate the creation of the thumbnails to the model class
        if (method_exists($model, 'createMultimediaThumbs'))
        {
          $model->createMultimediaThumbs($multimedia, $options);
        }

        return $multimedia;
      }
      catch (PropelException $e) { ; }
    }

    return false;
  }

  /**
   * Calculate new image dimensions to new constraints
   * 
   * @param integer $w
   * @param integer $h
   * @param integer $mw
   * @param integer $mh
   *
   * @return array
   */
  static function scaleImageSize($w, $h, $mw, $mh)
  {
    foreach(array('w','h') as $v)
    {
      $m = "m{$v}";

      if(${$v} > ${$m} && ${$m}) { $o = ($v == 'w') ? 'h' : 'w';
      $r = ${$m} / ${$v}; ${$v} = ${$m}; ${$o} = ceil(${$o} * $r); }
    }

    // Return the results
    return array(0 => $w, 1 => $h, 'width' => $w, 'height' => $h);
  }

  public static function getImageColors($file, $limit = 12)
  {
    if (!is_readable($file))
    {
      return array();
    }

    $colors = array();

    if (class_exists('Imagick'))
    {
      try
      {
        $image = new Imagick($file);
        $background = $image->getImageBackgroundColor()->getColor();

        $image->medianFilterImage(5);

        $width = $image->getImageWidth();
        $height = $image->getImageHeight();
        if ($width > $height)
        {
          $x = ($width - ($width/1.5)) / 2;
          $y = ($height - ($height/2)) / 2;

          $width = $width / 1.5;
          $height = $height / 2;
        }
        else
        {
          $x = ($width - ($width/2)) / 2;
          $y = ($height - ($height/1.5)) / 2;

          $width = $width / 2;
          $height = $height / 1.5;
        }

        $image->cropImage($width, $height, $x, $y);

        $colormap = new Imagick(dirname(__FILE__).'/../../web/images/colortable.gif');
        $image->mapImage($colormap, true);

        $pixels = $image->getImageHistogram();
        foreach ($pixels as $pixel)
        {
          /** @var ImagickPixel $pixel */
          $color = $pixel->getColor();
          if ($color != $background)
          {
            $colors[$pixel->getColorCount()] = sprintf('#%02X%02X%02X', $color['r'], $color['g'], $color['b']);
          }
        }

        $colormap->destroy();
        $image->destroy();
      }
      catch(ImagickException $e)
      {
        ;
      }
    }

    krsort($colors, SORT_NUMERIC);
    return array_slice($colors, 0, $limit);
  }

  /**
   * Get the orientation of an image by given filename (absolute path)
   *
   * @param  string  $file  The absolute path to the file
   * @return enum('landspace','portrait')
   */
  public static function getImageOrientation($file)
  {
    list($width, $height) = @getimagesize($file);
    return ($width > $height) ? 'landscape' : 'portrait';
  }

  /**
   * Get the proportion of an image by given filename (absolute path)
   *
   * @param  string  $file  The absolute path to the file
   * @return float
   */
  public static function getImageProportion($file)
  {
    list($width, $height) = @getimagesize($file);
    return ($height > 0) ? $width / $height : 1;
  }
}

sfPropelBehavior::add(
  'iceModelMultimedia',
  array(
    'PropelActAsSluggableBehavior' => array(
      'columns' => array(
        'from' => iceModelMultimediaPeer::NAME,
        'to'   => iceModelMultimediaPeer::SLUG
      ),
      'separator' => '-',
      'permanent' => false,
      'chars' => 128
    )
  )
);
