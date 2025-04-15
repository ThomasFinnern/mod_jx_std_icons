<?php
/**
* @package     Joomla.Site
* @subpackage  mod_jx_std_icons
*
* @copyright   Copyright (C) 2023 - 2023 thomas finnern
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/

namespace Finnern\Module\mod_jx_std_icons\Site\Helper;

use Joomla\CMS\Factory;
use Joomla\CMS\Version;

use Finnern\Module\mod_jx_std_icons\Site\Helper\extractFontAwesomeBase;

\defined('_JEXEC') or die;

class extractFontAwesomeJ6x extends extractFontAwesomeBase
{
	// Icons fontawesome in joomla vendor path
	const CSS_VENDOR_AWESOME_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/css/fontawesome.css';

	const J6X_BRAND_NAMES_PATH_FILE_NAME = JPATH_ROOT . '/media/system/css/joomla-fontawesome.css';

	public function __construct() {
		parent::__construct();
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractAwesomeVersion($vendorPathFileName = self::CSS_VENDOR_AWESOME_PATH_FILE_NAME)
	{
		// $awesome_version = '%unknown%';

		$awesome_version = parent::extractAwesomeVersion($vendorPathFileName);

		return $awesome_version;
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractBrandIconNames($brandsPathFileName = '')
	{
		$brandNames = [];

		return $brandNames;
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractIcomoonIcons($brandsPathFileName = '')
	{
		$brandNames = [];

		return $brandNames;
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractFontAweIcons($brandsPathFileName = '')
	{
		$brandNames = [];

		return $brandNames;
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractBrIcons($brandsPathFileName = '')
	{
		$brandNames = [];

		return $brandNames;
	}








} // class