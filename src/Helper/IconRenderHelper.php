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
                    <?php echo $description ?>
               </div>
                <?php if (!empty($link)) :
                    ?>
                   <div>
                        <a href="<?php echo $link ?>"><?php echo $link ?></a>
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
                        <i class="<?php echo $iconClass; ?> icon_style_tmpl icon_style" tabindex="0"></i>
                 </div>
             </div>
             <div class="quickicon-name hidden_name icon_name_style">
                    <?php echo $iconName; ?>
              </div>
         </a>
       </li>
        <?php
    }

    public static function displayIcon($iconName, $iconClass, $icon_font_size, $name_font_size)
    {
        ?>
       <li class="icon_li_tmpl icon_li" >
            <i class="<?php echo $iconClass; ?> icon_style_tmpl icon_style" tabindex="0"></i>
           <span class="icon_name_style_tmpl icon_name_style">
            <?php echo $iconName; ?>
        </span>
       </li>
        <?php
    }
}
