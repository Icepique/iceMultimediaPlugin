<?php

$_time_start = microtime(true);

require '/www/libs/symfony-1.4.x/lib/yaml/sfYaml.php';

require dirname(__FILE__) .'/../../iceLibsPlugin/lib/IceStatic.class.php';
require dirname(__FILE__) .'/../../iceLibsPlugin/lib/IceHandlerSocket.class.php';
require dirname(__FILE__) .'/../../iceLibsPlugin/lib/IceStats.class.php';
require dirname(__FILE__) .'/../../iceLibsPlugin/lib/IceFunctions.class.php';

$app = $_SERVER['SF_APP'];
$env = $_SERVER['SF_ENV'];

@list(, $type, $size, $filename) = explode('/', $_SERVER['REQUEST_URI']);
if (in_array($type, array('image', 'video', 'pdf')))
{
  $databases = sfYaml::load($_SERVER['SF_ROOT_DIR'] .'/config/databases.yml');
  $databases['prod'] = $databases['all'];

  preg_match('/-(\d+)\.(jpg|swf|pdf)/i', $filename, $m);
  if (isset($m[1]) && ctype_digit($m[1]))
  {
    $hs = new IceHandlerSocket('ice-mysql-slave');
    $hs->openIndex(1, $databases[$env]['propel']['param']['dbname'], 'multimedia', HandlerSocket::PRIMARY, 'id,type,model,md5,created_at');

    $rows = $hs->executeSingle(1, '=', array($m[1]), 1, 0);
    foreach ($rows as $row)
    {
      if ($row[1] == $type) break;
      else $row = array();
    }

    if ($row)
    {
      $path  = '/uploads/'. $row[2] .'/'. date_format(new DateTime($row[4]), 'Y/m/d');

      $extension = array_shift(explode('?', end(explode('.', $filename))));
      $path = implode('.', array($path .'/'. $row[3], $size, $extension));

      if (is_readable($_SERVER['SF_ROOT_DIR'] . '/web' . $path))
      {
        // Send Content-Type and the X-SendFile header
        header('HTTP/1.0 200 OK');
        header('Content-Type: image/jpeg');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        header('X-Accel-Redirect: ' . $path);
      }
      else
      {
        $path  = '/images/multimedia/'. $row[2] .'/'. $size .'.png';

        // Send Content-Type and the X-SendFile header
        header('HTTP/1.0 200 OK');
        header('Content-Type: image/png');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
        header('X-Accel-Redirect: ' . $path);
      }

      // Time the request
      IceStats::timing(IceFunctions::gethostname().'.plugins.multimedia.image',  microtime(true) - $_time_start);

      exit;
    }
  }
}
else if ($type == 'text' && preg_match('/(.*)\.png\??(\d+)?\&?(.*)/i', $filename, $m))
{
  // If we have time specified, that means we need to time verify the request
  list($text, $time) = json_decode(IceStatic::decrypt($m[1], 'rYja9LeipWgJ8H'));

  if (@$m[2] == $time && ($time === null || $time > time() - 3600))
  {
    list($w, $h) = explode('x', $size);

    // Populate the $_GET array
    parse_str($m[3], $_GET);

    $fs = !empty($_GET['fs']) ? (int) $_GET['fs'] : 10;         // font-size
    $bc = !empty($_GET['bc']) ? hexdec($_GET['bc']) : 0xffffff; // background-color
    $fc = !empty($_GET['fc']) ? hexdec($_GET['fc']) : 0x000000; // font-color
    $pt = !empty($_GET['pt']) ? (int) $_GET['pt'] : 10;         // padding-top
    $pl = !empty($_GET['pl']) ? (int) $_GET['pl'] :  0;         // padding-left

    // Create the image
    $im = imagecreatetruecolor($w, $h);

    // Create some colors
    $background = imagecolorallocate($im, ($bc >> 16) & 0xff, ($bc >> 8) & 0xff, $bc & 0xff);
    $font_color = imagecolorallocate($im, ($fc >> 16) & 0xff, ($fc >> 8) & 0xff, $fc & 0xff);

    $grey = imagecolorallocate($im, 128, 128, 128);

    imagefilledrectangle($im, 0, 0, $w, $h, $background);

    // Arial
    $font = dirname(__FILE__) .'/../../iceAssetsPlugin/data/fonts/tahoma.ttf';

    $fw = imagefontwidth(10) + $w / 30;
    $fh = imagefontheight(10);

    // center the string
    $x = ($w * 0.95 - strlen($text) * $fw ) / 2;

    // Add the text
    imagettftext($im, $fs, 0, $pl, $pt, $font_color, $font, $text);

    // Send Content-Type
    header('HTTP/1.0 200 OK');
    header('Etag: "'. trim($m[1] .'-'. $time, ' -') .'"');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');

    if ($time !== null)
    {
      header('Last-Modified: '. gmdate('D, d M Y H:i:s', $time) .' GMT');
      header('Expires: '. gmdate('D, d M Y H:i:s', $time + 3600) .' GMT');
    }

    header('Content-Type: image/png');

    // Using imagepng() results in clearer text compared with imagejpeg()
    imagepng($im);
    imagedestroy($im);

    // Time the request
    IceStats::timing(IceFunctions::gethostname().'.plugins.multimedia.text',  microtime(true) - $_time_start);

    exit;
  }
}

header('HTTP/1.0 404 Not Found');
