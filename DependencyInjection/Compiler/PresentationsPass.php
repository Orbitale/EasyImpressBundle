<?php

namespace Orbitale\Bundle\EasyImpressBundle\DependencyInjection\Compiler;

use Orbitale\Bundle\EasyImpressBundle\Configuration\ConfigProcessor;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class PresentationsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $finder = (new Finder())
            ->files()
            ->name('*.{yaml,yml}')
            ->in($container->getParameter('easy_impress.presentations_dir'))
        ;

        $configProcessor = new ConfigProcessor();

        $presentations = [];

        foreach ($finder as $file) {
            /** @var \SplFileInfo $file */
            $container->addResource(new FileResource($file->getRealPath()));
            $presentations[preg_replace('~\.ya?ml$~', '', $file->getBasename())] = $configProcessor->processConfigurationFile($file);
        }

        $container->setParameter('easy_impress.presentations', $presentations);
    }
}
