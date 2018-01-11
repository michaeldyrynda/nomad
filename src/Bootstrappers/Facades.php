<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Illuminate\Support\Facades\Facade;

class Facades extends Bootstrapper
{
    public function bootstrap()
    {
        Facade::setFacadeApplication($this->container);
    }
}
