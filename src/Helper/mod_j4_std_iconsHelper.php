<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_j4_std_icons
 *
 * @copyright   Copyright (C) 2023 - 2023 thomas finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace finnern\Module\mod_j4_std_icons\Site\Helper;

\defined('_JEXEC') or die;

/**
 * Helper for mod_j4_std_icons
 *
 * @since  __BUMP_VERSION__
 */
class mod_j4_std_iconsHelper
{
	/**
	 * Retrieve mod_j4_std_icons test
	 *
	 * @param   Registry        $params  The module parameters
	 * @param   CMSApplication  $app     The application
	 *
	 * @return  array
	 */
	public static function getText()
	{
		return 'mod_j4_std_iconsHelpertest';
	}
}
