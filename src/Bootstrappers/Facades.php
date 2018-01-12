<?php

namespace Dyrynda\Nomad\Bootstrappers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Facade;

class Facades extends Bootstrapper
{
    public function bootstrap()
    {
        Facade::setFacadeApplication($this->container);

        AliasLoader::getInstance([
            'DB' => \Illuminate\Support\Facades\DB::class,
        ])->register();
    }
}
