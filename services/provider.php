<?php

/**
 * @package        mod_jx_std_icons
 *
 * @copyright  (c) 2023-2026 Thomas Finnern
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

use Joomla\CMS\Extension\Service\Provider\HelperFactory;
use Joomla\CMS\Extension\Service\Provider\Module as ModuleServiceProvider;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory as ModuleDispatcherFactoryServiceProvider;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

/**
 * The menu module service provider.
 *
 * @since  5.4.0
 */
return new class () implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param   Container  $container  The DI container.
     *
     * @return  void
     *
     * @since   5.4.0
     */
    public function register(Container $container): void
    {
        $container->registerServiceProvider(new ModuleDispatcherFactoryServiceProvider('\\Finnern\\Module\\Jx_std_icons'));
        $container->registerServiceProvider(new HelperFactory('\\Finnern\\Module\\Jx_std_icons\\Site\\Helper'));

        $container->registerServiceProvider(new ModuleServiceProvider());
    }
};
