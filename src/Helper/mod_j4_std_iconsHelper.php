<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_j4_std_icons
 *
 * @copyright   Copyright (C) 2023 - 2023 thomas finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace finnern\Module\mod_j4_std_icons\Site\Helper;

\defined('_JEXEC') or die;

/**
 * Helper for mod_j4_std_icons
 *
 * @since  __BUMP_VERSION__
 */
class mod_j4_std_iconsHelper
{
	/**
	 * Retrieve mod_j4_std_icons test
	 *
	 * @param   Registry        $params  The module parameters
	 * @param   CMSApplication  $app     The application
	 *
	 * @return  array
	 */
	public static function getText()
	{
		return 'mod_j4_std_iconsHelpertest';
	}
	
	public static function cssfile_extractIcons () {
		
		$oIcons = [];
		
		// ToDo: class iconXXX 
		
        try {
            $cssPathFileName = JPATH_ROOT . '/media/templates/administrator/atum/css/vendor/fontawesome-free/fontawesome.css';
            // $handle = fopen(cssPathFileName, "r");

            if (!is_file($cssPathFileName)) {
                //--- path does not exist -------------------------------

                $OutTxt = 'Warning: sourceLangFile.readFileContent: File does not exist "' . $cssPathFileName . '"<br>';

                $app = Factory::getApplication();
                $app->enqueueMessage($OutTxt, 'warning');
            } else {
                $lines = file($cssPathFileName);

                $oIcons = self::lines_extractCssIcons ($lines);

                $isAssigned = true;
            }
        } catch (RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing extractIconsByCssFile: "' . '<br>';
            $OutTxt .= 'File: "' . $cssPathFileName . '"<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return $oIcons;
	}

    public static function lines_extractCssIcons ($lines = []) {

        $icons = [];

        /**
         rules:
            1) lines with :before tell start of possible icon
                Mane begins behind .fa- or .icon-
            2) Content tells that it is an icon and about its value
                The value is the ID as one may have different names
            3) Names will be kept with second ID icon/fa appended
                to enable separate lists
            Or complete name with subName will be kept ...

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

            foreach ($lines as $fullLine) {

                $line = trim($fullLine);

                // empty line
                if ($line == '') {
                    continue;
                }

                //--- icon name and id ? ------------------------------------------------

                if (str_contains ($line, ':before')) {

                    // .fa-arrow-right:before {
                    list ($iconId) = explode (':', $line);

                    // .fa-arrow-right
                    list ($iconType, $iconName) = explode ('-', $iconId, 2);

                }

                //--- valid icon definition ? ------------------------------------------

                $isValid = false;

                if (str_contains ($line, 'content:') ) {
                    list ($dummy1, $iconCharVal, $dummy2) = explode ('"', $line);

                    $isValid = true;
                }

                //--- create object --------------------------------------------------

                if ($isValid) {

                    $icon = new \stdClass();

                    $icon->name = $iconName;
                    $icon->iconId = $iconId;
                    $icon->iconCharId = $iconCharVal;
                    $icon->iconType = $iconType;

                    // ToDo: List may just array ?
                    $icons [$iconName][] = $icon;

                    if (str_contains ($iconName, 'images')) {

                        $test = $iconName;

                    }
                }
            }

            ksort ($icons);

        } catch (\RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing linesEextractCssIcons: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return $icons;
    }

    // ToDo: list of sorted
    // ToDo:
    // ToDo:
    // ToDo:
    // ToDo:

    public static function iconsListByCharValue ($icons) {

        $iconsListByCharValue = [];

        foreach ($icons as $icon) {

            $iconCharVal = $icons->iconCharVal;

        }






        return $iconsListByCharValue;
    }





}
