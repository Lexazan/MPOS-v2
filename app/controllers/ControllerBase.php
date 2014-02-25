<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        Phalcon\Tag::prependTitle('MPOS-v2 | ');
    }
}
