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
use Joomla\CMS\Language\Text;

\defined('_JEXEC') or die;

class extractFontAwesomeBase
{
	// Css file joomla fontawesome
	public array $css_joomla_system_icons = [];
	public array $css_joomla_system_brand_names = [];
	public array $css_joomla_system_brand_icons = [];

	// Css file vendor all fontawesome
	public array $css_vendor_awesome_icons = [];

	public function __construct() {
		
	}

	public function lines_collectBrandIconNames(array $lines)
	{
		// raise (version_compare($this->jx_version, '8', '<'));;
		throw new \Exception(Text::_('lines_collectBrandIconNames must be overwritten'), 403);
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractAwesomeVersion($vendorPathFileName = '')
	{
		$awesome_version = '%unknown%';

		$awesome_version = '%unknown%';

		try
		{

			// Is not a file
			if (!is_file($vendorPathFileName))
			{
				//--- path does not exist -------------------------------

				$OutTxt = 'Warning: extractAwesomeVersion: File does not exist "' . $vendorPathFileName . '"<br>';

				$app = Factory::getApplication();
				$app->enqueueMessage($OutTxt, 'warning');

			}
			else
			{

				//--- read all lines ----------------------------------------------------

				$lines = file($vendorPathFileName);

				//--- determine awesome version ------------------------------------------

				$awesome_version = self::lines_collectAwesomeVersion($lines);

			}

		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing extractAwesomeVersion: "' . '<br>';
			$OutTxt .= 'File: "' . $vendorPathFileName . '"<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		return $awesome_version;
	}

	/**
	 * The lines (CSS file) contains version of used font awesome
	 *     line example: ' * Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com
	 * The Lines are scanned until id is found.
	 * ID is extracted and retunred
	 *
	 * @since version 0.4.0
	 */
	public
	function lines_collectAwesomeVersion($lines = [])
	{
		$awesome_version = '%unknown%';

		try
		{
			$versionLineId = "Font Awesome Free";

			// all lines
			foreach ($lines as $fullLine)
			{

				$line = trim($fullLine);

				// empty line
				if ($line == '')
				{
					continue;
				}

				//--- Font Awesome version ------------------------------------------------

				// Font Awesome Free
				$startIdx = strpos($fullLine, $versionLineId);
				if ($startIdx)
				{
					// example ' * Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com
					$endIdx = strpos($fullLine, ' ', $startIdx + strlen($versionLineId) + 1);

					$awesome_version = substr($fullLine, $startIdx, $endIdx - $startIdx); // '5.15.4 '

					break;
				}
			}

		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing lines_collectAwesomeVersion: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

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

		try
		{
			// Is not a file
			if (!is_file($brandsPathFileName))
			{
				//--- path does not exist -------------------------------

				$OutTxt = 'Warning: extractBrandIconNames: File does not exist "' . $brandsPathFileName . '"<br>';

				$app = Factory::getApplication();
				$app->enqueueMessage($OutTxt, 'warning');

			}
			else
			{
				//--- read all lines ----------------------------------------------------

				$lines = file($brandsPathFileName);

				//--- determine awesome version ------------------------------------------

				$brandNames = self::lines_collectBrandIconNames($lines);

			}
		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing lines_collectBrandIconNames56: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

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