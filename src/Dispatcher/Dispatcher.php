<?php

/**
 * @package        mod_jx_std_icons
 *
 * @copyright  (c) 2023-2026 Thomas Finnern
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Finnern\Module\mod_jx_std_icons\Site\Dispatcher;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') || die;

// phpcs:enable PSR1.Files.SideEffects

use Finnern\Module\mod_jx_std_icons\Site\Helper\mod_jx_std_iconsHelper;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
use Joomla\Input\Input;
use Joomla\Registry\Registry;

class Dispatcher implements DispatcherInterface
{
    // ??? use HelperFactoryAwareTrait;

    // public function __construct(\stdClass $module, CMSApplicationInterface $app, Input $input)

    protected $module;

    protected $app;

    public function __construct(\stdClass $module, CMSApplicationInterface $app, Input $input)
    {
        $this->module = $module;
        $this->app = $app;
    }

    public function dispatch()
    {
        // Is it m´needed ?
        $language = $this->app->getLanguage();
        $language->load('mod_jx_std_icons', JPATH_BASE . '/modules/mod_jx_std_icons');

        $hello = 'xxxx';
        $params = new Registry($this->module->params);


        //--- extract all icons -----------------------------------------------

        // $j_css_icons = new mod_jx_std_iconsHelper();
        $j_css_icons = new mod_jx_std_iconsHelper(false);
        $j_css_icons->extractAllIcons();

        // display the module
        require ModuleHelper::getLayoutPath('mod_jx_std_icons', $params->get('layout', 'default'));
    }

//    /**
//     * Returns the layout data.
//     *
//     * @return  array
//     *
//     * @since   5.1.0
//     */
//    protected function getLayoutData(): array
//    {
//
//        $data = parent::getLayoutData();
//
//        $params = $data['params'];
//
//        $helper = $this->getHelperFactory()->getHelper('ArticlesArchiveHelper');
//
//
//        $data['headerText'] = trim($data['params']->get('header_text', ''));
//        $data['footerText'] = trim($data['params']->get('footer_text', ''));
//        $data['list']       = $this->getHelperFactory()->getHelper('BannersHelper')->getBanners($data['params'], $this->getApplication());
//
//        return $data;
//
//    }
}
