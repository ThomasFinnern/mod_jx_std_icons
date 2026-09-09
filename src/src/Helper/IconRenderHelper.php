<?php

/**
 * @package        Joomla.Module
 * @subpackage     mod_jx_std_icons
 * @author         Thomas Finnern <InsideTheMachine.de>
 * @copyright  (c) 2019-2026 Thomas Finnern
 * @license        GNU General Public License version 2 or later
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
        <li class="icon_li_row">
            <i class="<?php echo $iconClass; ?> icon_style_row icon_user_style" tabindex="0"></i>
            <div class="icon_style_name_row icon_name_user_style"><?php echo $iconName; ?></div>
        </li>
        <?php
    }

    public static function displayColumnIcon($iconName, $iconClass)
    {
        ?>
        <li class="icon_li_col">
            <i class="<?php echo $iconClass; ?> icon_style_col icon_user_style" tabindex="0"></i>
            <span class="icon_style_name_col icon_name_user_style"><?php echo $iconName; ?></span>
        </li>
        <?php
    }

}
