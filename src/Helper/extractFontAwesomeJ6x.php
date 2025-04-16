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
	// const CSS_VENDOR_AWESOME_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/css/fontawesome.css';

	const J6X_BRAND_NAMES_PATH_FILE_NAME = JPATH_ROOT . '/media/system/css/joomla-fontawesome.css';

	public function __construct() {
		parent::__construct();
	}

//	/**
//	 *
//	 * @return mixed
//	 *
//	 * @since version
//	 */
//	public function extractAwesomeVersion($vendorPathFileName = self::CSS_VENDOR_AWESOME_PATH_FILE_NAME)
//	{
//		// $awesome_version = '%unknown%';
//
//		$awesome_version = parent::extractAwesomeVersion($vendorPathFileName);
//
//		return $awesome_version;
//	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractBrandIconNames($brandsPathFileName = self::J6X_BRAND_NAMES_PATH_FILE_NAME)
	{
		$brandNames =  $this->extractBrandIconNames($brandsPathFileName);
		sort($brandNames);

		return $brandNames;
	}

	public function lines_collectBrandIconNames(array $lines)
	{
		$css_brand_names = [];

		/**

		 * //--- FontAwesome 6: ---------------------------------
		 *
		 * example css file parts
		 * .fab, .icon-joomla, .fa-brands {
		 * font-family: "Font Awesome 6 Brands";
		 * }
		 *
		 * .fa.fa-twitter-square {
		 * font-family: "Font Awesome 6 Brands";
		 * font-weight: 400;
		 * }
		 *
		 * .fa.fa-pinterest, .fa.fa-pinterest-square {
		 * ... }
		 *
		 * /**/

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
				if (str_starts_with($line, '.fa.fa'))
				{
					$firstLine    = $line;
					$isSecondLine = true;
				}
				else
				{
					if ($isSecondLine)
					{
//					    if (str_contains($line, 'font-family: "Font Awesome 6 Brands"') && $isSecondLine)
						if (str_contains($line, 'font-family: "Font Awesome') )
						{
							$validLine    = true;
							$isSecondLine = false;
						}
						else
						{
							$isSecondLine = false;
						}
					}
				}
				if (!$validLine)
				{
					continue;
//		            $test = 'test01';
				}

				$lineBrands = $this->line_collectBrandIconNames($firstLine);

				//--- add names to list -----------------------------------------------

				foreach ($lineBrands as $brandName)
				{
					$css_brand_names[] = $brandName;
				}
			}
		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing lines_collectBrandIconNames: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		return $css_brand_names;
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	public function extractIcomoonIcons($cssPathFileName = '')
	{
		$brandNames = [];

		return $brandNames;
	}

//	/**
//	 *
//	 * @return mixed
//	 *
//	 * @since version
//	 */
//	public function extractFontAwesomeIcons($vendorPathFileName = self::CSS_VENDOR_AWESOME_PATH_FILE_NAME)
//	{
//		// $awesome_version = '%unknown%';
//
//		$awesome_version = parent::extractFontAwesomeIcons($vendorPathFileName);
//
//		return $awesome_version;
//	}

	/**
	 * The lines (CSS file) contains
	 *  - css definition for internal used icons (previous icomoon names)
	 *  - css definition for font awesome
	 *
	 * @since version 0.1
	 */
	public
	function lines_extractCssFontAwesome($lines = [])
	{

		$css_form_icons = [];

		/**
		 * rules:
		 * 1) lines with :before tell start of possible icon
		 * Mane begins behind .fa- or .icon-
		 * 2) Content tells that it is an icon and about its value
		 * The value is the ID as one may have different names
		 * 3) Names will be kept with second ID icon/fa appended
		 * to enable separate lists
		 * Or complete name with subName will be kept ...
		 *
		 * example css file parts
		 * .fa-football, .fa-football-ball {
		 * --fa: "";
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
				if (str_starts_with($line, '.fa'))
				{
					$firstLine    = $line;
					$isSecondLine = true;
				}
				else
				{

					if (str_starts_with($line, '--fa:') && $isSecondLine)
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

				list($iconClass, $iconId, $iconType, $iconName) = $this->extractFawIconProperties6($firstLine);


				//--- inside: valid icon definition ? ------------------------------------------

				// if (str_starts_with($line, '--fa:') && $isSecondLine)

				// icon char value
				if (str_contains($line, '--fa:'))
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
						$css_form_icons [$iconName] = $icon;
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