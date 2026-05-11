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

    public static function displayIcon_asQuickicon($iconName, $iconClass, $icon_font_size, $name_font_size)
    {
        ?>
        <li class="icon_li quickicon quickicon-single">
            <a href="#" class="quickicon-link">
                <div class="quickicon-info">
                    <div class="quickicon-icon">
                        <i class="<?php
                        echo $iconClass; ?> icon_style_tmpl icon_style" tabindex="0"></i>
                    </div>
                </div>
                <div class="quickicon-name hidden_name icon_name_style">
                    <?php
                    echo $iconName; ?>
                </div>
            </a>
        </li>
        <?php
    }

    public static function displayIcon($iconName, $iconClass, $icon_font_size, $name_font_size)
    {
        ?>
        <li class="icon_li_tmpl icon_li">
            <i class="<?php
            echo $iconClass; ?> icon_style_tmpl icon_style" tabindex="0"></i>
            <span class="icon_name_style_tmpl icon_name_style">
            <?php
            echo $iconName; ?>
        </span>
        </li>
        <?php
    }


    public static function iconsCssStyleText($params)
    {
        $iconsCssStyleText = '';

        $icon_font_size = $params->get('icon_font_size');
        $name_font_size = $params->get('name_font_size');
        $icon_color     = $params->get('icon_color');
        $name_color     = $params->get('name_color');

        //--- list style not used actually --------------------------------------

        // display: flex;
        //flex-direction: row;
        //align-items: center;
        //padding: 2px;

//        $iconsCssStyleText .= <<<END
//            .icon_li {
//            }
//            END;

        //--- icon style ---------------------------------------

        // color: hsl(214, 30 %, 40 %);
        // color: #0047AB;
        // color: darkgrey;
        // width: 50 px;
        // text-align: center;
        $iconsCssStyleText .= <<<END
            .icon_style {
                font-size: <?php echo $icon_font_size; ?>;
            
                color: <?php echo $icon_color; ?>;
            }
            END;

        //--- icon name style ------------------------------------------------

        // padding: 5 px;
        $iconsCssStyleText .= <<<END
            .icon_name_style {
                font-size: <?php echo $name_font_size; ?>;
                color: <?php echo $name_color; ?>;
            }
            END;

        return $iconsCssStyleText;
    }

}
