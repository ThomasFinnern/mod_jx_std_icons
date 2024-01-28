<?php
/**
 * @package     Joomla.site
 * @subpackage  mod_j4_std_icons
 *
 * @copyright   Copyright (C) 2023-2023 Thomas Finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 *  ToDo: update 
 *
 * This module enables to show the available Joomla!4 icons with names in a
 * own site so other developers may find and search these icons.
 * It collects and display lists of available Joomla!4 icons (standard template)
 *
 * One collection contains icon names found in the used *.svg files.
 * Other collections are retrieved from *.css file as the supported list is
 * smaller then the given *.svg icons.
 * - List of supported icons (previous icomonn) for internal style and
          html <span class="icon-image"> </span>
 * - List of supported fonmt awesome icons which may be addressed like
          html <i class="fa fa-adjust"></i>
 *
 * @since  version 0.1
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use finnern\Module\mod_j4_std_icons\Site\Helper\mod_j4_std_iconsHelper;

global $j_css_icons;

// auto load icons data from files
$j_css_icons = new mod_j4_std_iconsHelper();

//// ToDo: is it needed ?
//// common char index of font awesome icons
//$iconsListByCharValue = $j_css_icons->iconsListByCharValue( use internal data );

// display the module
// ToDo: check require ModuleHelper::getLayoutPath('mod_j4_std_icons', $params->get('layout', 'default'));
require ModuleHelper::getLayoutPath('mod_j4_std_icons');
