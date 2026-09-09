<?php

/**
 * @package        Joomla.Module
 * @subpackage     mod_jx_std_icons
 * @author         Thomas Finnern <InsideTheMachine.de>
 * @copyright  (c) 2019-2026 Thomas Finnern
 * @license        GNU General Public License version 2 or later
 */

namespace Finnern\Module\Jx_std_icons\Site\Helper;

class IconStyleDefaultHelper
{
    public static function iconsCssStyleText($params)
    {
        $iconsCssStyleText = '';

        $icon_font_size  = $params->get('icon_font_size');
        $name_font_size  = $params->get('name_font_size');
        $icon_color      = $params->get('icon_color');
        $name_color      = $params->get('name_color');
        $icon_dark_color = $params->get('icon_dark_color');
        $name_dark_color = $params->get('name_dark_color');

        //--- icon style ---------------------------------------

        $iconsCssStyleText .= <<<END
            .icon_li_row .icon_user_style {
                font-size: {$icon_font_size};           
                color: {$icon_color};
            }
            
            END;

        //--- icon name style ------------------------------------------------

        // padding: 5 px;
        $iconsCssStyleText .= <<<END
            .icon_style_name_row {
                font-size: {$name_font_size};
                color: {$name_color};
            }
            
            END;

        //--- Dark mode  --------------------------------------

        $iconsCssStyleText .= <<<END
            @media (prefers-color-scheme: dark) {
            
                .jx-std-icon-icon .icon_user_style {
                    color: {$icon_dark_color};
                }
                .icon_style_name_row {
                    color: {$name_dark_color};
                }            
            }
                            
            END;

        return $iconsCssStyleText;
    }
}
