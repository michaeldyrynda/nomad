<?php

namespace Dyrynda\Nomad;

use Composer\Script\Event;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ComposerScripts
{
    public static function preAutoloadDump(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');

        if (is_dir($vendorDir.'/laravel/framework')) {
            // Vagabond is being included in a Laravel application,
            // so we can safely remove laravel-zero/foundation.
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($vendorDir.'/laravel-zero', RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $file) {
                $todo = $file->isDir() ? 'rmdir' : 'unlink';
                $todo($file->getRealPath());
            }

            rmdir($vendorDir.'/laravel-zero');
        }
    }
}
