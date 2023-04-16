<?php
/**
 * @package     Joomla.site
 * @subpackage  mod_j4_std_icons
 *
 * @copyright   Copyright (C) 2023 - 2023 thomas finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

\defined('_JEXEC') or die;

global $test;
global $icons;

?>
		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'defaulticons', Text::_('COM_ADMIN_AVAILABLE_ICONS')); ?>
		<?php // echo $this->loadTemplate('defaulticons'); ?>


echo '[J!4 Standard Icons] ' . $test . '<br />'; // . $url;



<?php

if (empty($icons)) {

    return;
}

foreach ($icons as $iconName => $iconSet) {

    $iconFa = false;
    $iconJ  = false;

    $icon1 = $iconSet [0];
    $icon2 = false;

//    if (!empty ($icon1)) {
//        if ($icon1->iconType == '.icon') {
//
//            $iconJ = ;
//        } else {
//
//
//        }
//    }


	if (str_contains ($iconName, 'images')) {

		$test = $iconName;

	}


//    $classes[$icon1->iconType] = $icon1->iconId;



    $count = count($iconSet);
    if ($count > 1)
    {
        $icon2 = $iconSet [1];
    }


?>


					<li class="quickicon quickicon-single">
						<a href="#">
							<div class="quickicon-info">
								<div class="quickicon-icon">
									<hr>
                                    <?php if ($iconSet[0]->iconType == '.icon') { ?>
    									<i style="font-size: 48px;" class="icon-<?php echo $iconSet[0]->name; ?>"></i>
                                    <?php } else { ?>
                                        <i style="font-size: 48px;" class="fa fa-<?php echo $iconSet[0]->name; ?>"></i>
                                    <?php } ?>
<!--									<i style="font-size: 48px;" class="--><?php //echo 'fa ' . $iconSet[0]->iconId; ?><!--"></i>-->
								</div>
							</div>
							<div class="quickicon-name d-flex align-items-end">

<!--								--><?php //echo $iconSet[0]->iconId; ?>
								<?php echo $iconSet[0]->name; ?>

							</div>
						</a>
					</li>





<?php } ?>


<?php echo HTMLHelper::_('uitab.endTab'); ?>

