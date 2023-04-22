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

global $version, $icons, $defaultIcons;

// load
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('mod_j4_std_icons', 'mod_j4_std_icons/template.css');

?>

<?php

if (empty($icons)) {

    return;
}

$icomoons = [];

foreach ($icons as $iconName => $iconSet) {

	if ($iconSet[0]->iconType == '.icon') {

		$icomoons [] = $iconSet[0]->name;
	}
}
?>


<div class="card" >
	<div class="card-body">
<!--		ToDo: User Flag for title -->
		<h2 class="card-title"><?php echo Text::_('MOD_J4_STD_ICONS_AVAILABLE_ICONS'); ?></h2>
		<h6 class="card-subtitle mb-2 text-muted"><?php echo $version; ?></h6>
		<h6 class="card-subtitle mb-2 text-muted"><?php echo Text::_('MOD_J4_STD_ICONS_AVAILABLE_ICONS_DESC'); ?></h6>
		<br>

		<!-- icomoon replacements ======================================================================== -->
		<div class="card mb-3 ">
			<div class="card-header">
				<h2>
					<span class="icon-joomla" aria-hidden="true"></span>
					<?php echo Text::_('MOD_J4_STD_ICONS_ICOMOON_ICONS'); ?>
				</h2>
			</div>

			<div class="card-body">
				<h6 class="card-title"><?php echo Text::_('MOD_J4_STD_ICONS_ICOMOON_ICONS_DESC'); ?></h6>
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

						<?php foreach ($icomoons as $item): ?>
							<li class="quickicon quickicon-single">
								<a href="#">
									<div class="quickicon-info">
										<div class="quickicon-icon">
											<i style="font-size: 48px;" class="icon-<?php echo $item; ?>"></i>

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

		<!-- font awesome ======================================================================== -->
		<div class="card mb-3 ">
			<div class="card-header">
				<h2>
					<span class="icon-joomla" aria-hidden="true"></span>
					<?php echo Text::_('MOD_J4_STD_ICONS_AWESOME_ICONS'); ?>
				</h2>
			</div>
			<div class="card-body">
				<h6 class="card-title"><?php echo Text::_('MOD_J4_STD_ICONS_AWESOME_ICONS_DESC'); ?></h6>
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

	</div>
</div>
