<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        Phalcon\Tag::prependTitle('MPOS-v2 | ');
    }

    protected function forward($uri)
    {
      $uriParts = explode('/', $uri);
      return $this->dispatcher->forward(
        array(
          'controller' => $uriParts[0],
          'action' => $uriParts[1]
        )
      );
    }
}
