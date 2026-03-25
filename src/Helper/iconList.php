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

abstract class iconList
{
    /** list [name] = value */
    public array $iconNames2Values = [];

    /** list [value] = [name1, name2, ..] */
    public array $iconValues2Names = [];

    /* list [name1, name2, ...] = class id */
    public array $standardIconNames = [];
    /* list [name1, name2, ...] = class id */
    public array $brandIconNames = [];


    // ToDo: PHP 8.4 getter/ setter hooks  get => {'mailto:' . $this->email}};
//    public array $standardNames = [];
//    public array $brandNames = [];

    public string $iconFile = '';

    public array $lines = [];

    public function __construct(string $iconFile = '')
    {
        if ($iconFile != '')
        {
            $this->iconFile = $iconFile;
//            $this->readLines($iconFile);
        }
    }

    public function init()
    {
        $this->lines              = [];

        $this->iconNames2Values = [];
        $this->iconValues2Names = [];
        $this->standardIconNames = [];
        $this->brandIconNames = [];

        return $this;
    }

    public function readLines(string $iconFile = '')
    {
        // reset icons, file name
        $this->init();

        if ($iconFile != '')
        {
            $this->iconFile = $iconFile;
        }
        $iconFile = $this->iconFile;

        try
        {
            // Is not a file
            if (!is_file($iconFile))
            {
                //--- path does not exist -------------------------------

                $OutTxt = 'Warning: iconList: File does not exist "' . $iconFile . '"<br>';

                $app = Factory::getApplication();
                $app->enqueueMessage($OutTxt, 'warning');
            }
            else
            {
                //--- read all lines ----------------------------------------------------

                $this->lines = file($this->iconFile);
            }
        }
        catch (\RuntimeException $e)
        {
            $OutTxt = '';
            $OutTxt .= 'Error executing iconList.readLines: "' . '<br>';
            $OutTxt .= 'File: "' . $iconFile . '"<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        // return count ($this->lines) > 0;
        return $this;
    }

    /**
     *
     * Actually sort of kwy value lists are ignored
     *
     * @return void
     */
    public function sortLists () {

//        ksort($this->iconNames2Values);
//        ksort($this->iconValues2Names);

        ksort($this->standardIconNames);
        ksort($this->brandIconNames);

    }

    abstract public function scanLines(array $lines = []);

}
