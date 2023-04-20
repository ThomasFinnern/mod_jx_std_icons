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

global $test, $icons, $defaultIcons;


HTMLHelper::_('stylesheet', 'mod_j4_standard_icons/css/template.css', array('version' => 'auto', 'relative' => true));
//$wa = $app->getDocument()->getWebAssetManager();
//$wa->registerAndUseStyle('mod_j4_standard_icons', 'mod_j4_standard_icons/template.css');

// $app->getDocument()->getWebAssetManager()
	// ->useScript('core')
	// ->useScript('keepalive')
	// ->useScript('field.passwordview');

// $wa->registerAndUseStyle('mod_languages', 'mod_languages/template.css');

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

<div class="card mb-3 ">
	<div class="card-header">
		<h2>
			<span class="icon-joomla" aria-hidden="true"></span>
			<?php echo Text::_('COM_ADMIN_AVAILABLE_ICONS'); ?>
		</h2>
	</div>
	<div class="card-body">
		<nav class="quick-icons px-3 pb-3">
			<ul class="nav flex-wrap">
				<li class="quickicon quickicon-single">
					<a href="#">
						<div class="quickicon-info">
							<div class="quickicon-icon">
								<span class="icon-joomla" style="font-size: 48px;" aria-hidden="true"></span>
							</div>
						</div>
						<div class="quickicon-name d-flex align-items-end">
							Joomla
						</div>
					</a>
				</li>

				<?php foreach ($defaultIcons as $item): ?>
					<li class="quickicon quickicon-single">
						<a href="#">
							<div class="quickicon-info">
								<div class="quickicon-icon">
									<i style="font-size: 48px;" class="fa fa-<?php echo $item; ?>"></i>

								</div>
							</div>
							<div class="quickicon-name d-flex align-items-end">
								<?php echo $item; ?>
							</div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>
</div>

<?php echo HTMLHelper::_('uitab.endTab'); ?>

