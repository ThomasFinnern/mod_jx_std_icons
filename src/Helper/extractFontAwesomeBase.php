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

abstract class extractFontAwesomeBase
{
	// Icons fontawesome in joomla Atum template
	const CSS_TEMPLATE_ATUM_PATH_FILE_NAME = JPATH_ROOT . '/media/templates/administrator/atum/css/vendor/fontawesome-free/fontawesome.css';

	// Icons fontawesome in joomla system path (backend)
	const CSS_JOOMLA_SYSTEM_PATH_FILE_NAME = JPATH_ROOT . '/media/system/css/joomla-fontawesome.css';

	// Icons fontawesome in joomla vendor path
	const CSS_VENDOR_AWESOME_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/css/fontawesome.css';


	// Css file joomla fontawesome
	public array $css_joomla_system_icons = [];
	public array $css_joomla_system_brand_names = [];
	public array $css_joomla_system_brand_icons = [];

	// Css file vendor all fontawesome
	public array $css_vendor_awesome_icons = [];

	public function __construct() {
		
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractAwesomeVersion($vendorPathFileName = self::CSS_VENDOR_AWESOME_PATH_FILE_NAME)
	{


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

				$awesome_version = $this->lines_collectAwesomeVersion($lines);

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
	public function extractBrandIconNames($brandsPathFileName = self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME)
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

				//--- brand names ------------------------------------------

				$brandNames = $this->lines_collectBrandIconNames($lines);
				sort($brandNames);
			}
		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing extractBrandIconNames: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		return $brandNames;
	}

	public function lines_collectBrandIconNames(array $lines)
	{
		$css_brand_names = [];

		$OutTxt = Text::_('lines_collectBrandIconNames must be overwritten');

		$app = Factory::getApplication();
		$app->enqueueMessage($OutTxt, 'warning');

		return $css_brand_names;
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractIcomoonIcons($cssPathFileName = self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME)
	{
		$css_form_icons  = [];

		// Is not a file
		if (!is_file($cssPathFileName))
		{
			//--- path does not exist -------------------------------

			$OutTxt = 'Warning: extractIcomoonIcons: File does not exist "' . $cssPathFileName . '"<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'warning');

		}
		else
		{
			//--- read all lines ----------------------------------------------------

			$lines = file($cssPathFileName);

			//--- collect icomoon icons ------------------------------------------

			$css_form_icons = $this->lines_collectIcomoonIcons($lines);

		}

		return $css_form_icons;
	}

	/**
	 * The lines (CSS file) contains
	 *  - css definition for internal used icons (previous icomoon names)
	 *  - css definition for font awesome
	 *
	 * @since version 0.1
	 */
	public function lines_collectIcomoonIcons(array $lines)
	{
		$css_form_icons = [];

//		$OutTxt = Text::_('lines_collectIcomoonIcons must be overwritten');
//
//		$app = Factory::getApplication();
//		$app->enqueueMessage($OutTxt, 'warning');

		/**
		 * rules:
		 * 1) lines with :before tell start of possible icon
		 * Name begins behind .fa- or .icon-
		 * 2) Content tells that it is an icon and about its value
		 * The value is the ID as one may have different names
		 * 3) Names will be kept with second ID icon/fa appended
		 * to enable separate lists
		 * Or complete name with subName will be kept ...
		 *
		 * example css file parts
		 * .icon-images {
		 * content: "\f03e";
		 * }
		 * /**/

		try
		{

			$iconId      = '';
			$iconName    = '';
			$iconCharVal = '';
			$iconType    = '';

			$firstLine    = '';
			$isSecondLine = false;

			// all lines
			foreach ($lines as $fullLine)
			{

				$line = trim($fullLine);

				// empty line
				if ($line == '')
				{
					continue;
				}

				$validLine = false;
				if (str_starts_with($line, '.icon'))
				{
					$firstLine    = $line;
					$isSecondLine = true;

				}
				else
				{

					if (str_starts_with($line, 'content:') && $isSecondLine)
					{
						$validLine    = true;
						$isSecondLine = false;
					}
					else
					{
						$isSecondLine = false;
					}
				}

				if (!$validLine)
				{
					continue;
//		            $test = 'test01';
				}

				//--- extract icon icomoon definition ------------------------------------------
				list($iconClass, $iconId, $iconType, $iconName) = $this->extractIconIcomoonProperties($firstLine);

				//--- inside: valid icon definition ? ------------------------------------------

				// icon char value
				if (str_contains($line, 'content:'))
				{
					list ($dummy1, $iconCharVal, $dummy2) = explode('"', $line);

					//--- create object --------------------------------------------------

					$icon = new \stdClass();

					$icon->name        = $iconName;        // Display (maybe two names)
					$icon->iconId      = $iconId;        // is used in view .icon + iconId
					$icon->iconClass   = $iconClass;  // what is extracted
					$icon->iconCharVal = $iconCharVal; // character
					$icon->iconType    = $iconType;       // '.icon' or '.fa'

					//--- .icons / .fa lists ------------------

					if ($icon->iconType == '.icon')
					{
						$css_form_icons [$iconId] = $icon;
					}
				}
			}

			// sort
			ksort($css_form_icons);

		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing linesEextractCssIcons: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		return $css_form_icons;
	}

	/**
	 * @param   string  $firstLine
	 * @param   string  $iconName
	 *
	 * @return array
	 *
	 * @since version
	 */
	public
	function extractIconIcomoonProperties(string $firstLine): array
	{
		$iconClass = '';
		$iconId = '';
		$iconType = '';
		$iconNames = '';

		// debug address-book
		if (str_contains($firstLine, 'address-book'))
		{
			$test = 'address-book';
		}

		// debug address-book
		if (str_contains($firstLine, 'football-ball'))
		{
			$test = 'football-ball';
		}

//		// debug address-book
//		if (! str_contains($firstLine, '-'))
//		{
//			$test = 'no minus';
//		}

		//--- start: icon name and id ? ------------------------------------------------

		// .icon-joomla:before {

		// .fa-football, .fa-football-ball {

		$lineTrimmed = trim(substr($firstLine, 0, -1));
		// $lineTrimmed = trim($firstLine[0,-1]);

		$items = explode(', ', $lineTrimmed);

		foreach ($items as $item)
		{
			// remove ':before'
			$cleanedItem = trim(substr($item, 0, -7));

			// .fa-arrow-right, .icon-images
			list ($iconType, $iconName) = explode('-', $cleanedItem, 2);

			// debug missing icon name
			if ($iconName == '')
			{
				$test = 'no split / explode';
			}

			// First name
			if ($iconNames == '')
			{
				$iconId    = $iconName;
				$iconClass = $iconType; // ??? $cleanedItem / $iconType
				$iconNames .= $iconName;
			}
			else
			{
				$iconNames .= ', ' . $iconName;
			}
		}

		return array($iconClass, $iconId, $iconType, $iconNames);
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractFontAwesomeIcons($fontAwesomePathFileName = self::CSS_VENDOR_AWESOME_PATH_FILE_NAME)
	{
//		$css_awesome_icons = [];
//
//		$OutTxt = Text::_('extractFontAwesomeIcons must be overwritten');
//
//		$app = Factory::getApplication();
//		$app->enqueueMessage($OutTxt, 'warning');
//
//		return $css_awesome_icons;

		$css_awesome_icons = [];

		try
		{
			// Is not a file
			if (!is_file($fontAwesomePathFileName))
			{
				//--- path does not exist -------------------------------

				$OutTxt = 'Warning: extractFontAwesomeIcons: File does not exist "' . $fontAwesomePathFileName . '"<br>';

				$app = Factory::getApplication();
				$app->enqueueMessage($OutTxt, 'warning');

			}
			else
			{
				//--- read all lines ----------------------------------------------------

				$lines = file($fontAwesomePathFileName);

				//--- collect awesome icons ------------------------------------------

				// J 4/5
				$css_awesome_icons = $this->lines_extractCssFontAwesome($lines);
				ksort($css_awesome_icons);
			}
		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing extractFontAwesomeIcons: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		return $css_awesome_icons;
	}

	/**
	 * The lines (CSS file) contains
	 *  - css definition for internal used icons (previous icomoon names)
	 *  - css definition for font awesome
	 *
	 * @since version 0.1
	 */
	public function lines_extractCssFontAwesome($lines = [])
	{
		$css_form_icons = [];

		/**
		 * rules:
		 * 1) lines with :before tell start of possible icon
		 * Name begins behind .fa- or .icon-
		 * 2) Content tells that it is an icon and about its value
		 * The value is the ID as one may have different names
		 * 3) Names will be kept with second ID icon/fa appended
		 * to enable separate lists
		 * Or complete name with subName will be kept ...
		 *
		 * example css file parts
		 * .fa-arrow-right:before {
		 * content: "\f061";
		 * }
		 */

		try
		{
			$firstLine    = '';
			$isSecondLine = false;

			// all lines
			foreach ($lines as $fullLine)
			{

				$line = trim($fullLine);

				// empty line
				if ($line == '')
				{
					continue;
				}

				$validLine = false;
				if (str_starts_with($line, '.fa'))
				{
					$firstLine    = $line;
					$isSecondLine = true;
				}
				else
				{

					if (str_starts_with($line, 'content:') && $isSecondLine)
					{
						$validLine    = true;
						$isSecondLine = false;
					}
					else
					{
						$isSecondLine = false;
					}
				}

				if (!$validLine)
				{
					continue;
//		            $test = 'test01';
				}

				//--- extract icon font awesome definition ------------------------------------------

				list($iconClass, $iconId, $iconType, $iconName) = $this->extractFawIconProperties($firstLine);

				//--- inside: valid icon definition ? ------------------------------------------

				// if (str_starts_with($line, '--fa:') && $isSecondLine)

				// icon char value
				if (str_contains($line, 'content:'))
				{
					list ($dummy1, $iconCharVal, $dummy2) = explode('"', $line);

					//--- create object --------------------------------------------------

					$icon = new \stdClass();

					$icon->name        = $iconName;
					$icon->iconId      = $iconId;
					$icon->iconCharVal = $iconCharVal;
					$icon->iconType    = $iconType;

					//--- .icons / .fa lists ------------------

					if ($icon->iconType != '.icon')
					{
						$css_form_icons [$iconId] = $icon;
					}

				}
				else
				{

					$dummy1 = trim($line);

				}
			}

			// sort
			ksort($css_form_icons);

		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing linesEextractCssIcons: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		return $css_form_icons;
	}

	/**
	 * @param   string  $firstLine
	 *
	 * @return array
	 *
	 * @since version
	 */
	public
	function extractFawIconProperties(string $firstLine): array
	{
		$iconClass = '';
		$iconId = '';
		$iconType = '';
		$iconNames = '';

		// debug address-book
		if (str_contains($firstLine, 'address-book'))
		{
			$test = 'address-book';
		}
		// debug address-book-o
		if (str_contains($firstLine, 'address-book-o'))
		{
			$test = 'address-book-o';
		}
		// debug football
		if (str_contains($firstLine, 'football'))
		{
			$test = 'football';
		}

		//--- start: icon name and id ? ------------------------------------------------

		// .fa-football, .fa-football-ball {

		$lineTrimmed = trim(substr($firstLine, 0, -1));
		// $lineTrimmed = trim($firstLine[0,-1]);

		$items = explode(', ', $lineTrimmed);

		foreach ($items as $item)
		{
			// remove ':before'
			$cleanedItem = trim(substr($item, 0, -7));

			// .fa-arrow-right, .icon-images
			list ($iconType, $iconName) = explode('-', $cleanedItem, 2);

			// First name
			if ($iconNames == '')
			{
				$iconId    = $iconName;
				$iconClass = $cleanedItem;
				$iconNames .= $iconName;
			}
			else
			{
				$iconNames .= ', ' . $iconName;
			}
		}

		return array($iconClass, $iconId, $iconType, $iconNames);
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractSystemAndBrandIcons($cssPathFileName = self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME)
	{
		$css_system_icons  = [];

		// Is not a file
		if (!is_file($cssPathFileName))
		{
			//--- path does not exist -------------------------------

			$OutTxt = 'Warning: extractSystemAndBrandIcons: File does not exist "' . $cssPathFileName . '"<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'warning');

		}
		else
		{
			//--- read all lines ----------------------------------------------------

			$lines = file($cssPathFileName);

			//--- collect system icons ------------------------------------------

			$css_system_icons = $this->lines_collectSystemAndBrandIcons($lines);

		}

		return $css_system_icons;
	}

	public function lines_collectSystemAndBrandIcons(array $lines)
	{
		$css_form_icons = [];

		$OutTxt = Text::_('lines_collectSystemAndBrandIcons must be overwritten');

		$app = Factory::getApplication();
		$app->enqueueMessage($OutTxt, 'warning');

		return $css_form_icons;

	}

//	/**
//	 *
//	 * @return mixed
//	 *
//	 * @since version
//	 */
//	public function extractBrandIcons($cssPathFileName = self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME)
//	{
////		$brandNames = [];
////
////		$OutTxt = Text::_('extractBrandIcons must be overwritten');
////
////		$app = Factory::getApplication();
////		$app->enqueueMessage($OutTxt, 'warning');
////
////		return $brandNames;
//		$css_brand_icons  = [];
//
//		// Is not a file
//		if (!is_file($cssPathFileName))
//		{
//			//--- path does not exist -------------------------------
//
//			$OutTxt = 'Warning: extractSystemAndBrandIcons: File does not exist "' . $cssPathFileName . '"<br>';
//
//			$app = Factory::getApplication();
//			$app->enqueueMessage($OutTxt, 'warning');
//
//		}
//		else
//		{
//			//--- read all lines -----------------------------------------------
//
//			$lines = file($cssPathFileName);
//
//			//--- collect brand icons ------------------------------------------
//
//			$css_brand_icons = $this->lines_collectBrandIcons($lines);
//
//		}
//
//		return $css_brand_icons;
//	}
//
//
//	public function lines_collectBrandIcons(array $lines)
//	{
//		$css_brand_names = [];
//
//		$OutTxt = Text::_('lines_collectBrandIcons must be overwritten');
//
//		$app = Factory::getApplication();
//		$app->enqueueMessage($OutTxt, 'warning');
//
//		return $css_brand_names;
//	}

} // class