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

enum CssSection
{
    case findVersion;
    case preStandardIconValues;
    case iconValues;
    case preBrandIconValues;
    case iconBrandValues;
    case preIcomoonValues;
    case icomoonValues;
    case endOfFile;
}

enum IconTypeCss
{
    case standard;
    case branch;
}

/**
 * Reads content of *.css file and sorts values into icon values list and icon names list (standard/brands)
 * Extracts additional icomoon icons and fontawesome version
 *
 * @since version
 */
class joomlaFontawesomeCssFile_j5x extends iconList
{
    const VERSION_LINE_ID = "Font Awesome Free";

    // only in joomla...*.css file
    public string $awesome_version = '';

    // only in joomla...*.css file
    /** list [name] = [value] */
    public array $icomoonNames2Values = [];

    /* list [name1, name2, ...] = class id */
    public array $icomoonIconNames = [];


    protected string $previousLine = '';

    /**
     * @param   array  $lines
     *
     * @return $this
     */
    public function scanLines(array $lines = [])
    {

        $this->icomoonNames2Values = [];
        $this->icomoonIconNames    = [];

        // iterate through line sections
        $sectionState = CssSection::findVersion;

        // font awesome definition
        // .fa-medium, .fa-medium-m {
        //  --fa: "";
        //}
        // icomoon definition
        // .icon-address-book:before, .icon-address:before {
        //  content: "";
        //}

        if (empty($lines))
        {
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

            // no white spaces needed
            $line = trim($line);

            switch ($sectionState)
            {
                case CssSection::findVersion:

                    //--- Font Awesome version ------------------------------------------------

                    // Font Awesome Free
                    $startIdx = strpos($line, self::VERSION_LINE_ID);
                    if ($startIdx)
                    {
                        // example ' * Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com
                        $endIdx                = strpos($line, ' ', $startIdx + strlen(self::VERSION_LINE_ID) + 1);
                        $this->awesome_version = substr($line, $startIdx, $endIdx - $startIdx); // '5.15.4 '

                        $sectionState = CssSection::preStandardIconValues;
                    }
                    break;


                case CssSection::preStandardIconValues:

                    if (str_starts_with($line, '.fa-0 {'))
                    {
                        // first line of definition
                        $this->previousLine = $line;

                        $sectionState = CssSection::iconValues;
                    }
                    break;

                case CssSection::iconValues:

                    if (str_starts_with($line, '.fa-'))
                    {
                        $this->previousLine = $line;
                    }
                    else
                    {
                        if (str_starts_with($line, '--fa:'))
                        {
                            $this->assignStandardIcon($this->previousLine, $line);
                        }
                    }

                    // end of standard icon values
                    if (str_starts_with($line, '.fa.fa'))
                    {

                        $sectionState = CssSection::preBrandIconValues;
                    }
                    break;


                case CssSection::preBrandIconValues:
                    // standard indicator
                    if (str_starts_with($line, '.fa-monero {'))
                    {
                        // first line of definition
                        $this->previousLine = $line;

                        $sectionState = CssSection::iconBrandValues;
                    }
                    break;


                case CssSection::iconBrandValues:
                    if (str_starts_with($line, '.fa-'))
                    {
                        $this->previousLine = $line;
                    }
                    else
                    {
                        if (str_starts_with($line, '--fa:'))
                        {
                            $this->assignBrandIcon($this->previousLine, $line);
                        }
                    }


                    // last brand item
                    if (str_starts_with($line, '[class^="icon-"]'))
                    {
                        $sectionState = CssSection::preIcomoonValues;
                    }
                    break;


                case CssSection::preIcomoonValues:
                    // standard indicator
                    if (str_starts_with($line, '.icon-joomla'))
                    {
                        // first line of definition
                        $this->previousLine = $line;

                        $sectionState = CssSection::icomoonValues;
                    }
                    break;

                case CssSection::icomoonValues:

                    if (str_starts_with($line, '.icon-'))
                    {
                        $this->previousLine = $line;
                    }
                    else
                    {
                        if (str_starts_with($line, 'content:'))
                        {
                            $this->assignIcomoonIcon($this->previousLine, $line);
                        }
                    }
                    break;
            }

        }

        //--- sort alphabetically -------------------------------

        $this->sortLists();

        // local variables
        //        ksort($this->iconValues2Names);
        ksort($this->icomoonIconNames);


        return $this;
    }

    private function assignStandardIcon(string $previousLine, mixed $line)
    {
        [$names, $iconClass] = $this->extractIconNames($previousLine);
        $value = $this->extractIconValue($line);

        foreach ($names as $name)
        {
            $this->iconNames2Values [$name] = $value;
        }

        $concatenatedNames = implode(', ', $names);
        $this->standardIconNames [$concatenatedNames] = 'fa ' . $iconClass;
    }

    private function assignBrandIcon(string $previousLine, mixed $line)
    {
        [$names, $iconClass] = $this->extractIconNames($previousLine);
        $value = $this->extractIconValue($line);

        foreach ($names as $name)
        {
            $this->iconNames2Values [$name] = $value;
        }

        $concatenatedNames = implode(', ', $names);
        $this->brandIconNames [$concatenatedNames] = 'fab ' . $iconClass;
    }

    private function extractIconNames(string $namesLine): array
    {
        $names = [];

        $lineTrimmed = trim(substr($namesLine, 0, -1));
        $ids         = explode(', ', $lineTrimmed);

        foreach ($ids as $id)
        {
            $name     = substr($id, 4);
            $names [] = $name;

            $iconClass = substr($id, 1);
        }

        return [$names, $iconClass];
    }

    private function extractIconValue(string $line)
    {
        $value = '';

        return $value;
    }

    private function assignIcomoonIcon(string $previousLine, mixed $line)
    {
        $previousLine = str_replace(':before', '', $previousLine);
        $line         = str_replace('content', '--fa', $line);

        [$names, $iconClass] = $this->extractIcomoonNames($previousLine);
        $value = $this->extractIcomoonValue($line);

        foreach ($names as $name)
        {
            $this->icomoonNames2Values [$name] = $value;
        }

        $concatenatedNames                           = implode(', ', $names);
        $this->icomoonIconNames [$concatenatedNames] = $iconClass;

    }

    private function extractIcomoonNames(string $namessLine): array
    {
        $names     = [];
        $iconClass = '';

        $lineTrimmed = trim(substr($namessLine, 0, -1));
        $ids         = explode(', ', $lineTrimmed);

        foreach ($ids as $id)
        {
            $name     = substr($id, 6);
            $names [] = $name;

            $iconClass = substr($id, 1);
        }

        return [$names, $iconClass];
    }

    private function extractIcomoonValue(string $line)
    {
        $value = substr($line, 5);;

        return $value;
    }
}
