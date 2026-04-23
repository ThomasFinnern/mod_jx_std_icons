<?php

/**
 * @package        mod_jx_std_icons
 *
 * @copyright  (c) 2023-2026 Thomas Finnern
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Finnern\Module\Mod_jx_std_icons\Site\Dispatcher;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') || die;
// phpcs:enable PSR1.Files.SideEffects

use Finnern\Module\Mod_jx_std_icons\Site\Helper\Mod_jx_std_iconsHelper;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;

/**
 * Dispatcher class for mod_jx_std_icons
 *
 * @since  4.4.0
 */
class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

//    // public function __construct(\stdClass $module, CMSApplicationInterface $app, Input $input)
//
//    protected $module;
//
//    protected $app;
//
//    public function __construct(\stdClass $module, CMSApplicationInterface $app, Input $input)
//    {
//        $this->module = $module;
//        $this->app = $app;
//    }
//
//    public function dispatch()
//    {
//        // Is it m´needed ?
//        $language = $this->app->getLanguage();
//        $language->load('mod_jx_std_icons', JPATH_BASE . '/modules/mod_jx_std_icons');
//
//        $hello = 'xxxx';
//        $params = new Registry($this->module->params);
//
//
//        //--- extract all icons -----------------------------------------------
//
//        // $j_css_icons = new Mod_jx_std_iconsHelper();
//        $j_css_icons = new Mod_jx_std_iconsHelper(false);
//        $j_css_icons->extractAllIcons();
//
//        // display the module
//        require ModuleHelper::getLayoutPath('mod_jx_std_icons', $params->get('layout', 'default'));
//    }

    /**
     * Runs the dispatcher.
     *
     * @return  void
     *
     * @since   5.4.0
     */
    public function dispatch()
    {
        $displayData = $this->getLayoutData();

        if (!$displayData['j_css_icons']) {
            return;
        }

        parent::dispatch();
    }

    /**
     * Returns the layout data.
     *
     * @return  array
     *
     * @since   0.7.0
     */
    protected function getLayoutData(): array
    {

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

	function displayTechDetail($description, $link)
	{
		?>
		<div class="mb-3">
			<div class="card-title">
				<div>
					<?php echo $description ?>
				</div>
				<?php if (!empty($link)) : ?>
					<div>
						<a href="<?php echo $link ?>"><?php echo $link ?></a>
					</div>
				<?php endif; ?>
			</div>

		</div>
		<?php
	}

    function displayIcon_asQuickicon($iconName, $iconClass, $icon_font_size, $name_font_size)
    {
        ?>
        <li class="icon_li quickicon quickicon-single">
            <a href="#" class="quickicon-link">
                <div class="quickicon-info">
                    <div class="quickicon-icon">
                        <i class="<?php echo $iconClass; ?> icon_style_tmpl icon_style" tabindex="0"></i>
                    </div>
                </div>
                <div class="quickicon-name hidden_name icon_name_style">
                    <?php echo $iconName; ?>
                </div>
            </a>
        </li>
        <?php
    }

    function displayIcon($iconName, $iconClass, $icon_font_size, $name_font_size)
    {
        ?>
        <li class="icon_li_tmpl icon_li" >
            <i class="<?php echo $iconClass; ?> icon_style_tmpl icon_style" tabindex="0"></i>
            <span class="icon_name_style_tmpl icon_name_style">
            <?php echo $iconName; ?>
        </span>
        </li>
        <?php
    }

}
