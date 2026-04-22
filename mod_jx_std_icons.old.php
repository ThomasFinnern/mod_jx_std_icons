<?php

/**
 * @package     mod_jx_std_icons
 *
 * @copyright  (c) 2023-2026 Thomas Finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * This module enables to show the available Joomla!5/6 icons with names in a
 * own site so other developers may find and search these icons.
 * It collects icomoon, standard and brand icon definitions from *.css file
 * /media/system/css/joomla-fontawesome.css'
 * and it collects all fontawesome icons from *.scss file
 * '/media/vendor/fontawesome-free/scss/_variables.scss'.
 * (*.scss data is prepared but will not be shown in display )
 *
 * Icon Displays
 *
 * - List of supported icons (previous icomonn) for internal style and
 *       html <span class="icon-!name!"> </span>
 * - List of supported font awesome icons which may be addressed like
 *       html <i class="fa fa-!name!"></i>
 * - List of supported font awesome icons which may be addressed like
 *       html <i class="fab fa-!name!"></i>
 *
 * @since  version 0.1
 */

namespace Finnern\Module\mod_jx_std_icons;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') || die;
// phpcs:enable PSR1.Files.SideEffects

use Joomla\CMS\Helper\ModuleHelper;
use Finnern\Module\mod_jx_std_icons\Site\Helper\Mod_jx_std_iconsHelper;

global $j_css_icons;

// auto load icons data from files
$j_css_icons = new Mod_jx_std_iconsHelper();

//// ToDo: is it needed ?
//// common char index of font awesome icons
//$iconListByCharValue = $j_css_icons->iconListByCharValue( use internal data );

// display the module
require ModuleHelper::getLayoutPath('mod_jx_std_icons', $params->get('layout', 'default'));
