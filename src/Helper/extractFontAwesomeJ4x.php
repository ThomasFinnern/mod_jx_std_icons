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

class extractFontAwesomeJ4x extends extractFontAwesomeBase
{
	// Icons fontawesome in joomla vendor path
	// const CSS_VENDOR_AWESOME_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/css/fontawesome.css';

	// Brand names in J!4 (font-family: "Font Awesome 5 Brands";)
	const J4X_BRAND_NAMES_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/scss/v4shims.css';

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
	public function extractBrandIconNames($brandsPathFileName = self::J4X_BRAND_NAMES_PATH_FILE_NAME)
	{
		$brandNames =  parent::extractBrandIconNames($brandsPathFileName);
		sort($brandNames);
		
		// needed to distinct between font awesome system and brand icons in extractSystemAndBrandIcons / lines
		$this->css_joomla_system_brand_names = $brandNames; 

		return $brandNames;
	}

	/**
	 * The lines (CSS file) contains
	 *  - font-family: "Font Awesome 5 Brands";
	 *  -
	 *  -
	 *
	 * @since version 0.1
	 */
	public
	function lines_collectBrandIconNames($lines = [])
	{
		$css_brand_names = [];

		/**
		 *
		 * rules:
		 * 1)
		 * 2)
		 * 3)
		 *
		 * //--- FontAwesome 5: ---------------------------------
		 *
		 * example css file parts
		 * .fab, .icon-joomla, .fa-brands {
		 * font-family: "Font Awesome 5 Brands";
		 * }
		 *
		 * .fa.fa-twitter {
		 * font-family: "Font Awesome 5 Brands";
		 * font-weight: 400;
		 * }
		 *
		 * /**/

		try
		{

			// $iconId ='';
			$iconNames = [];
			// $iconCharVal ='';
			// $iconType = '';

			$brandsId = "Brands\";";

			// all lines
			foreach ($lines as $fullLine)
			{

				$line = trim($fullLine);

				// empty line
				if ($line == '')
				{
					continue;
				}

				//--- start: names list line ? ------------------------------------------------

				// find similar ".fab, .icon-joomla, .fa-brands {""
				if (str_starts_with($line, '.') && str_ends_with($line, '{'))
				{

					$namesLine = substr($line, 0, -1);

				}

				//--- inside: valid brands definition ? ------------------------------------------

				// icon char value
				if (str_contains($line, $brandsId))
				{
//		            if (str_contains($namesLine, 'joomla'))
//		            {
//			            $line = $line;
//		            }

					//--- split -----------------------------------------------

					// .fa-arrow-right, .icon-images
					$nextNames = explode(',', $namesLine);

					foreach ($nextNames as $nextName)
					{

						$nextName = trim($nextName);

						//--- remove -fa-fa.... -----------------------------------------------

						if (str_starts_with($nextName, '.fa.fa'))
						{

							$nextName = substr($nextName, 3);
						}

						//--- remove .fa -----------------------------------------------

						if (str_starts_with($nextName, '.fa-'))
						{

							$nextName = substr($nextName, 4);
						}

						//--- remove -fa-fa.... -----------------------------------------------

						if (str_starts_with($nextName, '.icon-'))
						{

							$nextName = substr($nextName, 6);
						}

//			            //--- remove '.'' -----------------------------------------------
//
//			            if (str_starts_with($nextName, '.'))
//			            {
//
//				            $nextName = substr($nextName, 1);
//			            }

						//--- add names to list -----------------------------------------------

						$css_brand_names[] = $nextName;

					}
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
		 * Mane begins behind .fa- or .icon-
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

				list($iconClass, $iconId, $iconType, $iconName) = $this->extractSystemIconProperties($firstLine);

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

					//--- .fa lists ------------------

					// system if name not found in brands
					if ( ! in_array($iconName, $brandNames))
					{
						$css_system_icons [$iconName] = $icon;
					}
					else
					{
						$css_brand_icons [$iconName] = $icon;
					}
				}
				else
				{

					$dummy1 = trim($line);

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
	

//	/**
//	 *
//	 * @return mixed
//	 *
//	 * @since version
//	 */
//	public function extractIcomoonIcons($cssPathFileName = '')
//	{
//		$brandNames = [];
//
//		return $brandNames;
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