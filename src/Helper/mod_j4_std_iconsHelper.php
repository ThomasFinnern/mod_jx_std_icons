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
 * - List of supported icons (previous icomonn) for internal style and
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

    // Css file
    const CSS_PATH_FILE_NAME = JPATH_ROOT . '/media/templates/administrator/atum/css/vendor/fontawesome-free/fontawesome.css';

    // Svg files
    const SVG_PATH_FILE_NAME_BRANDS = JPATH_ROOT. '/media/vendor/fontawesome-free/webfonts/fa-brands-400.svg';
    const SVG_PATH_FILE_NAME_REGULAR = JPATH_ROOT. '/media/vendor/fontawesome-free/webfonts/fa-regular-400.svg';
    const SVG_PATH_FILE_NAME_SOLID = JPATH_ROOT. '/media/vendor/fontawesome-free/webfonts/fa-solid-900.svg';

    /**
     * @var
     */

    // available icons in J! svg file
    public $svg_icons = [];

    // defined in J! css file
    public $awesome_version =  '%unknown%';

    // internal icons defined in J! css file
    public $j3x_css_icons = []; // rename -> form icons ?

    // supported awesome icons defined in J! css file
    public $j4x_css_awesome_icons = [];

    //  font char values from J! css file
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
        // extract icons from *.svg file
        if ($isExtractSvg) {

            $this->svgfile_extractIcons();
        }

        // extract version, icons from *.css file
        if ($isExtractCss) {

            $this->cssfile_extractIcons();
        }

    }

    /**
     * The CSS file contains
     *  - version of used font awesome
     *  - css definition for internal used icons (previous icomonn names)
     *  - css definition for font awesome
     *  -
     * @since version 0.1
     */
    public function cssfile_extractIcons ($cssPathFileName='') {

        $j3x_css_form_icons = [];
        $j4x_awesome_icons = [];
        $awesome_version = '%unknown%';

        try {
            // Local definition
            if ($cssPathFileName=='') {
                $cssPathFileName = self::CSS_PATH_FILE_NAME;
            } else {
                $this->cssPathFileName = $cssPathFileName;
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
                [$j3x_css_form_icons, $awesome_icons, $awesome_version] = self::lines_extractCssIcons ($lines);

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

        // Keep result in class
        $this->j3x_css_form_icons    = $j3x_css_form_icons;
        $this->j4x_css_awesome_icons = $awesome_icons;
        $this->awesome_version       = $awesome_version;

        return [$j3x_css_form_icons, $j4x_awesome_icons, $awesome_version];
    }

    /**
     * The lines (CSS file) contains
     *  - version of used font awesome
     *  - css definition for internal used icons (previous icomonn names)
     *  - css definition for font awesome
     *
     * @since version 0.1
     */
    public function lines_extractCssIcons ($lines = []) {

        $j3x_css_form_icons = [];
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

                    if ($icon->iconType == '.icon') {
                        $j3x_css_form_icons [$iconName] = $icon;
                    } else {
                        $j4x_awesome_icons [$iconName] = $icon;
                    }

                }
            }

            // sort
            ksort ($j3x_css_form_icons);
            ksort ($j4x_awesome_icons);

        } catch (\RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing linesEextractCssIcons: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return [$j3x_css_form_icons, $j4x_awesome_icons, $awesome_version];
    }

    /**
     * collect names of all font awesome icons in file
     *
     * @since version 0.1
     */
    public function svgfile_extractIcons($files = []): array
    {
        $svg_icons = [];

        try {
            // external ?
            if (empty ($files)) {
                //$files = [SVG_PATH_FILE_NAME_BRANDS, SVG_PATH_FILE_NAME_REGULAR, SVG_PATH_FILE_NAME_SOLID];
                $files = [self::SVG_PATH_FILE_NAME_REGULAR, self::SVG_PATH_FILE_NAME_SOLID];
            }

            // collect names from all files
            foreach ($files as $file)
            {
                $array = json_decode(json_encode(simplexml_load_file($file)),TRUE);
                $glyphs = $array['defs']['font']['glyph'];

                foreach($glyphs as $glyph)
                {
                    $svg_icons[] = $glyph['@attributes']['glyph-name'];
                }
            }

            // sort
            asort($svg_icons);

            // No doubles
            $this->svg_icons = array_unique($svg_icons);
        } catch (\RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing linesEextractCssIcons: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }


        return $this->svg_icons;
    }


    /**
     * create list bases on common char value
     * font awsome and internal icons may refer to same svg icon but from different n ames
     *
     * @since version 0.1
     */
    public function iconsListByCharValue ($j3x_css_icons, $j4x_css_awesome_icons) {
        // ToDo: is it needed ?

        $iconsListByCharValue = [];

        try {
//            foreach ($j3x_css_icons as $iconSet) {
//
//                $iconCharVal = $iconSet->iconCharVal;
//                $iconsListByCharValue[$iconCharVal][] = $iconSet;
//            }
//
//            foreach ($j4x_css_awesome_icons as $iconSet) {
//
//                $iconCharVal = $iconSet->iconCharVal;
//                $iconsListByCharValue[$iconCharVal][] = $iconSet;
//            }
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
