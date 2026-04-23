<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_jx_std_icons
 *
 * @copyright  (c) 2023-2026 Thomas Finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Finnern\Module\Mod_jx_std_icons\Site\Helper;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') || die;
// phpcs:enable PSR1.Files.SideEffects


/**
 * Collect lists of available Joomla!5/6 icons
 * from *.css and *.scss files
 *
 * @since  version 0.1
 */
class Mod_jx_std_iconsHelper
{

//	use ProviderManagerHelperTrait;

    /** *.scss file: iterate through lines and extract icons and brand icons */
    private const string CSS_VENDOR_AWESOME_SCSS_PATH_FILE_NAME = JPATH_ROOT . '/media/vendor/fontawesome-free/scss/_variables.scss';

    /** *.css file: iterate through lines and extract icomoon icons, icons and brand icons */
    private const string CSS_JOOMLA_SYSTEM_PATH_FILE_NAME = JPATH_ROOT . '/media/system/css/joomla-fontawesome.css';

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
    public function __construct(bool $isExtractCss = true)
    {

        // extract version, icons from *.css file
        if ($isExtractCss) {
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

        try {
            //--- Extract from Scss file ----------------------------------------------

            //--- system icons / brand icons ----------------------------------------------

            // file: _variables.scss
            $oScssFile = new FontawesomeScssFile_v6(self::CSS_VENDOR_AWESOME_SCSS_PATH_FILE_NAME);

            $oScssFile->readLines()->scanLines();

            $this->scss_iconNames2Values = $oScssFile->iconNames2Values;
            $this->scss_standardIconNames = $oScssFile->standardIconNames;
            $this->scss_brandIconNames = $oScssFile->brandIconNames;

            //--- Extract from css file ----------------------------------------------

            $oCssFile = new JoomlaFontawesomeCssFile_j5X(self::CSS_JOOMLA_SYSTEM_PATH_FILE_NAME);

            $oCssFile->readLines()->scanLines();

            $this->css_iconNames2Values = $oCssFile->iconNames2Values;
            $this->css_standardIconNames = $oCssFile->standardIconNames;
            $this->css_brandIconNames = $oCssFile->brandIconNames;

            $this->awesome_version = $oCssFile->awesome_version;

            $this->css_icomoonNames2Values = $oCssFile->icomoonNames2Values;
            $this->css_icomoonIconNames = $oCssFile->icomoonIconNames;
        } catch (\RuntimeException $e) {
            $OutTxt = '';
            $OutTxt .= 'Error executing extractAllIcons: "' . '<br>';
            $OutTxt .= 'Error: "' . $e->getMessage() . '"' . '<br>';

            $app = Factory::getApplication();
            $app->enqueueMessage($OutTxt, 'error');
        }

        return;
    }
}
