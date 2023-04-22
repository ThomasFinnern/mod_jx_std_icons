<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_j4_std_icons
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use finnern\Module\mod_j4_std_icons\Site\Helper\mod_j4_std_iconsHelper;

global $version, $icons, $defaultIcons;

$test  = " (created 2023.04.15)"; // mod_j4_std_iconsHelper::getText();
// echo $test;

[$icons, $version] = mod_j4_std_iconsHelper::cssfile_extractIcons();
// $url = $params->get('domain');
$iconsListByCharValue = mod_j4_std_iconsHelper::iconsListByCharValue($icons);

$defaultIcons= mod_j4_std_iconsHelper::getDefaultIcons();



// require ModuleHelper::getLayoutPath('mod_j4_std_icons', $params->get('layout', 'default'));
require ModuleHelper::getLayoutPath('mod_j4_std_icons');

