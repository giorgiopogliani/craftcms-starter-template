<?php

namespace modules\extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Craft;

class MixManifestExtension extends AbstractExtension
{
  public function getFunctions()
  {
    return [
      new TwigFunction('is_homepage', [$this, 'is_homepage'])
    ];
  }

  public function is_homepage()
  {
    return Craft::$app->getRequest()->getFullPath() == "";
  }
}
