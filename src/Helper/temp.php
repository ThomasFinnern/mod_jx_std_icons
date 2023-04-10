
administrator/components/com_admin/src/Model/SysinfoModel.php

use Joomla\Component\Admin\Administrator\Service\HTML\DefaultIcons;
use Joomla\Component\Admin\Administrator\Service\HTML\Directory;
use Joomla\Component\Admin\Administrator\Service\HTML\PhpSetting;
use Joomla\Component\Admin\Administrator\Service\HTML\System;


	public function getDefaultIcons(): array
	{
		$icons = [];
		$files = [
			//JPATH_ROOT. '/media/vendor/fontawesome-free/webfonts/fa-brands-400.svg',
			JPATH_ROOT. '/media/vendor/fontawesome-free/webfonts/fa-regular-400.svg',
			JPATH_ROOT. '/media/vendor/fontawesome-free/webfonts/fa-solid-900.svg'
		];

		foreach ($files as $file)
		{
			$array = json_decode(json_encode(simplexml_load_file($file)),TRUE);
			$glyphs = $array['defs']['font']['glyph'];

			foreach($glyphs as $glyph)
			{
				$icons[] = $glyph['@attributes']['glyph-name'];
			}
		}

		asort($icons);

		return array_unique($icons);
	}
}


administrator/components/com_admin/src/View/Sysinfo/HtmlView.php


/**
	 * All default Icons
	 *
	 * @var    array
	 * @since  4.2
	 */
	protected $defaulticons = [];
	
		$this->defaulticons= $model->getDefaultIcons();

 
administrator/components/com_admin/tmpl/sysinfo/default.php

		<?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'defaulticons', Text::_('COM_ADMIN_AVAILABLE_ICONS')); ?>
		<?php echo $this->loadTemplate('defaulticons'); ?>
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

administrator/components/com_admin/tmpl/sysinfo/default_defaulticons.php

<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_admin
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var \Joomla\Component\Admin\Administrator\View\Sysinfo\HtmlView $this */

?>
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

				<?php foreach ($this->defaulticons as $item): ?>
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

 
administrator/language/en-GB/com_admin.ini

	




