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

global $awesome_version, $j3x_css_icons, $j4x_css_awesome_icons, $svg_icons; //, $iconsListByCharValue

$test  = " (created 2023.05.01)";

// bool $isExtractSvg=true, bool $isExtractCss=true
$j4_std_icons = new mod_j4_std_iconsHelper();

//// icomoon and awesome icons referenced in *.css file
//[$j3x_form_icons, $j4x_awesome_icons, $awesome_version] =
//        $mod_j4_std_icons->cssfile_extractIcons();
$j3x_css_icons         = $j4_std_icons->j3x_css_icons;
$j4x_css_awesome_icons = $j4_std_icons->j4x_css_awesome_icons;
$svg_icons             = $j4_std_icons->svg_icons;
$awesome_version       = $j4_std_icons->awesome_version;

// ToDo: is it needed ?
// common char index of font awesome icons
$iconsListByCharValue = $j4_std_icons->iconsListByCharValue($j3x_css_icons, $j4x_css_awesome_icons);

// display the module
// ToDo: check require ModuleHelper::getLayoutPath('mod_j4_std_icons', $params->get('layout', 'default'));
require ModuleHelper::getLayoutPath('mod_j4_std_icons');
