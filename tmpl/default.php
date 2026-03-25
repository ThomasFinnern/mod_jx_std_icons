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

// font awesome are PUA UTF-8 characters

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

//--- load css  ---------------------------------------------------------------

$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('mod_jx_std_icons', 'mod_jx_std_icons/template.css');

//--- Flags for display yes/no ----------------------------------------------

$isDisplayTablesHeader = $params->get('isDisplayTablesHeader');
$isDisplayTechDetail   = $params->get('isDisplayTechDetail');

$isDisplayIcomoonTable = $params->get('isDisplayIcomoonTable');
$isDisplayJoomlaSysIconTable      = $params->get('isDisplayJoomlaSysIconTable');
$isDisplayBrandIconsTable_Awesome = $params->get('isDisplayBrandIconsTable_Awesome');


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
                        <div class="card-subtitle mb-2 text-muted"><?php echo Text::_('MOD_JX_STD_ICONS_AVAILABLE_ICONS_DESC'); ?></div>
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
<!--                            <span class="icon-joomla" aria-hidden="true"></span>-->
                            <?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_ICON_TABLE'); ?>
                        </h2>
                    </div>
                    <div class="card-body">

                        <?php if ($isDisplayTechDetail): ?>
                            <div class="mb-3">
                                <div class="card-title">
                                <div
                                    class="card-title"><?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_ICON_TABLE_DESC'); ?></div>
                                </div>
                                <div>
                                    <a href="<?php echo Text::_('MOD_JX_STD_ICONS_AWESOME_ICONS_LINK'); ?>">
                                        <?php echo Text::_('MOD_JX_STD_ICONS_AWESOME_ICONS_LINK'); ?></a>
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

                                <?php foreach ($css_standardIconNames as $iconName => $iconClass): ?>
                                    <li class="quickicon quickicon-single">
                                        <a href="#">
                                            <div class="quickicon-icon">
                                                <i style="font-size: <?php echo $font_size; ?>px;"
                                                   class="fa <?php echo $iconClass; ?>"></i>
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

            <?php if ($isDisplayBrandIconsTable_Awesome): ?>
                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
<!--                            <span class="icon-joomla" aria-hidden="true"></span>-->
                            <?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_TABLE'); ?>
                        </h2>
                    </div>
                    <div class="card-body">

                        <?php if ($isDisplayTechDetail): ?>
                            <div class="mb-3">
                                <div class="card-title">
                                    <div>
                                        <?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_TABLE_DESC'); ?>
                                    </div>
                                    <div>
                                        <a href="<?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_LINK'); ?>">
                                            <?php echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_LINK'); ?></a>
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
                                                      style="font-size: <?php echo $font_size; ?>/*px;"
                                                      aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="quickicon-name d-flex align-items-end">
                                            Joomla
                                        </div>
                                    </a>
                                </li>

                                <?php foreach ($css_brandIconNames as $iconName => $iconClass): ?>
                                    <li class="quickicon quickicon-single">
                                        <a href="#">
                                            <div class="quickicon-icon">
                                                <i style="font-size: <?php echo $font_size; ?>px;"
                                                    class="fab <?php echo $iconClass; ?>"></i>
                                            </div>
                                            <div class="quickicon-name d-flex align-items-end">
                                                <?php echo $iconName; ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
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
