<?php

namespace App\Lib\Authorization;

use App\Lib\Configuration\ConfigurationFactory;

class Base
{
    /** @var \App\Lib\Configuration\Configuration */
    protected $configuration;

    public function __construct()
    {
        $this->configuration = ConfigurationFactory::fromFileName('common');
        $this->configuration->setSegment('authorization');
    }
}
