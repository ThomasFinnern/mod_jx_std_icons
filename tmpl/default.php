<?php
/**
 * @package     Joomla.site
 * @subpackage  mod_jx_std_icons
 *
 * @copyright   Copyright (C) 2023-2023 thomas finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

//use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

\defined('_JEXEC') or die;

global $j_css_icons;

//--- mod_jx_std_iconsHelper definitions to local definitions ----------------

//--- css file  ---------------------------------------------------------------

// extracted version
$awesome_version = $j_css_icons->awesome_version;

//$css_atum_template_icons = $j_css_icons->css_atum_template_icons;
$css_icomoonIconNames = $j_css_icons->css_icomoonIconNames;

$css_standardIconNames = $j_css_icons->css_standardIconNames;
$css_brandIconNames = $j_css_icons->css_brandIconNames;

//--- scss file  ---------------------------------------------------------------

$scss_standardIconNames = $j_css_icons->scss_standardIconNames;
$scss_brandIconNames = $j_css_icons->scss_brandIconNames;

//--- old definitions -------------------------------------------------------------

$css_standardIconNames = $j_css_icons->css_standardIconNames;

$scss_awesome_std_names        = $j_css_icons->scss_awesome_std_names;
$scss_awesome_brand_names      = $j_css_icons->scss_awesome_brand_names;
$css_joomla_system_brand_icons = $j_css_icons->css_joomla_system_brand_icons;

$css_vendor_awesome_icons = $j_css_icons->css_vendor_awesome_icons;
//$css_vendor_awesome_brand_names = $j_css_icons->css_vendor_awesome_brand_names;

$iconListByCharValue = $j_css_icons->iconListByCharValue;

$jx_version = $j_css_icons->jx_version;

// PUA Schriftzeichen

// load css
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('mod_jx_std_icons', 'mod_jx_std_icons/template.css');

//--- Flags for display yes/no ----------------------------------------------

$isDisplayTablesHeader = $params->get('isDisplayTablesHeader');
$isDisplayTechDetail   = $params->get('isDisplayTechDetail');

$isDisplayIcomoonTable = $params->get('isDisplayIcomoonTable');
$isDisplayJoomlaSysIconTable      = $params->get('isDisplayJoomlaSysIconTable');
//$isDisplayBrandIconsTable_Awesome = $params->get('isDisplayBrandIconsTable_Awesome');
//
//$isDisplayVendorAwesomeIconTable = $params->get('isDisplayVendorAwesomeIconTable');
//$isDisplayBrandNamesList         = $params->get('isDisplayBrandNamesList');
//
//$isDisplayIconListByCharValue = $params->get('isDisplayIconListByCharValue');


$font_size = $params->get('font_size');

// <!--style>
//    .icon {
//        width: 1em;
//        height: 1em;
//        vertical-align: -.125em;
//    }
//</style-->

?>

<div class="card">
    <div class="card-body">
        <?php if (empty($css_icomoonIconNames) && empty($css_standardIconNames) && empty($css_vendor_awesome_icons)): ?>
            <h3 class="card-title">
                <?php echo Text::_('MOD_JX_STD_ICONS_NO_ICONS'); ?>
            </h3>
            <h6 class="card-subtitle mb-2 text-muted">
                <?php echo Text::_('MOD_JX_STD_ICONS_NO_ICONS_DESC'); ?>
            </h6>

        <?php else: ?>

            <?php if ($isDisplayTablesHeader): ?>
                <h2 class="card-title"><?php echo Text::_('MOD_JX_STD_ICONS_AVAILABLE_ICONS'); ?></h2>
                <div class="mb-3">
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $awesome_version; ?></h6>
                </div>

                <?php if ($isDisplayTechDetail): ?>
                    <div class="mb-3">
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo Text::_('MOD_JX_STD_ICONS_AVAILABLE_ICONS_DESC'); ?></h6>
                    </div>

                <?php endif; ?>
            <?php endif; ?>

            <?php
            //=== icomoon replacements ========================================================================
            ?>
            <?php if ($isDisplayIcomoonTable): ?>
                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
                            <span class="icon-joomla" aria-hidden="true"></span>
                            <?php echo Text::_('MOD_JX_STD_ICONS_ICOMOON_ICONS'); ?>
                        </h2>
                    </div>

                    <div class="card-body">

                        <?php if ($isDisplayTechDetail): ?>
                            <div class="mb-3">
                                <div
                                    class="card-title"><?php echo Text::_('MOD_JX_STD_ICONS_ICOMOON_ICONS_DESC'); ?></div>
                            </div>
                        <?php endif; ?>

                        <nav class="quick-icons px-3 pb-3">
                            <ul class="nav flex-wrap">
                                <li class="quickicon quickicon-single">
                                    <a href="#">
                                        <div class="quickicon-info">
                                            <div class="quickicon-icon">
                                                <span class="icon-joomla"
                                                      style="font-size: <?php echo $font_size; ?>px;"
                                                      aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="quickicon-name d-flex align-items-end">
                                            Joomla
                                        </div>
                                    </a>
                                </li>

                                <?php foreach ($css_icomoonIconNames as $iconName => $iconClass): ?>
                                    <li class="quickicon quickicon-single">
                                        <a href="#">
                                            <div class="quickicon-info">

                                                <div class="quickicon-icon">
                                                    <i style="font-size: <?php echo $font_size; ?>px;"
                                                       class="<?php echo $iconClass; ?>"></i>
                                                </div>

                                            </div>
                                            <div class="quickicon-name d-flex align-items-end">
                                                <?php echo $iconName; ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                        <h5>Count icomoon icons: <span class="badge bg-secondary"><?php echo count($css_icomoonIconNames); ?></span></h5>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            //=== system joomla icons font awesome ========================================================================
            ?>

            <?php if ($isDisplayJoomlaSysIconTable): ?>
                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
                            <span class="icon-joomla" aria-hidden="true"></span>
                            <?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_ICON_TABLE'); ?>
                        </h2>
                    </div>
                    <div class="card-body">

                        <?php if ($isDisplayTechDetail): ?>
                            <div class="mb-3">
                                <div
                                    class="card-title"><?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_ICON_TABLE_DESC'); ?></div>
                            </div>
                        <?php endif; ?>

                        <nav class="quick-icons px-3 pb-3">
                            <ul class="nav flex-wrap">
                                <li class="quickicon quickicon-single">
                                    <a href="#">
                                        <div class="quickicon-info">
                                            <div class="quickicon-icon">
                                                <span class="icon-joomla"
                                                      style="font-size: <?php echo $font_size; ?>px;"
                                                      aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="quickicon-name d-flex align-items-end">
                                            Joomla
                                        </div>
                                    </a>
                                </li>

                                <?php foreach ($css_standardIconNames as $iconName => $iconClass): ?>
                                    <li class="quickicon quickicon-single">
                                        <a href="#">
                                            <div class="quickicon-info">

                                                <div class="quickicon-icon">
                                                    <i style="font-size: <?php echo $font_size; ?>px;"
                                                       class="fa fa-<?php echo $iconClass; ?>"></i>
                                                    <!-- 4x brands highlighted <i style="font-size: <?php echo $font_size; ?>px;" class="fab fa-<?php echo $systemIcon->iconId; ?>"></i>-->
                                                </div>

                                            </div>
                                            <div class="quickicon-name d-flex align-items-end">
                                                <?php echo $iconName; ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
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

<!--            --><?php //if ($isDisplayBrandIconsTable_Awesome): ?>
<!--                <div class="card mb-3 ">-->
<!--                    <div class="card-header">-->
<!--                        <h2>-->
<!--                            <span class="icon-joomla" aria-hidden="true"></span>-->
<!--                            --><?php //echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_TABLE'); ?>
<!--                        </h2>-->
<!--                    </div>-->
<!--                    <div class="card-body">-->
<!---->
<!--                        --><?php //if ($isDisplayTechDetail): ?>
<!--                            <div class="mb-3">-->
<!--                                <div class="card-title">-->
<!--                                    <div>-->
<!--                                        --><?php //echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_TABLE_DESC'); ?>
<!--                                    </div>-->
<!--                                    <div>-->
<!--                                        <a href="--><?php //echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_LINK'); ?><!--">--><?php //echo Text::_('MOD_JX_STD_ICONS_AWESOME_ICONS_LINK'); ?><!--</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        --><?php //endif; ?>
<!---->
<!--                        <nav class="quick-icons px-3 pb-3">-->
<!--                            <ul class="nav flex-wrap">-->
<!--                                <li class="quickicon quickicon-single">-->
<!--                                    <a href="#">-->
<!--                                        <div class="quickicon-info">-->
<!--                                            <div class="quickicon-icon">-->
<!--                                                <span class="icon-joomla"-->
<!--                                                      style="font-size: --><?php //echo $font_size; ?>/*px;"*/
/*                                                      aria-hidden="true"></span>*/
/*                                            </div>*/
/*                                        </div>*/
/*                                        <div class="quickicon-name d-flex align-items-end">*/
/*                                            Joomla*/
/*                                        </div>*/
/*                                    </a>*/
/*                                </li>*/
/**/
/*                                */<?php //foreach ($css_joomla_system_brand_icons as $brandIcon): ?>
<!--                                    <li class="quickicon quickicon-single">-->
<!--                                        <a href="#">-->
<!--                                            <div class="quickicon-info">-->
<!---->
<!--                                                <div class="quickicon-icon">-->
<!--                                                    <i style="font-size: --><?php //echo $font_size; ?>/*px;"*/
/*                                                       class="fab fa-*/<?php //echo $brandIcon->iconId; ?><!--"></i>-->
<!--                                                    <!-- 5x <i style="font-size: --><?php //echo $font_size; ?><!--px;" class="fa fa---><?php //echo $brandIcon->iconId; ?><!--"></i>-->-->
<!--                                                </div>-->
<!---->
<!--                                            </div>-->
<!--                                            <div class="quickicon-name d-flex align-items-end">-->
<!--                                                --><?php //echo $brandIcon->name; ?>
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                --><?php //endforeach; ?>
<!--                            </ul>-->
<!--                        </nav>-->
<!--                        <h5>Count J! CSS brand font awesonme icons: <span-->
<!--                                class="badge bg-secondary">--><?php //echo count($css_joomla_system_brand_icons); ?><!--</span>-->
<!--                        </h5>-->
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //endif; ?>

            <?php
            //=== vendor all fontawesome ========================================================================
            ?>

            <?php if ($isDisplayVendorAwesomeIconTable): ?>
                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
                            <span class="icon-joomla" aria-hidden="true"></span>
                            <?php echo Text::_('MOD_JX_STD_ICONS_AWESOME_ICONS'); ?>
                        </h2>
                    </div>
                    <div class="card-body">

                        <?php if ($isDisplayTechDetail): ?>
                            <div class="mb-3">
                                <div class="card-title">
                                    <div>
                                        <?php echo Text::_('MOD_JX_STD_ICONS_AWESOME_ICONS_DESC'); ?>
                                    </div>
                                    <div>
                                        <a href="<?php echo Text::_('MOD_JX_STD_ICONS_AWESOME_ICONS_LINK'); ?>"><?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_LINK'); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <nav class="quick-icons px-3 pb-3">
                            <ul class="nav flex-wrap">
                                <li class="quickicon quickicon-single">
                                    <a href="#">
                                        <div class="quickicon-info">
                                            <div class="quickicon-icon">
                                                <span class="icon-joomla"
                                                      style="font-size: <?php echo $font_size; ?>px;"
                                                      aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="quickicon-name d-flex align-items-end">
                                            Joomla
                                        </div>
                                    </a>
                                </li>

                                <?php foreach ($css_vendor_awesome_icons as $awesomeIcon): ?>
                                    <li class="quickicon quickicon-single">
                                        <a href="#">
                                            <div class="quickicon-info">

                                                <div class="quickicon-icon">
                                                    <?php if (version_compare($jx_version, '5', '<')): ?>
                                                        <?php // J4x ?>
                                                        <?php if (!in_array($awesomeIcon->iconId, $scss_awesome_brand_names)): ?>
                                                            <!-- not helping in 4x <i style="font-size: <?php echo $font_size; ?>px;" class="fa-solid fa-<?php echo $awesomeIcon->iconId; ?>"></i>-->
                                                            <i style="font-size: <?php echo $font_size; ?>px;"
                                                               class="fa fa-<?php echo $awesomeIcon->iconId; ?>"></i>
                                                            <!-- <i style="font-size: <?php echo $font_size; ?>px;" class="fas fa-<?php echo $awesomeIcon->iconId; ?>"></i>-->
                                                        <?php else: ?>
                                                            <i style="font-size: <?php echo $font_size; ?>px;"
                                                               class="fab fa-<?php echo $awesomeIcon->iconId; ?>"></i>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php // J5x ?>
                                                        <i style="font-size: <?php echo $font_size; ?>px;"
                                                           class="fa fa-<?php echo $awesomeIcon->iconId; ?>"></i>
                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                            <div class="quickicon-name d-flex align-items-end">
                                                <?php echo $awesomeIcon->name; ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                        <h5>Count Font Awesome standard icons: <span
                                class="badge bg-secondary"><?php echo count($css_vendor_awesome_icons); ?></span></h5>
                    </div>
                </div>
            <?php endif; ?>


            <?php
            //=== collected characters ========================================================================
            ?>


            <?php
            //=== isDisplayBrandNamesList ========================================================================
            ?>

            <?php if ($isDisplayBrandNamesList): ?>
                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
                            <span class="icon-joomla" aria-hidden="true"></span>
                            <?php echo Text::_('MOD_JX_STD_ICONS_SCSS_STD_NAMES_LIST'); ?>
                        </h2>
                    </div>
                    <div class="card-body">

                        <nav class="quick-icons px-3 pb-3">
                            <ol class="list-group .list-group-horizontal-sm">
                                <?php foreach ($scss_awesome_std_names as $standardName): ?>
                                    <?php // <li class="list-group-item"><?php echo $brandName; ? ></li> ?>
                                    <?php echo $standardName . ', '; ?>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                        <h5>Count Font Awesome SCSS standard names : <span
                                class="badge bg-secondary"><?php echo count($scss_awesome_std_names); ?></span></h5>

                    </div>

                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
                            <span class="icon-joomla" aria-hidden="true"></span>
                            <?php echo Text::_('MOD_JX_STD_ICONS_SCSS_BRAND_NAMES_LIST'); ?>
                        </h2>
                    </div>
                    <div class="card-body">

                        <nav class="quick-icons px-3 pb-3">
                            <ol class="list-group .list-group-horizontal-sm">
                                <?php foreach ($scss_awesome_brand_names as $standardName): ?>
                                    <?php // <li class="list-group-item"><?php echo $brandName; ? ></li> ?>
                                    <?php echo $standardName . ', '; ?>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                        <h5>Count Font Awesome SCSS brand names : <span
                                class="badge bg-secondary"><?php echo count($scss_awesome_brand_names); ?></span></h5>

                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
