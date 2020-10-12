<?php


namespace modules\extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MixManifestExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('mix', [$this, 'mix'])
        ];
    }

    public function mix($name)
    {
        $mix = $this->getPublicFile('mix-manifest.json');

        if (is_null($mix)) {
            return null;
        }

        if (!array_key_exists($name, $mix)) {
            return null;
        }

        return $mix[$name];
    }

    protected function getPublicFile($filename)
    {
        $path =
            CRAFT_BASE_PATH .
            DIRECTORY_SEPARATOR .
            '..' .
            DIRECTORY_SEPARATOR .
            $filename;

        try {
            return json_decode(file_get_contents($path), true);
        } catch (\Exception $e) {
            \Craft::error('mix-manifest.json is missing');
        }

        return null;
    }
}