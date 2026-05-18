<?php

/**
 * @package        Joomla.site
 * @subpackage     mod_jx_std_icons
 *
 * @copyright  (c) 2023-2026 Thomas Finnern
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

use Finnern\Module\Jx_std_icons\Site\Helper\IconRenderHelper;
use Finnern\Module\Jx_std_icons\Site\Helper\IconStyleVertical1ColumnHelper;
use Finnern\Module\Jx_std_icons\Site\Helper\Mod_jx_std_iconsHelper;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') || die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * @var Mod_jx_std_iconsHelper     $j_css_icons;
 * @var Registry                   $params
 * @var CMSWebApplicationInterface $app
 */

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

$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('mod_jx_std_icons', 'mod_jx_std_icons/template.css');

// User input icon definition
$iconsCssStyleText = IconStyleVertical1ColumnHelper::iconsCssStyleText($params);
$app->getDocument()->getWebAssetManager()->addInlineStyle($iconsCssStyleText);

// User css definition
if ($content = $params->get('custom_css', '')) {
    $app->getDocument()->getWebAssetManager()->addInlineStyle($content);
}

//--- Flags for display yes/no ----------------------------------------------

$isDisplayTablesHeader = $params->get('isDisplayTablesHeader');
$isDisplayTechDetail   = $params->get('isDisplayTechDetail');

$isDisplayIcomoonTable            = $params->get('isDisplayIcomoonTable');
$isDisplayJoomlaSysIconTable      = $params->get('isDisplayJoomlaSysIconTable');
$isDisplayBrandIconsTable_Awesome = $params->get('isDisplayBrandIconsTable_Awesome');

$ulListStyle = ''; //'style="list-style-type: none;" ';
?>

<?php
if (empty($css_icomoonIconNames) && empty($css_standardIconNames) && empty($css_vendor_awesome_icons)) : ?>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">
                <?php
                echo Text::_('MOD_JX_STD_ICONS_NO_ICONS'); ?>
            </h3>
            <h6 class="card-subtitle mb-2 text-muted">
                <?php
                echo Text::_('MOD_JX_STD_ICONS_NO_ICONS_DESC'); ?>
            </h6>
        </div>
    </div>
<?php
else : ?>
    <?php
    if ($isDisplayTablesHeader) : ?>
        <h2 class="card-title"><?php
            echo Text::_('MOD_JX_STD_ICONS_AVAILABLE_ICONS'); ?></h2>
        <div class="mb-3">
            <h6 class="card-subtitle mb-2 text-muted"><?php
                echo $awesome_version; ?></h6>
        </div>

        <?php
        if ($isDisplayTechDetail) : ?>
            <div class="mb-3">
                <div
                        class="card-subtitle mb-2 text-muted"><?php
                    echo Text::_('MOD_JX_STD_ICONS_AVAILABLE_ICONS_DESC'); ?></div>
            </div>

        <?php
        endif; ?>
    <?php
    endif; ?>

    <?php
    //=== joomla font awesome standard icons ========================================================================
    ?>

    <?php
    if ($isDisplayJoomlaSysIconTable) : ?>
        <div class="card mb-3 ">
            <div class="card-header">
                <h2>
                    <?php
                    echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_ICON_TABLE'); ?>
                </h2>
            </div>
            <div class="card-body icons_card_area">
                <?php
                if ($isDisplayTechDetail) {
                    IconRenderHelper::displayTechDetail(
                            Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_ICON_TABLE_DESC'),
                            Text::_('MOD_JX_STD_ICONS_AWESOME_ICONS_LINK'),
                    );
                }
                ?>

                <nav class="jx-std-icons-outer"> <!-- <nav class="jx-std-icons-outer px-3 pb-3">-->
                    <ul class="ul_icons_outer_col">
                        <?php
                        foreach ($css_standardIconNames as $iconName => $iconClass) {
                            IconRenderHelper::displayColumnIcon($iconName, $iconClass);
                        }
                        ?>
                    </ul>
                </nav>
                <h5><?php
                    echo Text::_('MOD_JX_STD_ICONS_COUNT_FONTAWESOME_STANDARD_ICONS'); ?><span
                            class="badge bg-secondary"><?php
                        echo count($css_standardIconNames); ?></span></h5>
            </div>
        </div>
    <?php
    endif; ?>

    <?php
    //=== joomla font awesome brand icons ========================================================================
    ?>

    <?php
    if ($isDisplayBrandIconsTable_Awesome) : ?>
        <div class="card mb-3 ">
            <div class="card-header">
                <h2>
                    <?php
                    echo Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_TABLE'); ?>
                </h2>
            </div>
            <div class="card-body icons_card_area">
                <?php
                if ($isDisplayTechDetail) {
                    IconRenderHelper::displayTechDetail(
                            Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_TABLE_DESC'),
                            Text::_('MOD_JX_STD_ICONS_JOOMLA_SYSTEM_BRANDS_ICON_LINK'),
                    );
                }
                ?>

                <nav class="jx-std-icons-outer"> <!-- <nav class="jx-std-icons-outer px-3 pb-3">-->
                    <ul class="ul_icons_outer_col">
                        <?php
                        foreach ($css_brandIconNames as $iconName => $iconClass) {
                            IconRenderHelper::displayColumnIcon($iconName, $iconClass);
                        }
                        ?>
                    </ul>
                </nav>
                <h5><?php
                    echo Text::_('MOD_JX_STD_ICONS_COUNT_FONTAWESOME_BRAND_ICONS'); ?><span
                            class="badge bg-secondary"><?php
                        echo count($css_brandIconNames); ?></span>
                </h5>
            </div>
        </div>
    <?php
    endif; ?>

    <?php
    //=== icomoon replacement icons ========================================================================
    ?>
    <?php
    if ($isDisplayIcomoonTable) : ?>
        <div class="card mb-3 ">
            <div class="card-header">
                <h2>
                    <?php
                    echo Text::_('MOD_JX_STD_ICONS_ICOMOON_ICONS'); ?>
                </h2>
            </div>

            <div class="card-body icons_card_area">
                <?php
                if ($isDisplayTechDetail) {
                    IconRenderHelper::displayTechDetail(Text::_('MOD_JX_STD_ICONS_ICOMOON_ICONS_DESC'), "");
                }
                ?>

                <nav class="jx-std-icons-outer"> <!-- <nav class="jx-std-icons-outer px-3 pb-3">-->
                    <ul class="ul_icons_outer_col">
                        <?php
                        foreach ($css_icomoonIconNames as $iconName => $iconClass) {
                            IconRenderHelper::displayColumnIcon($iconName, $iconClass);
                        }
                        ?>
                    </ul>
                </nav>
                <h5><?php
                    echo Text::_('MOD_JX_STD_ICONS_COUNT_ICOMOON_ICONS'); ?><span
                            class="badge bg-secondary"><?php
                        echo count($css_icomoonIconNames); ?></span></h5>
            </div>
        </div>
    <?php
    endif; ?>

<?php
endif; ?>
