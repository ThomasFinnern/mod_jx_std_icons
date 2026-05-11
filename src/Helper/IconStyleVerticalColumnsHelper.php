<?php

/**
 * @package     Finnern\Module\Jx_std_icons\Site\Helper
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
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

        //--- icon list style  --------------------------------------

        // display: flex;
        //flex-direction: row;
        //align-items: center;
        //padding: 2px;

        $iconsCssStyleText .= <<<END
            ul {
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
            .icon_style {
                font-size: {$icon_font_size};
                color: {$icon_color};
            
                width: 50px;
                text-align: left;
            }
            END;

        //--- icon name style ------------------------------------------------

        // padding: 5 px;
        // color: red;
        $iconsCssStyleText .= <<<END
            .icon_style_name_col {
                font-size: {$name_font_size};
                color: {$name_color};
                padding: 5px;
            }
            END;

        return $iconsCssStyleText;
    }

}
