<?php
namespace App\Container;

use Doctrine\Common\Cache\ArrayCache;
use Interop\Container\ContainerInterface;

class DoctrineArrayCacheFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ArrayCache();
    }
}
