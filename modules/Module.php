<?php
namespace modules;

use Craft;
use modules\extensions\MixManifestExtension;
use modules\extensions\UtilsExtension;
use Performing\TwigComponents\ComponentExtension;

/**
 * Custom module class.
 *
 * This class will be available throughout the system via:
 * `Craft::$app->getModule('my-module')`.
 *
 * You can change its module ID ("my-module") to something else from
 * config/app.php.
 *
 * If you want the module to get loaded on every request, uncomment this line
 * in config/app.php:
 *
 *     'bootstrap' => ['my-module']
 *
 * Learn more about Yii module development in Yii's documentation:
 * http://www.yiiframework.com/doc-2.0/guide-structure-modules.html
 */
class Module extends \yii\base\Module
{
    /**
     * Initializes the module.
     */
    public function init()
    {
        // Set a @modules alias pointed to the modules/ directory
        Craft::setAlias('@modules', __DIR__);

        // Set the controllerNamespace based on whether this is a console or web request
        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            $this->controllerNamespace = 'modules\\console\\controllers';
        } else {
            Craft::$app->view->registerTwigExtension(new MixManifestExtension());
            Craft::$app->view->registerTwigExtension(new UtilsExtension());
            Craft::$app->view->registerTwigExtension(new ComponentExtension('_components'));
            $this->controllerNamespace = 'modules\\controllers';
        }

        parent::init();

        // Custom initialization code goes here...
    }
}
