<?php

namespace AjaxFormValidationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AjaxFormValidationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');


        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        





        $conf = Yaml::parse(file_get_contents(__DIR__.'/../Resources/config/config_ajax_validation.yml'));
        $conf = array_replace_recursive($conf, ['ajax_form_validation' => $config]);

        $processor = new Processor();
        $processedConfiguration = $processor->processConfiguration(new Configuration, $conf);

        if ($container->hasDefinition('validator.configs'))
        {
            $definition = $container->getDefinition('validator.configs');
            $definition->replaceArgument(0, $processedConfiguration);
        }

    }

    private function merge($array1, $array2)
    {
        foreach ($array1 as $k => $element)
        {
            if (isset($array2[$k]) && is_array($array2[$k]))
            {
                $this->merge($element, $array2[$k]);
            }
        }
    }
}
