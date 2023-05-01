<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_j4_std_icons
 *
 * @copyright   Copyright (C) 2023-2023 Thomas Finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use finnern\Module\mod_j4_std_icons\Site\Helper\mod_j4_std_iconsHelper;

global $version, $icons, $defaultIcons;

$test  = " (created 2023.05.01)";

// icomoon and awesome icons referenced in *.css file
[$icons, $version] = mod_j4_std_iconsHelper::cssfile_extractIcons();

// common char index of font awesome icons
$iconsListByCharValue = mod_j4_std_iconsHelper::iconsListByCharValue($icons);

// from *.svg file
$defaultIcons= mod_j4_std_iconsHelper::getDefaultIcons();

// display the module
// require ModuleHelper::getLayoutPath('mod_j4_std_icons', $params->get('layout', 'default'));
require ModuleHelper::getLayoutPath('mod_j4_std_icons');
