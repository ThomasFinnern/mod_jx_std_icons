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
use Joomla\CMS\Version;

use Finnern\Module\mod_jx_std_icons\Site\Helper\extractFontAwesomeJ4x;
use Finnern\Module\mod_jx_std_icons\Site\Helper\extractFontAwesomeJ5x;
use Finnern\Module\mod_jx_std_icons\Site\Helper\extractFontAwesomeJ6x;

\defined('_JEXEC') or die;

/**
 * Collect lists of available Joomla!4 icons (standard template)
 *
 * - List of awesome icons retrieved from *.svg file(s)
 * - List of supported icons (previous icomoon) for internal style and
 *      html <span class="icon-image"> </span> from *.css file
 * - List of awesome icons which may be addressed like
        html <i class="fa fa-adjust"></i> from *.css file
 * font awesome and internal icons may be referred to the same
 *      font awesome icon but different names may be used
 *
 * @since  version 0.1
 */
class mod_jx_std_iconsHelper
{

	public string $jx_version = '';


	// defined in J! css file
	public string $awesome_version = '%unknown%';

	// Css file icomoon replacements
	public array $css_icomoon_icons = [];

	// Css file joomla fontawesome
	public array $css_joomla_system_icons = [];
	public array $css_joomla_system_brand_names = [];
	public array $css_joomla_system_brand_icons = [];

	// Css file vendor all fontawesome
	public array $css_vendor_awesome_icons = [];

	// font char values array from J! css file
	public array $iconListByCharValue = [];

	/**
	 * Extract all public data from files on creation
	 * if not prevented
	 *
	 * @param   bool  $watermarked
	 *
	 * @since version 0.1
	 */
	public function __construct(bool $isExtractSvg = true, bool $isExtractCss = true)
	{

		// extract version, icons from *.css file
		if ($isExtractCss)
		{

			$this->extractAllIcons();
		}

	}

	/**
	 * Extract all Icons by joomla CSS files
	 *
	 * @throws \Exception
	 * @since version
	 */
	public function extractAllIcons()
	{

		try
		{
			//--- Joomla! version ----------------------------------------------

			$oVersion    = new Version();
			$this->jx_version = $oVersion->getShortVersion();

			//--- Jx extractor ---------------------------------------------------

			// J4x
			if (version_compare($this->jx_version, '5', '<')) {
				$oExtract = new extractFontAwesomeJ4x();
			} else {
				// J5x
				if (version_compare($this->jx_version, '6', '<')) {
					$oExtract = new extractFontAwesomeJ5x();
				} else {
					// J6x
					if (version_compare($this->jx_version, '7', '<')) {
						$oExtract = new extractFontAwesomeJ6x();
					} else {

						$OutTxt = Text::_('Joomla version is newer than supported') . ' (>j6x)';

						$app = Factory::getApplication();
						$app->enqueueMessage($OutTxt, 'warning');

						return;
					}

				}
			}

			//--- Extract Font awesome version ----------------------------------------------

			$this->awesome_version = $oExtract->extractAwesomeVersion();

			//--- Extract Brand names ----------------------------------------------

			$this->css_joomla_system_brand_names = $oExtract->extractBrandIconNames();

			//--- icomoon replacements ----------------------------------------------

			$this->css_icomoon_icons = $oExtract->extractIcomoonIcons();

			//--- system icons / brand icons ----------------------------------------------

			[$this->css_joomla_system_icons, $this->css_joomla_system_brand_icons]
				= $oExtract->extractSystemAndBrandIcons();

			//--- brand icons ----------------------------------------------

//			$this->css_joomla_system_brand_icons = $oExtract->extractBrandIcons();

			//--- vendor font awesome icons (all) ----------------------------------------------

			$this->css_vendor_awesome_icons = $oExtract->extractFontAwesomeIcons();

//=====================================================================================================================
//=====================================================================================================================
//=====================================================================================================================
//=====================================================================================================================



//			//--- icomoon replacements ----------------------------------------------
//
//			$isFindIcomoon   = true;
//			$isCollectBrands = false;
//			$this->css_icomoon_icons =
//				self::cssfile_extractIcons(self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME,
//					$isFindIcomoon, $isCollectBrands);
//
//			//--- system icons ----------------------------------------------
//
//			$isFindIcomoon   = false;
//			$isCollectBrands = false;
//			$this->css_joomla_system_icons =
//				self::cssfile_extractIcons(self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME,
//					$isFindIcomoon, $isCollectBrands);
//
//			// collect brand icons
//			$this->css_joomla_system_brand_icons =
//				self::collectBrandIcons($this->css_joomla_system_icons, $this->css_joomla_system_brand_names);
//
//			// remove brand icons
//			$this->css_joomla_system_icons =
//				self::removeBrandIcons($this->css_joomla_system_icons, $this->css_joomla_system_brand_names);
//
//			//--- vendor font awesome icons (all) ----------------------------------------------
//
//          extractFontAwesomeIcons
//
//			$isCollectBrands = false;
//			[$this->css_vendor_awesome_icons, $dummyBrands, $awesome_version3] =
//				self::cssfile_extractIcons(self::CSS_VENDOR_AWESOME_PATH_FILE_NAME,
//					$isFindIcomoon, $isCollectBrands);
//

		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing extractAllIcons: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		return;
	}

	/**
	 * The CSS file contains
	 *  - version of used font awesome
	 *  - css definition for internal used icons (previous icomoon names)
	 *  - css definition for font awesome
	 *  -
	 * @since version 0.1
	 */
	public function cssfile_extractIcons($cssPathFileName = '',
	                                     $isFindIcomoon = false, $isCollectBrands = false)
	{

		$css_form_icons  = [];
		$css_brand_names = [];
		$awesome_version = '%unknown%';

		try
		{
			// Local definition
			if ($cssPathFileName == '')
			{
// yyy				$cssPathFileName = self::CSS_TEMPLATE_ATUM_PATH_FILE_NAME;
				$isFindIcomoon   = true;
			}

			// Is not a file
			if (!is_file($cssPathFileName))
			{
				//--- path does not exist -------------------------------

				$OutTxt = 'Warning: sourceLangFile.readFileContent: File does not exist "' . $cssPathFileName . '"<br>';

				$app = Factory::getApplication();
				$app->enqueueMessage($OutTxt, 'warning');

			}
			else
			{

				//--- read all lines ----------------------------------------------------

				$lines = file($cssPathFileName);

				//--- determine awesome version ------------------------------------------

				$awesome_version = self::lines_collectAwesomeVersion($lines);

//				//--- collect brand names ------------------------------------------------
//
//				if ($isCollectBrands)
//				{
//					$css_brand_names = self::lines_collectBrandIconNames($lines);
//				}

				//--- extract icon names ---------------------------------------------

				// do extract
				if ($isFindIcomoon)
				{
					$css_form_icons = self::lines_extractCssIconmoon($lines);
				}
				else
				{

					$oVersion    = new Version();
					$Version     = $oVersion->getShortVersion();
					$isJ6Version = version_compare($Version, '6', '>=');
					// $Version = $oVersion->getShortVersion();
					if ($isJ6Version)
					{
						$css_form_icons = self::lines_extractCssFontAwesome6($lines);
					}
					else
					{
						$css_form_icons = self::lines_extractCssFontAwesome45($lines);
					}
				}

				$isAssigned = true;
			}
		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing cssfile_extractIcons: "' . '<br>';
			$OutTxt .= 'File: "' . $cssPathFileName . '"<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		return [$css_form_icons];
	}

	/**
	 * The lines (CSS file) contains
	 *  - css definition for internal used icons (previous icomoon names)
	 *  - css definition for font awesome
	 *
	 * @since version 0.1
	 */
	public
	function lines_extractCssIconmoon($lines = [])
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
						$css_form_icons [$iconName] = $icon;
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
	 * The lines (CSS file) contains
	 *  - css definition for internal used icons (previous icomoon names)
	 *  - css definition for font awesome
	 *
	 * @since version 0.1
	 */
	public
	function lines_extractCssFontAwesome45($lines = [])
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

				list($iconClass, $iconId, $iconType, $iconName) = $this->extractFawIconProperties45($firstLine);

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


//	/**
//	 * The lines (CSS file) contains
//	 *  - font-family: "Font Awesome 5 Brands";
//	 *  -
//	 *  -
//	 *
//	 * @since version 0.1
//	 */
//	public
//	function lines_collectBrandIconNames4($lines = [])
//	{
//
//		$css_brand_names = [];
//
//		/**
//		 *
//		 * rules:
//		 * 1)
//		 * 2)
//		 * 3)
//		 *
//		 * //--- FontAwesome 5: ---------------------------------
//		 *
//		 * example css file parts
//		 * .fab, .icon-joomla, .fa-brands {
//		 * font-family: "Font Awesome 5 Brands";
//		 * }
//		 *
//		 * .fa.fa-twitter {
//		 * font-family: "Font Awesome 5 Brands";
//		 * font-weight: 400;
//		 * }
//		 *
//		 *
//		 * //--- FontAwesome 6: ---------------------------------
//		 *
//		 * example css file parts
//		 * .fab, .icon-joomla, .fa-brands {
//		 * font-family: "Font Awesome 6 Brands";
//		 * }
//		 *
//		 * .fa.fa-twitter-square {
//		 * font-family: "Font Awesome 6 Brands";
//		 * font-weight: 400;
//		 * }
//		 *
//		 * .fa.fa-pinterest, .fa.fa-pinterest-square {
//		 * ... }
//		 *
//		 * /**/
//
//		try
//		{
//
//			// $iconId ='';
//			$iconNames = [];
//			// $iconCharVal ='';
//			// $iconType = '';
//
//			$brandsId = "Brands\";";
//
//			// all lines
//			foreach ($lines as $fullLine)
//			{
//
//				$line = trim($fullLine);
//
//				// empty line
//				if ($line == '')
//				{
//					continue;
//				}
//
//				//--- start: names list line ? ------------------------------------------------
//
//				// find similar ".fab, .icon-joomla, .fa-brands {""
//				if (str_starts_with($line, '.') && str_ends_with($line, '{'))
//				{
//
//					$namesLine = substr($line, 0, -1);
//
//				}
//
//				//--- inside: valid brands definition ? ------------------------------------------
//
//				// icon char value
//				if (str_contains($line, $brandsId))
//				{
////		            if (str_contains($namesLine, 'joomla'))
////		            {
////			            $line = $line;
////		            }
//
//					//--- split -----------------------------------------------
//
//					// .fa-arrow-right, .icon-images
//					$nextNames = explode(',', $namesLine);
//
//					foreach ($nextNames as $nextName)
//					{
//
//						$nextName = trim($nextName);
//
//						//--- remove -fa-fa.... -----------------------------------------------
//
//						if (str_starts_with($nextName, '.fa.fa'))
//						{
//
//							$nextName = substr($nextName, 3);
//						}
//
//						//--- remove .fa -----------------------------------------------
//
//						if (str_starts_with($nextName, '.fa-'))
//						{
//
//							$nextName = substr($nextName, 4);
//						}
//
//						//--- remove -fa-fa.... -----------------------------------------------
//
//						if (str_starts_with($nextName, '.icon-'))
//						{
//
//							$nextName = substr($nextName, 6);
//						}
//
////			            //--- remove '.'' -----------------------------------------------
////
////			            if (str_starts_with($nextName, '.'))
////			            {
////
////				            $nextName = substr($nextName, 1);
////			            }
//
//						//--- add names to list -----------------------------------------------
//
//						$css_brand_names[] = $nextName;
//
//					}
//				}
//			}
//		}
//		catch (\RuntimeException $e)
//		{
//			$OutTxt = '';
//			$OutTxt .= 'Error executing lines_collectBrandIconNames4: "' . '<br>';
//			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';
//
//			$app = Factory::getApplication();
//			$app->enqueueMessage($OutTxt, 'error');
//		}
//
//		return $css_brand_names;
//	}
//
//	/**
//	 *
//	 * line like: '.fa.fa-twitter, .fa.fa-facebook'
//	 *
//	 * @param   string  $firstLine
//	 *
//	 * @return array
//	 *
//	 * @since version
//	 */
//	private static function line_collectBrandIconNames56(string $firstLine)
//	{
//		$brandNames = [];
//
//		// debug address-book
//		// .fa.fa-twitter, .fa.fa-facebook
//		if (str_contains($firstLine, 'fa-twitter'))
//		{
//			$test = 'twitter';
//		}
//
//		// remove ' {' at end of line
//		$itemLine = trim(substr($firstLine,0 ,-2));
//
//		$lineItems = explode(', ', $itemLine);
//
//		foreach ($lineItems as $Item)
//		{
//			if (str_starts_with($firstLine, '.fa.fa-')){
//
//				$brandName = trim(substr($Item, 7));
//				$brandNames[] = $brandName;
//			} else {
//
//				$test = 'why?';
//			}
//		}
//
//		return $brandNames;
//	}
//
//	private static function collectBrandIcons(array $icons, array $brand_names)
//	{
//
//		$brandIcons = [];
//
//		try
//		{
//			// all given icons
//			foreach ($icons as $icon)
//			{
//
//				//
//				$iconNames = explode(', ', $icon->name);
//				foreach ($iconNames as $iconName)
//				{
//					$nameParts = explode('-', $iconName);
//
//					foreach ($nameParts as $namePart)
//					{
//
//						// Use if name found in brands
//						if (in_array($namePart, $brand_names))
//						{
//
//							$brandIcons [] = $icon;
//						}
//					}
//				}
//			}
//
//		}
//		catch (\RuntimeException $e)
//		{
//			$OutTxt = '';
//			$OutTxt .= 'Error executing removeBrandIcons: "' . '<br>';
//			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';
//
//			$app = Factory::getApplication();
//			$app->enqueueMessage($OutTxt, 'error');
//		}
//
//		return $brandIcons;
//	}
//
//
//	private static function removeBrandIcons(array $icons, array $brand_names)
//	{
//
//		$noBrandIcons = [];
//
//		try
//		{
//			// all given icons
//			foreach ($icons as $icon)
//			{
//				// Use if name not found in brands
//				if (!in_array($icon->name, $brand_names))
//				{
//
//					$noBrandIcons [] = $icon;
//				}
//			}
//
//		}
//		catch (\RuntimeException $e)
//		{
//			$OutTxt = '';
//			$OutTxt .= 'Error executing removeBrandIcons: "' . '<br>';
//			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';
//
//			$app = Factory::getApplication();
//			$app->enqueueMessage($OutTxt, 'error');
//		}
//
//		return $noBrandIcons;
//	}
//

	/**
	 * ToDo:
	 * create list bases on common char value
	 * font awesome and internal icons may refer to same svg icon but from different n ames
	 *
	 * @since version 0.1
	 */
	public
	function iconListByCharValue($j3x_css_icons)
	{
		// ToDo: is it needed ?

		$iconListByCharValue = [];

		try
		{
			$test = 'xxx';

//            foreach ($j3x_css_icons as $iconSet) {
//
//                $iconCharVal = $iconSet->iconCharVal;
//                $iconListByCharValue[$iconCharVal][] = $iconSet;
//            }
//
//
//            ksort ($iconListByCharValue);

		}
		catch (\RuntimeException $e)
		{
			$OutTxt = '';
			$OutTxt .= 'Error executing iconListByCharValue: "' . '<br>';
			$OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

			$app = Factory::getApplication();
			$app->enqueueMessage($OutTxt, 'error');
		}

		$this->iconListByCharValue = $iconListByCharValue;

		return $iconListByCharValue;
	}

	/**
	 * @param   string  $firstLine
	 *
	 * @return array
	 *
	 * @since version
	 */
	public
	function extractFawIconProperties6(string $firstLine): array
	{
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

		$items = explode(',', $lineTrimmed);

		$iconNames = '';
		foreach ($items as $item)
		{

			// .fa-arrow-right, .icon-images
			list ($iconType, $iconName) = explode('-', $item, 2);

			if ($iconNames == '')
			{
				$iconId    = $iconName;
				$iconClass = $item;
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
	function extractFawIconProperties45(string $firstLine): array
	{
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

		$items = explode(',', $lineTrimmed);

		$iconNames = '';
		foreach ($items as $item)
		{

			// remove ':before'
			$cleanedItem = substr($item, 0, -7);

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
		// debug address-book
		if (str_contains($firstLine, 'address-book'))
		{
			$test = 'address-book';
		}

		//--- start: icon name and id ? ------------------------------------------------

		// extract icon name
		list ($iconClass) = explode(':', $firstLine);

		// .icon-images
		list ($iconType, $iconName) = explode('-', $iconClass, 2);
		$iconId = $iconName;

		return array($iconClass, $iconId, $iconType, $iconName);
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
				if ($startIdx != false)
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


} // class