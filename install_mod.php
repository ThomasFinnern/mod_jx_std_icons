<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_jx_std_icons
 * 
 * @copyright (c) 2005-2023 Thomas Finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;

/**
 * Script file of mod_jx_std_icons module
 */
class mod_jx_std_iconsInstallerScript
{

    private string $minimumJoomla = '4.4.0';
    private string $minimumPhp    = '7.4.0';

	/**
	 * Function called before extension installation/update/removal procedure commences
	 *
	 * @param   string            $type    The type of change (install, update or discover_install, not uninstall)
	 * @param   InstallerAdapter  $parent  The class calling this method
	 *
	 * @return  boolean  True on success
	 */
	function preflight($type, $parent)
	{
		// // Check for the minimum PHP version before continuing
		// if (!empty($this->minimumPhp) && version_compare(PHP_VERSION, $this->minimumPhp, '<')) {
			// Log::add(Text::sprintf('JLIB_INSTALLER_MINIMUM_PHP', $this->minimumPhp), Log::WARNING, 'jerror');

			// return false;
		// }

		// // Check for the minimum Joomla version before continuing
		// if (!empty($this->minimumJoomla) && version_compare(JVERSION, $this->minimumJoomla, '<')) {
			// Log::add(Text::sprintf('JLIB_INSTALLER_MINIMUM_JOOMLA', $this->minimumJoomla), Log::WARNING, 'jerror');

			// return false;
		// }

		echo Text::_('MOD_JX_STD_ICONS_INSTALLERSCRIPT_PREFLIGHT');

		return true;
	}


	/**
	 * Method to install the extension
	 *
	 * @param   InstallerAdapter  $parent  The class calling this method
	 *
	 * @return  boolean  True on success
	 */
	function install($parent)
	{
		// echo Text::_('MOD_JX_STD_ICONS_INSTALLERSCRIPT_INSTALL');

		return true;
	}

	/**
	 * Method to uninstall the extension
	 *
	 * @param   InstallerAdapter  $parent  The class calling this method
	 *
	 * @return  boolean  True on success
	 */
	function uninstall($parent)
	{
		// echo Text::_('MOD_JX_STD_ICONS_INSTALLERSCRIPT_UNINSTALL');

		return true;
	}

	/**
	 * Method to update the extension
	 *
	 * @param   InstallerAdapter  $parent  The class calling this method
	 *
	 * @return  boolean  True on success
	 */
	function update($parent)
	{
		// echo Text::_('MOD_JX_STD_ICONS_INSTALLERSCRIPT_UPDATE');

		return true;
	}

	/**
	 * Function called after extension installation/update/removal procedure commences
	 *
	 * @param   string            $type    The type of change (install, update or discover_install, not uninstall)
	 * @param   InstallerAdapter  $parent  The class calling this method
	 *
	 * @return  boolean  True on success
	 */
	function postflight($type, $parent)
	{
		// echo Text::_('MOD_JX_STD_ICONS_INSTALLERSCRIPT_POSTFLIGHT');

		return true;
	}
}
