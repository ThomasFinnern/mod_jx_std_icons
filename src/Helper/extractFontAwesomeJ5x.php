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


//	public function lines_extractCssFontAwesome ($lines = [])
//	{
//		// $css_awesome_icons = '%unknown%';
//
//		$css_awesome_icons = parent::lines_extractCssFontAwesome($lines);
//
//		return $css_awesome_icons;
//	}







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