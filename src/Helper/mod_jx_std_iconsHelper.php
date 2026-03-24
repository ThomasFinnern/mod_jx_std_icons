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

\defined('_JEXEC') or die;

/**
 * Collect lists of available Joomla!4 icons (standard template)
 *
 * - List of awesome icons retrieved from *.svg file(s)
 * - List of supported icons (previous icomoon) for internal style and
 *      html <span class="icon-image"> </span> from *.css file
 * - List of awesome icons which may be addressed like
 * html <i class="fa fa-adjust"></i> from *.css file
 * font awesome and internal icons may be referred to the same
 *      font awesome icon but different names may be used
 *
 * @since  version 0.1
 */
class mod_jx_std_iconsHelper
{
    /** in J!5 and J!6 iterate through lines for icons */
    private const string CSS_VENDOR_AWESOME_SCSS_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/scss/_variables.scss';

    /** Joomla used fontawesome icons with icomoon definitions (copy of fontawesome original icons + additions) */
    private const string CSS_JOOMLA_SYSTEM_PATH_FILE_NAME = JPATH_ROOT . '/media/system/css/joomla-fontawesome.css';

    /** fontawesome original icons  */
    private const string CSS_VENDOR_AWESOME_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/css/fontawesome.css';

    //--- joomla css css file ------------------------------------------

    public array $css_iconNames2Values = [];
    public array $css_standardIconNames = [];
    public array $css_brandIconNames = [];

    // font char values array from J! css file
    public array $css_iconValues2Names = [];

    // only in joomla...*.css file
    public string $awesome_version = '%unknown%';

    // only in joomla...*.css file
    // icomoon replacements
    public array $css_icomoonNames2Values = [];
    public array $css_icomoonIconNames = [];



    // ???
    // Css file vendor all fontawesome   -> use $scssIconValues instead
    // public array $css_vendor_awesome_icons = [];

    //--- scss file (_variables.scss) ------------------------------------------

    public array $scss_iconNames2Values = [];
    public array $scss_standardIconNames = [];
    public array $scss_brandIconNames = [];

    // font char values array from J! css file
    public array $scss_iconValues2Names = [];

    /**
     * Extract all public data from files on creation
     * if not prevented
     *
     * @param   bool  $watermarked
     *
     * @since version 0.1
     */
    public function __construct(bool $isExtractSvg = true, bool $isExtractCss = true)
    {

        // extract version, icons from *.css file
        if ($isExtractCss)
        {

            $this->extractAllIcons();
        }

    }

    /**
     * Extract all Icons by joomla CSS files
     *
     * @throws \Exception
     * @since version
     */
    public function extractAllIcons(): void
    {

        try
        {
            //--- Extract from Scss file ----------------------------------------------

//            [$this->scssIconValues, $this->scss_awesome_std_names, $this->scss_awesome_brand_names]
//                = $oExtract->extractScssIconFileData();
            //--- system icons / brand icons ----------------------------------------------

            // file: _variables.scss
            $oScssFile = new fontawesomeScssFile_v6 (self::CSS_VENDOR_AWESOME_SCSS_PATH_FILE_NAME);

            $oScssFile->readLines()->scanLines();

            $this->scss_iconNames2Values = $oScssFile->iconNames2Values;
            $this->scss_standardIconNames = $oScssFile->standardIconNames;
            $this->scss_brandIconNames = $oScssFile->brandIconNames;


            //--- Extract from Scss file ----------------------------------------------

            ////--- Extract Font awesome version ----------------------------------------------
            //$this->awesome_version = $oExtract->extractAwesomeVersion();
            ////--- icomoon replacements ----------------------------------------------
            //$this->css_icomoon_icons = $oExtract->extractIcomoonIcons();
            //[$this->css_joomla_system_icons, $this->css_joomla_system_brand_icons] = $oExtract->extractSystemAndBrandIcons();

            $oCssFile = new joomlaFontawesomeCssFile_j5x (self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME);

            $oCssFile->readLines()->scanLines();

            $this->css_iconNames2Values = $oCssFile->iconNames2Values;
            $this->css_standardIconNames = $oCssFile->standardIconNames;
            $this->css_brandIconNames = $oCssFile->brandIconNames;

            $this->awesome_version = $oCssFile->awesome_version;

            $this->css_icomoonNames2Values = $oCssFile->icomoonNames2Values;
            $this->css_icomoonIconNames = $oCssFile->icomoonIconNames;

        }
        catch (\RuntimeException $e)
        {
            $OutTxt = '';
            $OutTxt .= 'Error executing extractAllIcons: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return;
    }

} // class
