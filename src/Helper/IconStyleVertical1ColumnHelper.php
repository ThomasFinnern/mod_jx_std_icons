<?php

/**
 * @package     Finnern\Module\Jx_std_icons\Site\Helper
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace Finnern\Module\Jx_std_icons\Site\Helper;

class IconStyleVertical1ColumnHelper
{
    public static function iconsCssStyleText($params)
    {
        $iconsCssStyleText = '';

        $icon_font_size = $params->get('icon_font_size');
        $name_font_size = $params->get('name_font_size');
        $icon_color     = $params->get('icon_color');
        $name_color     = $params->get('name_color');
        $icon_dark_color = $params->get('icon_dark_color');
        $name_dark_color = $params->get('name_dark_color');

        //--- icon style ---------------------------------------

        $iconsCssStyleText .= <<<END
            .icon_li_col .icon_user_style {
                font-size: {$icon_font_size};
                color: {$icon_color};
            }
            
            END;

        //--- icon name style ------------------------------------------------

        // padding: 5 px;
        $iconsCssStyleText .= <<<END
            icon_li_col .icon_name_user_style {
                font-size: {$name_font_size};
                color: {$name_color};
            }
            
            END;

        //--- Dark mode  --------------------------------------

        $iconsCssStyleText .= <<<END
            @media (prefers-color-scheme: dark) {
            
                .icon_li_col .icon_user_style {
                    color: {$icon_dark_color};
                }
                icon_li_col .icon_name_user_style {
                    color: {$name_dark_color};
                }            
            }
                            
            END;

        return $iconsCssStyleText;
    }
}
