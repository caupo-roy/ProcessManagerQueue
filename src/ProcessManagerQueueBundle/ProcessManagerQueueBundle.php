<?php

namespace ProcessManagerQueueBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;

class ProcessManagerQueueBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    protected function getComposerPackageName(): string
    {
        return 'caupo/process-manager-queue';
    }

    public function getJsPaths()
    {
        return [
        ];
    }

    public function getCssPaths()
    {
        return [
        ];
    }
}

?>