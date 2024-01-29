<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_j4_std_icons
 *
 * @copyright   Copyright (C) 2023 - 2023 thomas finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace finnern\Module\mod_j4_std_icons\Site\Helper;

use Joomla\CMS\Factory;

\defined('_JEXEC') or die;

/**
 * Collect lists of available Joomla!4 icons (standard template)
 *
 * - List of awesome icons retrieved from *.svg file(s)
 * - List of supported icons (previous icomoon) for internal style and
 *      html <span class="icon-image"> </span> from *.css file
 * - List of awesome icons which may be addressed like
        html <i class="fa fa-adjust"></i> from *.css file
 * font awsome and internal icons may be referred to the same
 *      font awesome icon but different names may be used
 *
 * @since  version 0.1
 */
class mod_j4_std_iconsHelper
{
    //--- path to files ------------------------------------------------------------------

    // Icons fontawesome in joomla Atum template
    const CSS_TEMPLATE_ATUM_PATH_FILE_NAME = JPATH_ROOT . '/media/templates/administrator/atum/css/vendor/fontawesome-free/fontawesome.css';

    // Icons fontawesome in joomla system path (backend)
	const CSS_JOOMLA_SYSTEM_PATH_FILE_NAME = JPATH_ROOT . '/media/system/css/joomla-fontawesome.css';

	//  Icons fontawesome in joomla vendor fontawesome path
	const CSS_VEDOR_AWESOME_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/css/fontawesome.css';


    // defined in J! css file
    public $awesome_version =  '%unknown%';

	// Css file icomoon replacements
    public $css_atum_template_icons = [];

	// Css file joomla fontawesome
    public $css_joomla_system_icons = [];

	// Css file vendor all fontawesome
    public $css_vendor_awesome_icons = [];

    // font char values array from J! css file
    public $iconsListByCharValue = [];

    /**
     * Extract all public data from files on creation
     * if not prevented
     * @param   bool  $watermarked
     *
     * @since version 0.1
     */
    public function __construct(bool $isExtractSvg=true, bool $isExtractCss=true)
    {

        // extract version, icons from *.css file
        if ($isExtractCss) {

            $this->extractCss_AllIcons();
        }

    }

	/**
	 *
	 *
	 * @throws \Exception
	 * @since version
	 */
	public function extractCss_AllIcons () {

		$awesome_version2 = "";
		$awesome_version3 = "";

		try
		{
			[$this->css_joomla_system_icons, $this->awesome_version] = self::cssfile_extractIcons(self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME);
            [$this->css_atum_template_icons, $awesome_version2]   = self::cssfile_extractIcons(self::CSS_TEMPLATE_ATUM_PATH_FILE_NAME);
			[$this->css_vendor_awesome_icons, $awesome_version3]    = self::cssfile_extractIcons(self::CSS_VEDOR_AWESOME_PATH_FILE_NAME);


			if (   ($this->awesome_version != $awesome_version2)
				|| ($this->awesome_version != $awesome_version3)) {

				// ToDo:
				// enqueue message different  versions
				// ....
				// 			$app = Factory::getApplication();
				//			$app->enqueueMessage($OutTxt, 'error');

			}

        } catch (\RuntimeException $e) {
			$OutTxt = '';
			$OutTxt .= 'Error executing extractCss_AllIcons: "' . '<br>';
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
    public function cssfile_extractIcons ($cssPathFileName='') {

        $css_form_icons = [];
        $awesome_version = '%unknown%';

        try {
            // Local definition
            if ($cssPathFileName=='') {
                $cssPathFileName = self::CSS_TEMPLATE_ATUM_PATH_FILE_NAME;
            }

            // Is not a file
            if (!is_file($cssPathFileName)) {
                //--- path does not exist -------------------------------

                $OutTxt = 'Warning: sourceLangFile.readFileContent: File does not exist "' . $cssPathFileName . '"<br>';

                $app = Factory::getApplication();
                $app->enqueueMessage($OutTxt, 'warning');

            } else {

                // all lines
                $lines = file($cssPathFileName);

                // do extract
                [$css_form_icons, $awesome_version] = self::lines_extractCssIcons ($lines);

                $isAssigned = true;
            }
        } catch (\RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing cssfile_extractIcons: "' . '<br>';
            $OutTxt .= 'File: "' . $cssPathFileName . '"<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return [$css_form_icons, $awesome_version];
    }

    /**
     * The lines (CSS file) contains
     *  - version of used font awesome
     *  - css definition for internal used icons (previous icomoon names)
     *  - css definition for font awesome
     *
     * @since version 0.1
     */
    public function lines_extractCssIcons ($lines = []) {

        $css_form_icons = [];
        $awesome_icons = [];
        $awesome_version = '%unknown%';

        /**
         rules:
            1) lines with :before tell start of possible icon
                Mane begins behind .fa- or .icon-
            2) Content tells that it is an icon and about its value
                The value is the ID as one may have different names
            3) Names will be kept with second ID icon/fa appended
                to enable separate lists
            Or complete name with subName will be kept ...

         example ccs file parts
            .fa-arrow-right:before {
                content: "\f061";
            }

            .icon-images:before {
            content: "\f03e";
            }
        /**/

        try {

            $iconId ='';
            $iconName = '';
            $iconCharVal ='';
            $iconType = '';

            // all lines
            foreach ($lines as $fullLine) {

                $line = trim($fullLine);

                // empty line
                if ($line == '') {
                    continue;
                }

                //--- Font Awesome version ------------------------------------------------

                $versionLineId = "Font Awesome Free ";

                // Font Awesome Free
                $startIdx = strpos($fullLine, $versionLineId);
                if ($startIdx != false) {

                    $awesome_version = substr ($fullLine, $startIdx, strlen($versionLineId) + 7); // '5.15.4 '

                }

                //--- start: icon name and id ? ------------------------------------------------

                // find "".fa-arrow-right:before {""
                if (str_contains ($line, ':before')) {

                    list ($iconId) = explode (':', $line);

                    // .fa-arrow-right, .icon-images
                    list ($iconType, $iconName) = explode ('-', $iconId, 2);

                }

                //--- inside: valid icon definition ? ------------------------------------------

                $isValid = false;

                // icon char value
                if (str_contains ($line, 'content:') ) {
                    list ($dummy1, $iconCharVal, $dummy2) = explode ('"', $line);

                    //--- create object --------------------------------------------------

                    $icon = new \stdClass();

                    $icon->name = $iconName;
                    $icon->iconId = $iconId;
                    $icon->iconCharVal = $iconCharVal;
                    $icon->iconType = $iconType;

                    //--- .icons / .fa lists ------------------

                    // if ($icon->iconType == '.icon') {
                    $css_form_icons [$iconName] = $icon;
	                //}

                }
            }

            // sort
            ksort ($css_form_icons);

        } catch (\RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing linesEextractCssIcons: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return [$css_form_icons, $awesome_version];
    }


    /**
     * ToDo:
     * create list bases on common char value
     * font awsome and internal icons may refer to same svg icon but from different n ames
     *
     * @since version 0.1
     */
    public function iconsListByCharValue ($j3x_css_icons) {
        // ToDo: is it needed ?

        $iconsListByCharValue = [];

        try {
//            foreach ($j3x_css_icons as $iconSet) {
//
//                $iconCharVal = $iconSet->iconCharVal;
//                $iconsListByCharValue[$iconCharVal][] = $iconSet;
//            }
//
//
//            ksort ($iconsListByCharValue);

        } catch (\RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing iconsListByCharValue: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        $this->iconsListByCharValue = $iconsListByCharValue;

        return $iconsListByCharValue;
    }

}
