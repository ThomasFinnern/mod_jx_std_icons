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
 * extract data from joomla! 4 files and keep data of
 *    - icomoon icons
 *    - font awesome icons
 *    - by font index
 *
 * @since  version 0.1
 */
class mod_j4_std_iconsHelper
{
    //--- path to files ------------------------------------------------------------------

	const CSS_PATH_FILE_NAME = JPATH_ROOT . '/media/templates/administrator/atum/css/vendor/fontawesome-free/fontawesome.css';

	const SVG_PATH_FILE_NAME_BRANDS = JPATH_ROOT. '/media/vendor/fontawesome-free/webfonts/fa-brands-400.svg';
	const SVG_PATH_FILE_NAME_REGULAR = JPATH_ROOT. '/media/vendor/fontawesome-free/webfonts/fa-regular-400.svg';
	const SVG_PATH_FILE_NAME_SOLID = JPATH_ROOT. '/media/vendor/fontawesome-free/webfonts/fa-solid-900.svg';

	/**
	 * @var
	 */

	// defined in J! css file
	public $awesome_version =  '%unknown%';

	// defined in J! css file
    public $j3x_css_icons = [];
    public $j4x_css_awesome_icons = [];

    // defined in J! svg file
    public $svg_icons = [];

    //  font char values from J! css file
    public $iconsListByCharValue = [];

    /**
     *
     *
     * @param   bool  $watermarked
     *
     * @since version 4.3
     */
    public function __construct(bool $isExtractSvg=true, bool $isExtractCss=true)
    {
        // extract icons from *.svg file
        if ($isExtractSvg) {

            $this->svgfile_extractIcons();
        }
        
        // extract version, icons from *.css file
        if ($isExtractCss) {

            $this->cssfile_extractIcons();
        }
        
    }



	public function cssfile_extractIcons ($cssPathFileName='') {
		
		$j3x_form_icons = [];
		$j4x_awesome_icons = [];
        $awesome_version = '%unknown%';

        try {

            if ($cssPathFileName=='') {
                $cssPathFileName = self::CSS_PATH_FILE_NAME;
            } else {
                $this->cssPathFileName = $cssPathFileName;
            }

            if (!is_file($cssPathFileName)) {
                //--- path does not exist -------------------------------

                $OutTxt = 'Warning: sourceLangFile.readFileContent: File does not exist "' . $cssPathFileName . '"<br>';

                $app = Factory::getApplication();
                $app->enqueueMessage($OutTxt, 'warning');
            } else {
                $lines = file($cssPathFileName);

                [$j3x_form_icons, $awesome_icons, $awesome_version] = self::lines_extractCssIcons ($lines);

                $isAssigned = true;
            }
        } catch (\RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing extractIconsByCssFile: "' . '<br>';
            $OutTxt .= 'File: "' . $cssPathFileName . '"<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        // Keep result in class
		$this->j3x_css_icon_icons = $j3x_form_icons;
		$this->j4x_css_awesome_icons = $awesome_icons;
        $this->awesome_version = $awesome_version;

        return [$j3x_form_icons, $j4x_awesome_icons, $awesome_version];
	}

    public function lines_extractCssIcons ($lines = []) {

        $j3x_form_icons = [];
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

                //--- Font Awesome version ------------------------------------------------

                $versionLineId = "Font Awesome Free ";

                // Font Awesome Free
                $startIdx = strpos($fullLine, $versionLineId);
                if ($startIdx != false) {

                    $awesome_version = substr ($fullLine, $startIdx, strlen($versionLineId) + 7); // '5.15.4 '

                }

                //--- start: icon name and id ? ------------------------------------------------

                // .fa-arrow-right:before {
                if (str_contains ($line, ':before')) {

                    list ($iconId) = explode (':', $line);

                    // .fa-arrow-right, .icon-images
                    list ($iconType, $iconName) = explode ('-', $iconId, 2);

                }

                //--- inside: valid icon definition ? ------------------------------------------

                $isValid = false;

                if (str_contains ($line, 'content:') ) {
                    list ($dummy1, $iconCharVal, $dummy2) = explode ('"', $line);

                    $isValid = true;
                }

                //--- create object --------------------------------------------------

                // One time per icon
                if ($isValid) {

                    $icon = new \stdClass();

                    $icon->name = $iconName;
                    $icon->iconId = $iconId;
                    $icon->iconCharVal = $iconCharVal;
                    $icon->iconType = $iconType;

                    //--- .icons / .fa lists ------------------

                    if ($icon->iconType == '.icons') {
                        $j3x_form_icons [$iconName] = $icon;
                    } else {
                        $j4x_awesome_icons [$iconName] = $icon;
                    }

// debug
//                     if (str_contains ($iconName, 'images')) {
//
//                         $test = $iconName;
//
//                     }
                }
            }

            ksort ($j3x_form_icons);
            ksort ($j4x_awesome_icons);

        } catch (\RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing linesEextractCssIcons: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return [$j3x_form_icons, $j4x_awesome_icons, $awesome_version];
    }



    public function svgfile_extractIcons($files = []): array
    {
        $svg_icons = [];

        if (empty ($files)) {
            //$files = [SVG_PATH_FILE_NAME_BRANDS, SVG_PATH_FILE_NAME_REGULAR, SVG_PATH_FILE_NAME_SOLID];
            $files = [self::SVG_PATH_FILE_NAME_REGULAR, self::SVG_PATH_FILE_NAME_SOLID];
        }

        foreach ($files as $file)
        {
            $array = json_decode(json_encode(simplexml_load_file($file)),TRUE);
            $glyphs = $array['defs']['font']['glyph'];

            foreach($glyphs as $glyph)
            {
                $svg_icons[] = $glyph['@attributes']['glyph-name'];
            }
        }

        asort($svg_icons);

        $this->svg_icons = array_unique($svg_icons);
        return $this->svg_icons;
    }


    // ToDo: is it needed ?
    public function iconsListByCharValue ($j3x_css_icons, $j4x_css_awesome_icons) {

        $iconsListByCharValue = [];

        foreach ($j3x_css_icons as $iconSet) {

            $iconCharVal = $iconSet[0]->iconCharVal;
            $iconsListByCharValue[$iconCharVal][] = $iconSet[0];
        }

        foreach ($j4x_css_awesome_icons as $iconSet) {

            $iconCharVal = $iconSet[0]->iconCharVal;
            $iconsListByCharValue[$iconCharVal][] = $iconSet[0];
        }

        ksort ($iconsListByCharValue);

        $this->iconsListByCharValue = $iconsListByCharValue;

        return $iconsListByCharValue;
    }


}
