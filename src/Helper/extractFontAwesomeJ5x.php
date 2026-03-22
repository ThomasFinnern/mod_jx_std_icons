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

\defined('_JEXEC') or die;

class extractFontAwesomeJ5x extends extractFontAwesomeBase
{
    // Icons fontawesome in joomla vendor path
    // const CSS_VENDOR_AWESOME_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/css/fontawesome.css';

    // in J!5 and J!6 iterate through lines for icons
    const CSS_VENDOR_AWESOME_SCSS_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/scss/_variables.scss';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Collects from SCSS the standard and brand icon names
     *
     * @return mixed
     *
     * @since version
     */
    public function extractScssIconFileData($brandsPathFileName = self::CSS_VENDOR_AWESOME_SCSS_PATH_FILE_NAME)
    {
        // will call lines_collectScssIconNames
        [$scssIconValues, $stdandardNames, $brandNames] = parent::extractScssIconFileData($brandsPathFileName);

//        sort($stdandardNames);
//        sort($brandNames);

        // needed to distinct between font awesome system and brand icons in extractSystemAndBrandIcons / lines
        $this->css_joomla_system_brand_names = $brandNames;

        return [$scssIconValues, $stdandardNames, $brandNames];
    }

    /**
     * Collects from SCSS the standard and brand icon values
     *
     * @return mixed
     *
     * @since version
     */
    public function lines_collectScssIconNames(array $lines)
    {
        $css_brand_names = [];
        $css_std_names   = [];

        /**
         * //--- FontAwesome 6: SCSS file---------------------------------
         *
         * $fa-icons: (
         *  "0": $fa-var-0,
         *  "1": $fa-var-1,
         *  "2": $fa-var-2,
         *  "3": $fa-var-3,
         *  ... )
         *
         * $fa-brand-icons: (
         *  "monero": $fa-var-monero,
         *  "hooli": $fa-var-hooli,
         *  "yelp": $fa-var-yelp,
         *  "cc-visa": $fa-var-cc-visa,
         *  ... )
         *
         * /**/

        try
        {
            $isInStdLines    = false;
            $isStdLinesFound = false;
            $isInBrandLines  = false;

            // all lines
            foreach ($lines as $fullLine)
            {

                $line = trim($fullLine);

                // empty line
                if ($line == '')
                {
                    continue;
                }

                // check for start of standard icon section
                if (!$isInStdLines && !$isStdLinesFound)
                {

                    // Start of standard icons
                    if (str_starts_with($line, '$fa-icons: ('))
                    {

                        $isInStdLines    = true;
                        $isStdLinesFound = true;

                    }
                    else
                    {
                        continue;
                    }

                }
                else
                {

                    //--- standard icons ------------------------------

                    if ($isInStdLines)
                    {

                        // end of standard icons
                        if (str_starts_with($line, ');'))
                        {
                            $isInStdLines = false;
                        }
                        else
                        {
                            $css_std_names[] = $this->line_determineIconName(trim($line));
                        }
                    }
                    else
                    {

                        // check for start of brand icon section
                        if (!$isInBrandLines) // Start of standard icons
                        {
                            if (str_starts_with($line, '$fa-brand-icons: ('))
                            {

                                $isInBrandLines = true;

                            }
                            else
                            {
                                continue;
                            }
                        }
                        else
                        {

                            //--- brand icons ------------------------------

                            if ($isInBrandLines)
                            {

                                // end of brand icons
                                if (str_starts_with($line, ');'))
                                {
                                    break;
                                }
                                else
                                {
                                    $css_brand_names[] = $this->line_determineIconName(trim($line));
                                }
                            }
                        }
                    }

                }

            } // foreach
        }
        catch (\RuntimeException $e)
        {
            $OutTxt = '';
            $OutTxt .= 'Error executing lines_collectScssIconNames: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return [$css_std_names, $css_brand_names];
    }


    /**
     *
     * line like:
     * "monero": $fa-var-monero,
     * "hooli": $fa-var-hooli,
     *
     * @param   string  $firstLine
     *
     * @return string
     *
     * @since version
     */
    private static function line_determineIconName(string $line)
    {
        $iconName = '';

        try
        {
            $trimmed = trim($line);

            $idx = strpos($trimmed, ":");

            if (!empty($idx))
            {
                // "monero": $fa-var-monero,
                // $iconName = 'fa-' . substr($line, 1, $idx - 2);
                $iconName = substr($line, 1, $idx - 2);
            }
        }
        catch (\RuntimeException $e)
        {
            $OutTxt = '';
            $OutTxt .= 'Error executing lines_collectScssIconNames56: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return $iconName;
    }

    public function lines_collectScssIconValues(array $lines)
    {
        $scssIconValues = [];

        /**
         * //--- FontAwesome 6: SCSS file---------------------------------
         *
         * $fa-var-0: \30;
         * $fa-var-1: \31;
         * $fa-var-2: \32;
         * $fa-var-3: \33;
         */


        try
        {
            $isInValueLines    = false;
            $isValueLinesFound = false;

            // all lines
            foreach ($lines as $fullLine)
            {

                $line = trim($fullLine);

                // empty line
                if ($line == '')
                {
                    continue;
                }

                // check for start of standard icon section
                if (!$isInValueLines)
                {

                    // Start of icon values
                    if (str_starts_with($line, '$fa-var-0: '))
                    {

                        $isInValueLines = true;

                        [$name, $value] = $this->iconNameValueFromLine($line);
                        $scssIconValues [$name] = $value;

                    }
                    else
                    {
                        continue;
                    }

                }
                else
                {
                    //--- icons values ------------------------------

                    [$name, $value] = $this->iconNameValueFromLine($line);
                    $scssIconValues [$name] = $value;

                    // end of icon values
                    if (str_starts_with($line, '$fa-var-steam-symbol: '))
                    {
                        break;
                    }

                }
            } // foreach
        }
        catch (\RuntimeException $e)
        {
            $OutTxt = '';
            $OutTxt .= 'Error executing lines_collectScssIconNames: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return $scssIconValues;
    }

    private function iconNameValueFromLine(string $line)
    {
        $name  = '';
        $value = '';

        return [$name, $value];
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
        $css_brand_icons  = [];

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
                    if ($isSecondLine)
                    {
                        if (str_starts_with($line, '--fa:'))
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

//                // if ($iconName == '42-group')
//                if (str_starts_with($iconName, '42'))
//                {
//                    $css_brand_icons = [];
//                }

                // maybe more than one name contained so use first
                if (str_contains($iconName, ','))
                {
                    $test1    = explode(',', $iconName);
                    $test2    = $test1[0];
                    $test3    = explode(',', $iconName)[0];
                    $iconName = explode(',', $iconName)[0];
                }

                // system if name not found in brands
                if (!in_array($iconName, $brandNames))
                {
                    $css_system_icons [$iconId] = $icon;
                }
                else
                {
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
    public function extractIconSystemProperties(string $firstLine): array
    {
        $iconClass = '';
        $iconId    = '';
        $iconType  = '';
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
    public function extractFawIconProperties(string $firstLine): array
    {
        $iconClass = '';
        $iconId    = '';
        $iconType  = '';
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
