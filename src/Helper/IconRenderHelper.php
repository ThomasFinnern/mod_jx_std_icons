<?php

/**
 * @package     Finnern\Module\Jx_std_icons\Site\Helper
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace Finnern\Module\Jx_std_icons\Site\Helper;

class IconRenderHelper
{
    public static function displayTechDetail($description, $link)
    {
        ?>
        <div class="mb-3">
            <div class="card-title">
                <div>
                    <?php
                    echo $description ?>
                </div>
                <?php
                if (!empty($link)) :
                    ?>
                    <div>
                        <a href="<?php
                        echo $link ?>"><?php
                            echo $link ?></a>
                    </div>
                <?php
                endif; ?>
            </div>

        </div>
        <?php
    }

    public static function displayRowIcon($iconName, $iconClass)
    {
        ?>
        <li class="icon_li_row jx-std-icon-single">
            <a>
                <div class="jx-std-icon-info">
                    <div class="jx-std-icon-icon">
                        <i class="<?php
                        echo $iconClass; ?> icon_style_row icon_style" tabindex="0"></i>
                    </div>
                </div>
                <div class="icon_style_name_row icon_name_style">
                    <?php
                    echo $iconName; ?>
                </div>
            </a>
        </li>
        <?php
    }

    public static function displayColumnIcon($iconName, $iconClass)
    {
        ?>
        <li class="icon_li_col">
            <i class="<?php
            echo $iconClass; ?> icon_style_col icon_style" tabindex="0"></i>
            <span class="icon_style_name_col icon_name_style">
            <?php
                echo $iconName; ?>
            </span>
        </li>
        <?php
    }

}
