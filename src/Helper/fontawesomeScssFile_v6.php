<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_jx_std_icons
 *
 * @copyright  (c) 2023-2026 Thomas Finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Finnern\Module\mod_jx_std_icons\Site\Helper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') || die;
// phpcs:enable PSR1.Files.SideEffects

use Joomla\CMS\Factory;

enum ScssSection
{
    case preValues;
    case iconStdValues;
    case iconBrandValues;
    case preStandardIconNames;
    case iconStdNames;
    case preBrandIconNames;
    case iconBrandNames;
    case endOfFile;
}

enum IconTypeScss
{
    case standard;
    case branch;
}

/**
 * Reads content of *.scss file and sorts values into icon values list and icon names list (standard/brands)
 *
 * @since version
 */
class fontawesomeScssFile_v6 extends iconList
{
    /**
     * Determines sections and calls matching extract on the lines
     *  *
     *
     * @param   array  $lines
     *
     * @return $this
     *
     * @since version
     */
    public function scanLines(array $lines = []): fontAwesomeScssFile_v6
    {
        // iterate through line sections
        $sectionState = ScssSection::preValues;

        if (empty($lines)) {
            $lines = $this->lines;
        }

        // all lines
        foreach ($lines as $line)
        {
            // empty line
            if ($line == '')
            {
                continue;
            }

            switch ($sectionState)
            {
                case ScssSection::preValues:

                    if (str_starts_with($line, '$fa-var-0:'))
                    {
                        $sectionState = ScssSection::iconStdValues;
                        $this->extractIconValue(IconTypeScss::standard, $line);
                    }
                    break;

                case ScssSection::iconStdValues:

                    $this->extractIconValue(IconTypeScss::standard, $line);

                    // last standard item
                    if (str_starts_with($line, '$fa-var-level-up-alt:'))
                    {
                        $sectionState = ScssSection::iconBrandValues;
                    }
                    break;

                case ScssSection::iconBrandValues:
                    $this->extractIconValue(IconTypeScss::branch, $line);

                    // last brand item
                    if (str_starts_with($line, '$fa-var-steam-symbol'))
                    {
                        $sectionState = ScssSection::iconBrandValues;
                    }
                    break;


                case ScssSection::preStandardIconNames:
                    // standard indicator
                    if (str_starts_with($line, '$fa-icons: ('))
                    {
                        $sectionState = ScssSection::iconStdNames;
                    }
                    break;

                case ScssSection::iconStdNames:

                    // end of standard icons ?
                    if (str_starts_with($line, ');'))
                    {
                        $sectionState = ScssSection::iconStdNames;
                    }
                    else
                    {
                        $this->standardIconNames[] = $this->line_determineIconName(trim($line));
                    }
                    break;

                case ScssSection::preBrandIconNames:
                    // standard indicator
                    if (str_starts_with($line, '$fa-icons: ('))
                    {
                        $sectionState = ScssSection::iconStdNames;
                    }
                    else
                    {
                        $this->brandIconNames[] = $this->line_determineIconName(trim($line));
                    }
                    break;

                case ScssSection::iconBrandNames:

                    // end of brand icons ?
                    if (str_starts_with($line, ');'))
                    {
                        $sectionState = ScssSection::endOfFile;
                    }

                    break;

                case ScssSection::endOfFile:
                    // do nothing  ToDo: Use end flag
                    break;

            }

        }

        return $this;
    }

    /**
     * collect all variable name to value items
     *
     * @param   IconTypeScss  $type
     * @param   array         $line
     *
     * @return array
     *
     * @since version
     *
     */

    private function extractIconValue(IconTypeScss $type, string $line): array
    {
        [$name, $value] = $this->iconNameValueFromLine($line);

        $this->iconNames2Values [$name] = $value;

        // done in below section instead
        //if ($type == IconType::standard)
        //{
        //    $this->standardIconNames [$name] = $name;
        //}
        //else
        //{
        //    $this->brandIconNames [$name] = $name;
        //}

        return [$name, $value];
    }

    private function iconNameValueFromLine(string $line)
    {
        $name  = '';
        $value = '';

        try
        {
            // $fa-var-0: \30;

            $parts = explode(':', $line);
            if (count($parts) == 2)
            {
                $name  = 'fa-' . substr(trim($parts[0]), 8);
                $value = substr(trim($parts[1]), 0, -1);
            }
        }
        catch (\RuntimeException $e)
        {
            $OutTxt = '';
            $OutTxt .= 'Error executing iconList.iconNameValueFromLine: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return [$name, $value];
    }

    /**
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
    private function line_determineIconName(string $line)
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
            $OutTxt .= 'Error executing iconList.line_determineIconName: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return $iconName;
    }

}
