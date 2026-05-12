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
        $icon_dark_color = $params->get('icon_dark_color');
        $name_dark_color = $params->get('name_dark_color');

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
            .icon_li_col .icon_style_icon {
                font-size: {$icon_font_size};
                color: {$icon_color};
            }
            
            END;

        //--- icon name style ------------------------------------------------

        // padding: 5 px;
        // color: red;
        $iconsCssStyleText .= <<<END
            .icon_style_name_col {
                font-size: {$name_font_size};
                color: {$name_color};
            }
            
            END;

        //--- Dark mode  --------------------------------------

        $iconsCssStyleText .= <<<END
            @media (prefers-color-scheme: dark) {
            
                .icon_li_col .icon_style_icon {
                    color: {$icon_dark_color};
                }
                .icon_style_name_col {
                    color: {$name_dark_color};
                }            
            }
                            
            END;

        //return ".test {}";
        return $iconsCssStyleText;
    }

}
