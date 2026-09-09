<?php

/**
 * @package        Joomla.Module
 * @subpackage     mod_jx_std_icons
 * @author         Thomas Finnern <InsideTheMachine.de>
 * @copyright  (c) 2019-2026 Thomas Finnern
 * @license        GNU General Public License version 2 or later
 */

namespace Finnern\Module\Jx_std_icons\Site\Helper;

class IconStyleVerticalColumnsHelper
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

        //--- icon list style  --------------------------------------

        // display: flex;
        //flex-direction: row;
        //align-items: center;
        //padding: 2px;

        $iconsCssStyleText .= <<<END
            .jx-std-icons-outer ul {
                columns: 250px;
            }
            
            END;

//        // display: flex;
//        //flex-direction: row;
//        //align-items: center;
//        //padding: 2px;
//        $iconsCssStyleText .= <<<END
//            .icon_li_col {
//            }
//            END;

        //--- icon style ---------------------------------------

        // color: hsl(214, 30 %, 40 %);
        // color: #0047AB;
        // color: darkgrey;
        // width: 50 px;
        // text-align: center;
        $iconsCssStyleText .= <<<END
            .icon_li_col .icon_user_style {
                font-size: {$icon_font_size};
                color: {$icon_color};
            }
            
            END;

        //--- icon name style ------------------------------------------------

        // padding: 5 px;
        // color: red;
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

        //return ".test {}";
        return $iconsCssStyleText;
    }

}
