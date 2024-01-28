<?php
/**
 * @package     Joomla.site
 * @subpackage  mod_j4_std_icons
 *
 * @copyright   Copyright (C) 2023-2023 thomas finnern
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

//use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

\defined('_JEXEC') or die;

global $j_css_icons;

// extracted version
$awesome_version = $j_css_icons->awesome_version;

$css_icomoon_icons = $j_css_icons->css_icomoon_icons;
$css_joomla_awesome_icons = $j_css_icons->css_joomla_awesome_icons;
$css_all_awesome_icons = $j_css_icons->css_all_awesome_icons;


// load css
$wa = $app->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle('mod_j4_std_icons', 'mod_j4_std_icons/template.css');

$isDisplayTablesHeader = $params->get('isDisplayTablesHeader');
$isDisplayTechDetail = $params->get('isDisplayTechDetail');

$isDisplayIcomoonTable = $params->get('isDisplayIcomoonTable');
$isDisplayJoomlaAwesomeTable = $params->get('isDisplayJoomlaAwesomeTable');
$isDisplayAllAwesomeTable = $params->get('isDisplayAllAwesomeTable');

$isDisplayByCharTable = $params->get('isDisplayByCharTable');

//>>>----------------------------------------------------
$isDisplayTablesHeader = true;
$isDisplayTechDetail = true;
$isDisplayIcomoonTable = true;
$isDisplayJoomlaAwesomeTable = true;
$isDisplayAllAwesomeTable = true;
$isDisplayByCharTable = true;
//<<<----------------------------------------------------

$font_size = $params->get('font_size');

// <!--style>
//    .icon {
//        width: 1em;
//        height: 1em;
//        vertical-align: -.125em;
//    }
//</style-->

?>

<div class="card" >
	<div class="card-body">
		<?php if (empty($css_icomoon_icons) && empty($css_joomla_awesome_icons) && empty($css_all_awesome_icons)): ?>
			<h3 class="card-title">
				<?php echo Text::_('MOD_J4_STD_ICONS_NO_ICONS'); ?>
			</h3>
			<h6 class="card-subtitle mb-2 text-muted">
				<?php echo Text::_('MOD_J4_STD_ICONS_NO_ICONS_DESC'); ?>
			</h6>

		<?php else: ?>

			<?php if($isDisplayTablesHeader): ?>
				<h2 class="card-title"><?php echo Text::_('MOD_J4_STD_ICONS_AVAILABLE_ICONS'); ?></h2>
				<div class="mb-3">
					<h6 class="card-subtitle mb-2 text-muted"><?php echo $awesome_version; ?></h6>
				</div>

				<?php if($isDisplayTechDetail): ?>
					<div class="mb-3">
						<h6 class="card-subtitle mb-2 text-muted"><?php echo Text::_('MOD_J4_STD_ICONS_AVAILABLE_ICONS_DESC'); ?></h6>
					</div>

				<?php endif; ?>
			<?php endif; ?>

			<!-- icomoon replacements ======================================================================== -->

			<?php if($isDisplayIcomoonTable): ?>
				<div class="card mb-3 ">
					<div class="card-header">
						<h2>
							<span class="icon-joomla" aria-hidden="true"></span>
							<?php echo Text::_('MOD_J4_STD_ICONS_ICOMOON_ICONS'); ?>
						</h2>
					</div>

					<div class="card-body">

						<?php if($isDisplayTechDetail): ?>
							<div class="mb-3">
								<div class="card-title"><?php echo Text::_('MOD_J4_STD_ICONS_ICOMOON_ICONS_DESC'); ?></div>
							</div>
						<?php endif; ?>

						<nav class="quick-icons px-3 pb-3">
							<ul class="nav flex-wrap">
								<li class="quickicon quickicon-single">
									<a href="#">
										<div class="quickicon-info">
											<div class="quickicon-icon">
												<span class="icon-joomla" style="font-size: <?php echo $font_size; ?>px;" aria-hidden="true"></span>
											</div>
										</div>
										<div class="quickicon-name d-flex align-items-end">
											Joomla
										</div>
									</a>
								</li>

								<?php foreach ($css_icomoon_icons as $item): ?>
									<li class="quickicon quickicon-single">
										<a href="#">
											<div class="quickicon-info">

												<div class="quickicon-icon">
													<i style="font-size: <?php echo $font_size; ?>px;" class="icon-<?php echo $item->name; ?>"></i>
												</div>

											</div>
											<div class="quickicon-name d-flex align-items-end">
												<?php echo $item->name; ?>
											</div>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</nav>
						<h5>Count: <span class="badge bg-secondary"><?php echo count ($css_icomoon_icons); ?></span></h5>
					</div>
				</div>
			<?php endif; ?>

			<!-- joomla font awesome ======================================================================== -->

			<?php if($isDisplayJoomlaAwesomeTable): ?>
				<div class="card mb-3 ">
					<div class="card-header">
						<h2>
							<span class="icon-joomla" aria-hidden="true"></span>
							<?php echo Text::_('MOD_J4_STD_ICONS_AWESOME_ICONS'); ?>
						</h2>
					</div>
					<div class="card-body">

						<?php if($isDisplayTechDetail): ?>
							<div class="mb-3">
								<div class="card-title"><?php echo Text::_('MOD_J4_STD_ICONS_AWESOME_ICONS_DESC'); ?></div>
							</div>
						<?php endif; ?>

						<nav class="quick-icons px-3 pb-3">
							<ul class="nav flex-wrap">
								<li class="quickicon quickicon-single">
									<a href="#">
										<div class="quickicon-info">
											<div class="quickicon-icon">
												<span class="icon-joomla" style="font-size: <?php echo $font_size; ?>px;" aria-hidden="true"></span>
											</div>
										</div>
										<div class="quickicon-name d-flex align-items-end">
											Joomla
										</div>
									</a>
								</li>

								<?php foreach ($css_joomla_awesome_icons as $item): ?>
									<li class="quickicon quickicon-single">
										<a href="#">
											<div class="quickicon-info">

												<div class="quickicon-icon">
                                                    <i style="font-size: <?php echo $font_size; ?>px;" class="icon-<?php echo $item->name; ?>"></i>
												</div>

                                            </div>
											<div class="quickicon-name d-flex align-items-end">
												<?php echo $item->name; ?>
											</div>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</nav>
						<h5>Count: <span class="badge bg-secondary"><?php echo count ($css_joomla_awesome_icons); ?></span></h5>
					</div>
				</div>
			<?php endif; ?>

            <!-- vendor all fontawesome ======================================================================== -->

			<?php if($isDisplayAllAwesomeTable): ?>
                <div class="card mb-3 ">
                    <div class="card-header">
                        <h2>
                            <span class="icon-joomla" aria-hidden="true"></span>
							<?php echo Text::_('MOD_J4_STD_ICONS_AWESOME_ICONS'); ?>
                        </h2>
                    </div>
                    <div class="card-body">

						<?php if($isDisplayTechDetail): ?>
                            <div class="mb-3">
                                <div class="card-title"><?php echo Text::_('MOD_J4_STD_ICONS_AWESOME_ICONS_DESC'); ?></div>
                            </div>
						<?php endif; ?>

                        <nav class="quick-icons px-3 pb-3">
                            <ul class="nav flex-wrap">
                                <li class="quickicon quickicon-single">
                                    <a href="#">
                                        <div class="quickicon-info">
                                            <div class="quickicon-icon">
                                                <span class="icon-joomla" style="font-size: <?php echo $font_size; ?>px;" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="quickicon-name d-flex align-items-end">
                                            Joomla
                                        </div>
                                    </a>
                                </li>

								<?php foreach ($css_all_awesome_icons as $item): ?>
                                    <li class="quickicon quickicon-single">
                                        <a href="#">
                                            <div class="quickicon-info">

                                                <div class="quickicon-icon">
                                                    <i style="font-size: <?php echo $font_size; ?>px;" class="fa-solid fa-<?php echo $item->name; ?>"></i>
                                                    <!--i style="font-size: <?php echo $font_size; ?>px;" class="fa fa-<?php echo $item->name; ?>"></i-->
                                                    <!--i style="font-size: <?php echo $font_size; ?>px;" class="fas fa-<?php echo $item->name; ?>"></i-->
                                                </div>

                                            </div>
                                            <div class="quickicon-name d-flex align-items-end">
												<?php echo $item->name; ?>
                                            </div>
                                        </a>
                                    </li>
								<?php endforeach; ?>
                            </ul>
                        </nav>
                        <h5>Count: <span class="badge bg-secondary"><?php echo count ($css_all_awesome_icons); ?></span></h5>
                    </div>
                </div>
			<?php endif; ?>



            <!-- collected characters ======================================================================== -->




		<?php endif; ?>
	</div>
</div>
