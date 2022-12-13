<?php
use \Bitrix\Main\Localiztion\Loc;

?>
<div class="side-panel-controls">
	<div class="side-panel-controls__item">
	<?php
	$APPLICATION->IncludeFile(
		'include/globals/cart-icon.php',
		array(
			'AJAX_LOAD' => 'Y',
		),
		array(
			'SHOW_BORDER' => false
		)
	);
	?>
	</div>

	<div class="side-panel-controls__item">
	<?php
	$APPLICATION->IncludeFile(
		'include/globals/favorite-icon.php',
		array(
			'AJAX_LOAD' => 'Y',
		),
		array(
			'SHOW_BORDER' => false
		)
	);
	?>
	</div>

	<div class="side-panel-controls__item">
	<?php
	$APPLICATION->IncludeFile(
		'include/globals/compare-icon.php',
		array(),
		array(
			'SHOW_BORDER' => false
		)
	);
	?>
	</div>

	<div class="side-panel-controls__item">
		<?php
		$APPLICATION->IncludeFile(
			SITE_DIR.'include/panels/side/recall.php',
			array()
		);
		?>
	</div>
</div>
