<?php
namespace Tramite\Contracts\Spider;

use Tracking\Abstracts\MetricManager;

use Tramite\Spider\Traits\ExtensionManagerTrait;
use Support\Helps\DebugHelper;
use Support\Helps\CodeFileHelper;

/**
 * Outputs events information to the console.
 *
 * @see TriggerableInterface
 */
abstract class ExtensionManager
{
    use ExtensionManagerTrait;

    public function __construct($file, MetricManager $metrics)
    {
        $this->setFile($file);
        DebugHelper::debug('File Manager'.$this->getFile());
        $this->run();

        $metrics->registerMetricCount('Extensions', CodeFileHelper::getClassName($this));
    }
}
