<?php
namespace App\Container;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Interop\Container\ContainerInterface;

class DoctrineFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $proxyDir = (isset($config['doctrine']['orm']['proxy_dir'])) ?
            $config['doctrine']['orm']['proxy_dir'] : 'data/cache/EntityProxy';
        $proxyNamespace = (isset($config['doctrine']['orm']['proxy_namespace'])) ?
            $config['doctrine']['orm']['proxy_namespace'] : 'EntityProxy';
        $autoGenerateProxyClasses = (isset($config['doctrine']['orm']['auto_generate_proxy_classes'])) ?
            $config['doctrine']['orm']['auto_generate_proxy_classes'] : false;
        $underscoreNamingStrategy = (isset($config['doctrine']['orm']['underscore_naming_strategy'])) ?
            $config['doctrine']['orm']['underscore_naming_strategy'] : false;

        // Doctrine ORM
        $doctrine = new Configuration();
        $doctrine->setProxyDir($proxyDir);
        $doctrine->setProxyNamespace($proxyNamespace);
        $doctrine->setAutoGenerateProxyClasses($autoGenerateProxyClasses);
        if ($underscoreNamingStrategy) {
            $doctrine->setNamingStrategy(new UnderscoreNamingStrategy());
        }

        // ORM mapping by Annotation
        AnnotationRegistry::registerFile('vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
        $driver = new AnnotationDriver(
            new AnnotationReader(),
            $config['doctrine']['annotation']['metadata']
        );
        $doctrine->setMetadataDriverImpl($driver);

        // Cache
        $cache = $container->get(Cache::class);
        $doctrine->setQueryCacheImpl($cache);
        $doctrine->setResultCacheImpl($cache);
        $doctrine->setMetadataCacheImpl($cache);

        // EntityManager
        return EntityManager::create($config['doctrine']['connection']['orm_default'], $doctrine);
    }
}
