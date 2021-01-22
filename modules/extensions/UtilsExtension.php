<?php

namespace modules\extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Craft;

class UtilsExtension extends AbstractExtension
{
  public function getFunctions()
  {
    return [
      new TwigFunction('is_homepage', fn () => Craft::$app->getRequest()->getFullPath() == "")
    ];
  }
}
