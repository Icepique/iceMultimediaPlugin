<?php

require_once dirname(__FILE__).'/../../../../test/bootstrap/model.php';
require_once dirname(__FILE__).'/../../lib/IceMultimediaBehavior.class.php';

$t = new lime_test(2, new lime_output_color());

$book = new Book();
$book->setTitle('War and Peace');
$book->save();

$t->diag('::addMultimedia()');

  $book->addMultimedia(dirname(__FILE__) .'/../../data/test/image1.jpg');
  $book->addMultimedia(dirname(__FILE__) .'/../../data/test/image2.jpg');
  $book->addMultimedia(dirname(__FILE__) .'/../../data/test/fw4.pdf');

  $t->is($book->getMultimediaCount('image'), 2);
  $t->is($book->getMultimediaCount('pdf'), 1);
