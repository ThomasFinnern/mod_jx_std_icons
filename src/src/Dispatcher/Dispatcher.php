<?php

/**
 * @package        mod_jx_std_icons
 *
 * @copyright  (c) 2023-2026 Thomas Finnern
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Finnern\Module\Jx_std_icons\Site\Dispatcher;

use Finnern\Module\Jx_std_icons\Site\Helper\Mod_jx_std_iconsHelper;
use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') || die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Dispatcher class for mod_jx_std_icons
 *
 * @since  4.4.0
 */
class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    /**
     * Returns the layout data.
     *
     * @return  array
     *
     * @since   0.7.0
     */
    protected function getLayoutData(): array
    {
        // module(self) params, input , app, ? module? , ,
        $data = parent::getLayoutData();
        // $params = $data['params'];

        /** @var Mod_jx_std_iconsHelper $j_css_icons */
        $j_css_icons = $this->getHelperFactory()->getHelper('Mod_jx_std_iconsHelper');
        $j_css_icons->extractAllIcons();

        $data['j_css_icons'] = $j_css_icons;

//        $data['headerText'] = trim($data['params']->get('header_text', ''));
//        $data['footerText'] = trim($data['params']->get('footer_text', ''));
//        $data['list']       = $this->getHelperFactory()->getHelper('BannersHelper')->getBanners($data['params'], $this->getApplication());

        return $data;
    }
}
