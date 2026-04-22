<?php

/**
 * @package        Joomla.site
 * @subpackage     mod_jx_std_icons
 *
 * @copyright  (c) 2023-2026 Thomas Finnern
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') || die;
// phpcs:enable PSR1.Files.SideEffects

use Finnern\Module\mod_jx_std_icons\Site\Helper\Mod_jx_std_iconsHelper;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

/** @var $j_css_icons Mod_jx_std_iconsHelper; */
/** @var $params registry; */

//--- j! css file extracts ----------------------------------------------------

// extracted version
$awesome_version = $j_css_icons->awesome_version;

//$css_atum_template_icons = $j_css_icons->css_atum_template_icons;
$css_icomoonIconNames = $j_css_icons->css_icomoonIconNames;

$css_standardIconNames = $j_css_icons->css_standardIconNames;
$css_brandIconNames    = $j_css_icons->css_brandIconNames;

//--- scss file  ---------------------------------------------------------------

$scss_standardIconNames = $j_css_icons->scss_standardIconNames;
$scss_brandIconNames    = $j_css_icons->scss_brandIconNames;

//--- load css  ---------------------------------------------------------------

$wa = $this->app->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('mod_jx_std_icons', 'mod_jx_std_icons/template.css');

//--- Flags for display yes/no ----------------------------------------------

$isDisplayTablesHeader = $params->get('isDisplayTablesHeader');
$isDisplayTechDetail   = $params->get('isDisplayTechDetail');

$isDisplayIcomoonTable            = $params->get('isDisplayIcomoonTable');
$isDisplayJoomlaSysIconTable      = $params->get('isDisplayJoomlaSysIconTable');
$isDisplayBrandIconsTable_Awesome = $params->get('isDisplayBrandIconsTable_Awesome');

//--- Icon font size, text  ----------------------------------------------

$icon_font_size = $params->get('icon_font_size');
$name_font_size = $params->get('name_font_size');
$icon_color     = $params->get('icon_color');
$name_color     = $params->get('name_color');

$ulListStyle = 'style="list-style-type: none;" ';


?>

<style>
    .icon_li {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 2px;
    }

    .icon_style {
        font-size: <?php echo $icon_font_size; ?>;

        /*color: hsl(214, 30 %, 40 %);*/
        /*color: #0047AB;*/
        /*color: darkgrey;*/
        color: <?php echo $icon_color; ?>;

        width: 50px;
        text-align: center;
    }

    .icon_name_style {
        font-size: <?php echo $name_font_size; ?>;
        color: <?php echo $name_color; ?>;
        /*color: red;*/
        padding: 5px;
    }

</style>

<div class="card">
    <div class="card-body">
        <?php if (empty($css_icomoonIconNames) && empty($css_standardIconNames) && empty($css_vendor_awesome_icons)) : ?>
            <h3 class="card-title">
                <?php echo Text::_('MOD_JX_STD_ICONS_NO_ICONS'); ?>
            </h3>
            <h6 class="card-subtitle mb-2 text-muted">
                <?php echo Text::_('MOD_JX_STD_ICONS_NO_ICONS_DESC'); ?>
            </h6>

        <?php else : ?>
            <?php if ($isDisplayTablesHeader) : ?>
                <h2 class="card-title"><?php echo Text::_('MOD_JX_STD_ICONS_AVAILABLE_ICONS'); ?></h2>
                <div class="mb-3">
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $awesome_version; ?></h6>
                </div>

                <?php if ($isDisplayTechDetail) : ?>
                    <div class="mb-3">
                        <div
                                class="card-subtitle mb-2 text-muted"><?php echo Text::_('MOD_JX_STD_ICONS_AVAILABLE_ICONS_DESC'); ?></div>
                    </div>

                <?php endif; ?>
            <?php endif; ?>

            <?php
            //=== icomoon replacements ========================================================================
            ?>
            <?php if ($isDisplayIcomoonTable) : ?>
                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
                            <span class="icon-joomla" aria-hidden="true"></span>
                            <?php echo Text::_('MOD_JX_STD_ICONS_ICOMOON_ICONS'); ?>
                        </h2>
                    </div>

                    <div class="card-body">
                        <?php
                        if ($isDisplayTechDetail)
                        {
                            $this->displayTechDetail(Text::_('MOD_JX_STD_ICONS_ICOMOON_ICONS_DESC'), "");
                        }
                        ?>

                        <nav class=""> <!-- <nav class="quick-icons px-3 pb-3">-->
                            <ul <?php echo $ulListStyle; ?> class="">

                                <?php
                                foreach ($css_icomoonIconNames as $iconName => $iconClass)
                                {
                                    $this->displayIcon($iconName, $iconClass, $icon_font_size, $name_font_size);
                                }
                                ?>
                            </ul>
                        </nav>
                        <h5>Count icomoon icons: <span
                                    class="badge bg-secondary"><?php echo count($css_icomoonIconNames); ?></span></h5>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            //=== system joomla icons font awesome ========================================================================
            ?>

            <?php if ($isDisplayJoomlaSysIconTable) : ?>
                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
                            <!--                            <span class="icon-joomla" aria-hidden="true"></span>-->
                            <?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_ICON_TABLE'); ?>
                        </h2>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($isDisplayTechDetail)
                        {
                            $this->displayTechDetail(Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_ICON_TABLE_DESC'), Text::_('MOD_JX_STD_ICONS_AWESOME_ICONS_LINK'));
                        }
                        ?>

                        <nav class=""> <!-- <nav class="quick-icons px-3 pb-3">-->
                            <ul <?php echo $ulListStyle; ?> class="">
                                <?php
                                foreach ($css_standardIconNames as $iconName => $iconClass)
                                {
                                    $this->displayIcon($iconName, $iconClass, $icon_font_size, $name_font_size);
                                }
                                ?>
                            </ul>
                        </nav>
                        <h5>Count J! CSS standard font awesonme icons: <span
                                    class="badge bg-secondary"><?php echo count($css_standardIconNames); ?></span></h5>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            //=== system joomla brand icons ========================================================================
            ?>

            <?php if ($isDisplayBrandIconsTable_Awesome) : ?>
                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
                            <!--                            <span class="icon-joomla" aria-hidden="true"></span>-->
                            <?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_TABLE'); ?>
                        </h2>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($isDisplayTechDetail)
                        {
                            $this->displayTechDetail(Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_TABLE_DESC'), Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_LINK'));
                        }
                        ?>

                        <nav class=""> <!-- <nav class="quick-icons px-3 pb-3">-->
                            <ul <?php echo $ulListStyle; ?> class="">
                                <?php
                                foreach ($css_brandIconNames as $iconName => $iconClass)
                                {
                                    $this->displayIcon($iconName, $iconClass, $icon_font_size, $name_font_size);
                                }
                                ?>
                            </ul>
                        </nav>
                        <h5>Count J! CSS brand font awesonme icons: <span
                                    class="badge bg-secondary"><?php echo count($css_brandIconNames); ?></span>
                        </h5>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>

