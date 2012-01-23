<?php

/**
 * @var sfApplicationConfiguration $configuration
 */
$configuration = sfProjectConfiguration::getActive();
$configuration->loadHelpers(array('Asset', 'Tag'));

/**
 * @see image_tag()
 *
 * @param  string  $source
 * @param  array   $options
 *
 * @return string
 */
function ice_image_tag($source, $options = array())
{
  if (isset($options['max_width']) || isset($options['max_height']))
  {
    if (list($w, $h) = @array($options['width'], $options['height']))
    {
      $mw = isset($options['max_width']) ? $options['max_width'] : null;
      $mh = isset($options['max_height']) ? $options['max_height'] : null;

      foreach(array('w','h') as $v)
      {
        $m = "m{$v}";

        if (${$v} > ${$m} && ${$m})
        {
          $o = ($v == 'w') ? 'h' : 'w';
          $r = ${$m} / ${$v};

          ${$v} = ${$m};
          ${$o} = ceil(${$o} * $r);
        }
      }
    }

    $options['width']  = $w;
    $options['height'] = $h;

    // Unsetting all options which should not make it to the html <img/> tag
    unset($options['max_width'], $options['max_height']);
  }

  // remove the empty values
  $options = IceFunctions::array_filter_recursive($options);

  return image_tag($source, $options);
}

function ice_image_tag_text($text, $size, $options = array())
{
  $time = isset($options['time']) ? (int) $options['time'] : null;
  $encrypted = IceStatic::crypt(json_encode(array($text, $time)), 'rYja9LeipWgJ8H');

  $url = sprintf(
    'http://%s/text/%s/%s.png?',
    sfConfig::get('app_multimedia_domain'),
    $size, $encrypted
  );

  if (!empty($time))
  {
    $url .= $time;
  }

  if (!empty($options['settings']))
  {
    $settings = explode(';', $options['settings']);
    foreach ($settings as $setting)
    {
      preg_match('/^(\w)\w+\-(\w)\w+\:\s?(.*)$/iu', trim($setting), $m);

      if (count($m) == 4)
      {
        $url .= $m[1] . $m[2] .'='. urlencode($m[3]) .'&';
      }
    }

    unset($options['settings']);
  }

  return ice_image_tag(trim($url, '?& '), $options);
}

/**
 * Returns an HTML image tag of the multimedia object
 *
 * @param  iceModelMultimedia  $multimedia  The multimedia object
 * @param  string  $size     ['thumbnail', 'original', 'WIDTH x HEIGHT']
 * @param  array   $options  Options for the <img> HTML element
 *
 * @see image_tag()
 *
 * @return string
 */
function ice_image_tag_multimedia($multimedia, $size, $options = array())
{
  if (!$multimedia instanceof iceModelMultimedia)
  {
    return null;
  }

  // Make sure there are no spaces in $size
  $size = preg_replace('/\s+/', '', $size);

  $width = $height = null;
  if (isset($options['width']) && isset($options['height']))
  {
    $width  = $options['width'];
    $height = $options['height'];
  }
  else if (preg_match('/(\d+)x(\d+)/iu', $size, $m))
  {
    $width  = $m[1];
    $height = $m[2];
  }
  else if ($multimedia->fileExists($size) && ($image_info = $multimedia->getImageInfo($size)))
  {
    $width  = $image_info['width'];
    $height = $image_info['height'];
  }

  $options = array_merge(
    array('alt_title' => '', 'width' => $width, 'height' => $height),
    $options
  );

  // return the image_tag
  return ice_image_tag(ice_url_for_multimedia($multimedia, $size, $options), $options);
}

/**
 * @param  iceModelMultimedia $multimedia
 * @param  string  $size
 * @param  array   $options
 *
 * @return null|string
 */
function ice_url_for_multimedia($multimedia, $size, $options = array())
{
  if (!$multimedia instanceof iceModelMultimedia)
  {
    return null;
  }

  $url = sprintf(
    'http://%s/%s/%s/%s-%d.%s?%d',
    sfConfig::get('app_multimedia_domain'),
    $multimedia->getType(), $size,
    (!empty($options['slug'])) ? $options['slug'] : strtolower($multimedia->getModel()),
    $multimedia->getId(), 'jpg', $multimedia->getCreatedAt('U')
  );

  return $url;
}
