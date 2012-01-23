<?php

require_once dirname(__FILE__).'/../../../../test/bootstrap/model.php';
require_once dirname(__FILE__).'/../../lib/model/iceModelMultimediaPeer.php';

$t = new lime_test(1, new lime_output_color());

$t->diag('::getValidContentTypes()');

  $t->is(in_array('jpg', iceModelMultimediaPeer::getValidContentTypes()), true, 'Checking if JPG is supported');
