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

class extractFontAwesomeJ5x extends extractFontAwesomeBase
{
	// Icons fontawesome in joomla vendor path
	// const CSS_VENDOR_AWESOME_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/css/fontawesome.css';

	// Brand names in J!5 (font-family: "Font Awesome 6 Brands";)
	const J5X_BRAND_NAMES_PATH_FILE_NAME = JPATH_ROOT . '/media/system/css/joomla-fontawesome.css';

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
	public function extractBrandIconNames($brandsPathFileName = self::J5X_BRAND_NAMES_PATH_FILE_NAME)
	{
		$brandNames =  parent::extractBrandIconNames($brandsPathFileName);
		sort($brandNames);

		// needed to distinct between font awesome system and brand icons in extractSystemAndBrandIcons / lines
		$this->css_joomla_system_brand_names = $brandNames;

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
						if (str_contains($line, 'font-family: "Font Awesome 6 Brands"') )
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
	 * line like: '.fa.fa-twitter, .fa.fa-facebook'
	 *
	 * @param   string  $firstLine
	 *
	 * @return array
	 *
	 * @since version
	 */
	private static function line_collectBrandIconNames(string $firstLine)
	{
		$brandNames = [];

		try
		{

			// debug address-book
			// .fa.fa-twitter, .fa.fa-facebook
			if (str_contains($firstLine, 'fa-twitter'))
			{
				$test = 'twitter';
			}

			// remove ' {' at end of line
			$itemLine = trim(substr($firstLine, 0, -2));

			$lineItems = explode(', ', $itemLine);

			foreach ($lineItems as $Item)
			{
				if (str_starts_with($firstLine, '.fa.fa-'))
				{

					$brandName    = trim(substr($Item, 7));
					$brandNames[] = $brandName;
				}
				else
				{
					$test = 'why?';
				}
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



//	/**
//	 *
//	 * @return mixed
//	 *
//	 * @since version
//	 */
//	public function extractIcomoonIcons($cssPathFileName = self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME)
//	{
//		$css_form_icons =  = parent::extractIcomoonIcons($cssPathFileName);
//      sort($css_form_icons);
//
//		return $css_form_icons;
//	}


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
		 * Name begins behind .fa- or .icon-
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

				list($iconClass, $iconId, $iconType, $iconName) = $this->extractFawIconProperties($firstLine);


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


	//--- .fa lists ------------------
	public function lines_collectSystemAndBrandIcons(array $lines)
	{
		$css_system_icons = [];
		$css_brand_icons = [];

		// needed to distinct between font awesome system and brand icons in extractSystemAndBrandIcons / lines
		$brandNames = $this->css_joomla_system_brand_names;

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
			$iconId      = '';
			$iconName    = '';
			$iconCharVal = '';
			$iconType    = '';

			$firstLine    = '';
			$isSecondLine = false;


			// all lines
			foreach ($lines as $fullLine) {
				$line = trim($fullLine);

				// empty line
				if ($line == '') {
					continue;
				}

				$validLine = false;
				if (str_starts_with($line, '.fa')) {
					$firstLine    = $line;
					$isSecondLine = true;
				} else {
					if ($isSecondLine) {
						if (str_starts_with($line, '--fa:')) {
							$validLine    = true;
							$isSecondLine = false;
						} else {
							$isSecondLine = false;
						}
					}
				}

				if (!$validLine) {
					continue;
//		            $test = 'test01';
				}

				//--- extract icon font awesome definition ------------------------------------------

				// list($iconClass, $iconId, $iconType, $iconName) = $this->extractSystemIconProperties($firstLine);
				list($iconClass, $iconId, $iconType, $iconName) = $this->extractFawIconProperties($firstLine);

				//--- inside: valid icon definition ? ------------------------------------------

				list ($dummy1, $iconCharVal, $dummy2) = explode('"', $line);

				//--- create object --------------------------------------------------

				$icon = new \stdClass();

				$icon->name        = $iconName;
				$icon->iconId      = $iconId;
				$icon->iconCharVal = $iconCharVal;
				$icon->iconType    = $iconType;

				//--- .fa lists ------------------

				// system if name not found in brands
				if (!in_array($iconName, $brandNames)) {
					$css_system_icons [$iconId] = $icon;
				} else {
					$css_brand_icons [$iconId] = $icon;
				}
			}

			// sort
			ksort($css_system_icons);
			ksort($css_brand_icons);

		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing linesEextractCssIcons: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		return [$css_system_icons, $css_brand_icons];
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
	function extractIconSystemProperties(string $firstLine): array
	{
		$iconClass = '';
		$iconId = '';
		$iconType = '';
		$iconNames = '';

		// debug address-book
		if (str_contains($firstLine, 'address'))
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
			$cleanedItem = trim($item); // substr($item, 0, -7);

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
			$cleanedItem = trim($item); // substr($item, 0, -7);

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






} // class