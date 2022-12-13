<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var string $templateName
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $giftParameters
 */
$documentRoot = Main\Application::getDocumentRoot();

if (!isset($arParams['DISPLAY_MODE']) || !in_array($arParams['DISPLAY_MODE'], array('extended', 'compact')))
{
	$arParams['DISPLAY_MODE'] = 'extended';
}

$arParams['USE_DYNAMIC_SCROLL'] = isset($arParams['USE_DYNAMIC_SCROLL']) && $arParams['USE_DYNAMIC_SCROLL'] === 'N' ? 'N' : 'Y';
$arParams['SHOW_FILTER'] = isset($arParams['SHOW_FILTER']) && $arParams['SHOW_FILTER'] === 'N' ? 'N' : 'Y';

$arParams['PRICE_DISPLAY_MODE'] = isset($arParams['PRICE_DISPLAY_MODE']) && $arParams['PRICE_DISPLAY_MODE'] === 'N' ? 'N' : 'Y';

if (!isset($arParams['TOTAL_BLOCK_DISPLAY']) || !is_array($arParams['TOTAL_BLOCK_DISPLAY']))
{
	$arParams['TOTAL_BLOCK_DISPLAY'] = array('top');
}

if (empty($arParams['PRODUCT_BLOCKS_ORDER']))
{
	$arParams['PRODUCT_BLOCKS_ORDER'] = 'props,sku,columns';
}

if (is_string($arParams['PRODUCT_BLOCKS_ORDER']))
{
	$arParams['PRODUCT_BLOCKS_ORDER'] = explode(',', $arParams['PRODUCT_BLOCKS_ORDER']);
}

$arParams['USE_PRICE_ANIMATION'] = isset($arParams['USE_PRICE_ANIMATION']) && $arParams['USE_PRICE_ANIMATION'] === 'N' ? 'N' : 'Y';
$arParams['EMPTY_BASKET_HINT_PATH'] = isset($arParams['EMPTY_BASKET_HINT_PATH']) ? (string)$arParams['EMPTY_BASKET_HINT_PATH'] : '/';
$arParams['USE_ENHANCED_ECOMMERCE'] = isset($arParams['USE_ENHANCED_ECOMMERCE']) && $arParams['USE_ENHANCED_ECOMMERCE'] === 'Y' ? 'Y' : 'N';
$arParams['DATA_LAYER_NAME'] = isset($arParams['DATA_LAYER_NAME']) ? trim($arParams['DATA_LAYER_NAME']) : 'dataLayer';
$arParams['BRAND_PROPERTY'] = isset($arParams['BRAND_PROPERTY']) ? trim($arParams['BRAND_PROPERTY']) : '';

if ($arParams['USE_GIFTS'] === 'Y')
{
	$giftParameters = array(
		'SHOW_PRICE_COUNT' => 1,
		'PRODUCT_SUBSCRIPTION' => 'N',
		'PRODUCT_ID_VARIABLE' => 'id',
		'PARTIAL_PRODUCT_PROPERTIES' => 'N',
		'USE_PRODUCT_QUANTITY' => 'N',
		'ACTION_VARIABLE' => 'actionGift',
		'ADD_PROPERTIES_TO_BASKET' => 'Y',

		'BASKET_URL' => $APPLICATION->GetCurPage(),
		'APPLIED_DISCOUNT_LIST' => $arResult['APPLIED_DISCOUNT_LIST'],
		'FULL_DISCOUNT_LIST' => $arResult['FULL_DISCOUNT_LIST'],

		'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
		'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_SHOW_VALUE'],
		'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],

		'BLOCK_TITLE' => $arParams['GIFTS_BLOCK_TITLE'],
		'HIDE_BLOCK_TITLE' => $arParams['GIFTS_HIDE_BLOCK_TITLE'],
		'TEXT_LABEL_GIFT' => $arParams['GIFTS_TEXT_LABEL_GIFT'],
		'PRODUCT_QUANTITY_VARIABLE' => $arParams['GIFTS_PRODUCT_QUANTITY_VARIABLE'],
		'PRODUCT_PROPS_VARIABLE' => $arParams['GIFTS_PRODUCT_PROPS_VARIABLE'],
		'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
		'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
		'SHOW_NAME' => $arParams['GIFTS_SHOW_NAME'],
		'SHOW_IMAGE' => $arParams['GIFTS_SHOW_IMAGE'],
		'MESS_BTN_BUY' => $arParams['GIFTS_MESS_BTN_BUY'],
		'MESS_BTN_DETAIL' => $arParams['GIFTS_MESS_BTN_DETAIL'],
		'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
		'CONVERT_CURRENCY' => $arParams['GIFTS_CONVERT_CURRENCY'],
		'HIDE_NOT_AVAILABLE' => $arParams['GIFTS_HIDE_NOT_AVAILABLE'],

		'LINE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],

		'DETAIL_URL' => isset($arParams['GIFTS_DETAIL_URL']) ? $arParams['GIFTS_DETAIL_URL'] : null
	);
}

\CJSCore::Init(array('fx', 'popup', 'ajax'));

// $this->addExternalJs($templateFolder.'/js/mustache.js');
$this->addExternalJs('/bitrix/js/ui/mustache/mustache.js');
$this->addExternalJs($templateFolder.'/js/action-pool.js');
$this->addExternalJs($templateFolder.'/js/filter.js');
$this->addExternalJs($templateFolder.'/js/component.js');

$mobileColumns = isset($arParams['COLUMNS_LIST_MOBILE'])
	? $arParams['COLUMNS_LIST_MOBILE']
	: $arParams['COLUMNS_LIST'];
$mobileColumns = array_fill_keys($mobileColumns, true);

$jsTemplates = new Main\IO\Directory($documentRoot.$templateFolder.'/js-templates');
/** @var Main\IO\File $jsTemplate */
foreach ($jsTemplates->getChildren() as $jsTemplate)
{
	include($jsTemplate->getPath());
}

$displayModeClass = $arParams['DISPLAY_MODE'] === 'compact' ? ' basket-items-list-wrapper-compact' : '';

if (empty($arResult['ERROR_MESSAGE']))
{
	if ($arParams['USE_GIFTS'] === 'Y' && $arParams['GIFTS_PLACE'] === 'TOP')
	{
		$APPLICATION->IncludeComponent(
			'bitrix:sale.gift.basket',
			'.default',
			$giftParameters,
			$component
		);
	}

	if ($arResult['BASKET_ITEM_MAX_COUNT_EXCEEDED'])
	{
		?>
		<div id="basket-item-message">
			<?=Loc::getMessage('SBB_BASKET_ITEM_MAX_COUNT_EXCEEDED', array('#PATH#' => $arParams['PATH_TO_BASKET']))?>
		</div>
		<?
	}

	$layout = new \Redsign\MegaMart\Layouts\Section();
	$layout
		->addModifier('bg-white')
		->addModifier('shadow')
		->addModifier('outer-spacing');

	$layout->start();
	?>
			<div id="basket-root" class="bx-basket bx-<?=$arParams['TEMPLATE_THEME']?> bx-step-opacity" style="opacity: 0;">

				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-warning alert-dismissable" id="basket-warning" style="display: none;">
							<span class="close" data-entity="basket-items-warning-notification-close">&times;</span>
							<div data-entity="basket-general-warnings"></div>
							<div data-entity="basket-item-warnings">
								<?=Loc::getMessage('SBB_BASKET_ITEM_WARNING')?>
							</div>
						</div>

						<div data-entity="basket-custom-errors" style="display: none">
							<div class="alert alert-danger alert-basket-custom-errors mb-0">
								<svg class="icon-svg"><use xlink:href="#svg-error"></use></svg>
								<span data-entity="basket-custom-errors-content"></span>
							</div>
						</div>

						<div data-entity="basket-custom-info" style="display: none">
							<div class="alert alert-info alert-basket-custom-info mb-0">
								<span data-entity="basket-custom-info-content"></span>
							</div>
						</div>
					</div>
				</div>

				<?php if ($arResult['USE_VBASKET']): ?>
				<div class="row">
					<div class="col-xs-12">
						<div class="border-body-bg border-bottom border-bottom-1 p-4 px-md-3 px-xl-6 py-xl-5">
							<?php
							$APPLICATION->IncludeComponent(
								'redsign:vbasket.select', 
								'megamart',
								array()
							);
							?>
						</div>
					</div>
				</div>
				<?php endif; ?>

				<div class="col-xs-12">
					<div class="basket-items-list-wrapper basket-items-list-wrapper-height-fixed basket-items-list-wrapper-light<?=$displayModeClass?>"
						id="basket-items-list-wrapper">
						<div class="basket-items-list-header" data-entity="basket-items-list-header">
							<div class="basket-items-search-field" data-entity="basket-filter">
								<div class="form has-feedback">
									<input type="text" class="form-control"
										placeholder="<?=Loc::getMessage('SBB_BASKET_FILTER')?>"
										data-entity="basket-filter-input">
									<span class="form-control-feedback basket-clear" data-entity="basket-filter-clear-btn"></span>
								</div>
							</div>
							<div class="basket-items-list-header-filter">
								<a href="javascript:void(0)" class="btn  btn-quantity basket-items-list-header-filter-item btn-secondary"
									data-entity="basket-items-count" data-filter="all" style="display: none;"></a>
								<a href="javascript:void(0)" class="btn btn-quantity basket-items-list-header-filter-item btn-outline-secondary"
									data-entity="basket-items-count" data-filter="similar" style="display: none;"></a>
								<a href="javascript:void(0)" class="btn btn-quantity basket-items-list-header-filter-item btn-outline-secondary"
									data-entity="basket-items-count" data-filter="warning" style="display: none;"></a>
								<a href="javascript:void(0)" class="btn btn-quantity basket-items-list-header-filter-item btn-outline-secondary"
									data-entity="basket-items-count" data-filter="delayed" style="display: none;"></a>
								<a href="javascript:void(0)" class="btn btn-quantity basket-items-list-header-filter-item btn-outline-secondary"
									data-entity="basket-items-count" data-filter="not-available" style="display: none;"></a>
								<a href="javascript:void(0)" class="btn btn-outline-secondary ml-md-5" data-entity="basket-items-clear"><?=Loc::getMessage('SBB_BASKET_CLEAR_BUTTON')?></a>
							</div>
						</div>
						<div class="basket-items-list-container" id="basket-items-list-container">
							<div class="basket-items-list-overlay" id="basket-items-list-overlay" style="display: none;"></div>
							<div class="basket-items-list" id="basket-item-list">
								<div class="basket-search-not-found" id="basket-item-list-empty-result" style="display: none;">
									<div class="basket-search-not-found-icon"></div>
									<div class="basket-search-not-found-text">
										<?=Loc::getMessage('SBB_FILTER_EMPTY_RESULT')?>
									</div>
								</div>
								<table class="table basket-items-list-table" >
									<thead class="basket-items-list-thead">
										<tr>
											<th class="basket-items-list-th basket-items-list-header-name"><?=Loc::getMessage('SBB_TABLE_TH_NAME')?></th>
											<th class="basket-items-list-th text-center"><?=Loc::getMessage('SBB_TABLE_TH_AMOUNT')?></th>
											<th class="basket-items-list-th"><?=Loc::getMessage('SBB_TABLE_TH_PRICE')?></th>
											<th class="basket-items-list-th"><?=Loc::getMessage('SBB_TABLE_TH_DISCOUNT')?></th>
											<th class="basket-items-list-th"><?=Loc::getMessage('SBB_TABLE_TH_SUM')?></th>
											<th></th>
										</tr>
									</thead>
									<tbody id="basket-item-table"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<?
				if (
					$arParams['BASKET_WITH_ORDER_INTEGRATION'] !== 'Y'
					&& in_array('bottom', $arParams['TOTAL_BLOCK_DISPLAY'])
				)
				{
					?>
					<div class="row">
						<div class="col-xs-12" data-entity="basket-total-block"></div>
					</div>
					<?
				}
				?>
			</div>
	<?

    $layout->end();

	if (!empty($arResult['CURRENCIES']) && Main\Loader::includeModule('currency'))
	{
		CJSCore::Init('currency');

		?>
		<script>
			BX.Currency.setCurrencies(<?=CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true)?>);
		</script>
		<?
	}

	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedTemplate = $signer->sign($templateName, 'sale.basket.basket');
	$signedParams = $signer->sign(base64_encode(serialize($arParams)), 'sale.basket.basket');
	$messages = Loc::loadLanguageFile(__FILE__);
	?>
	<script>
		BX.message(<?=CUtil::PhpToJSObject($messages)?>);
		BX.Sale.BasketComponent.init({
			result: <?=CUtil::PhpToJSObject($arResult, false, false, true)?>,
			params: <?=CUtil::PhpToJSObject($arParams)?>,
			template: '<?=CUtil::JSEscape($signedTemplate)?>',
			signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
			siteId: '<?=$component->getSiteId()?>',
			ajaxUrl: '<?=CUtil::JSEscape($component->getPath().'/ajax.php')?>',
			templateFolder: '<?=CUtil::JSEscape($templateFolder)?>'
		});
	</script>
	<?
	if ($arParams['USE_GIFTS'] === 'Y' && $arParams['GIFTS_PLACE'] === 'BOTTOM')
	{
		// $APPLICATION->IncludeComponent(
		// 	'bitrix:sale.gift.basket',
		// 	'.default',
		// 	$giftParameters,
		// 	$component
		// );
	}
}
else
{
	if ($arResult['BASKET_ITEMS_COUNT'] < 1) 
	{
		// Cart is empty
		$layout = new \Redsign\MegaMart\Layouts\Section();
		$layout
			->addModifier('bg-white')
			->addModifier('outer-spacing')
			->addModifier('inner-spacing')
			->addModifier('shadow');

		$layout->start();
		?>
			<?php if ($arResult['USE_VBASKET']): ?>

			<div class="block-spacing-negative mb-0">
				<div class="border-body-bg border-bottom border-bottom-1 p-6">
					<?php
					$APPLICATION->IncludeComponent(
						'redsign:vbasket.select', 
						'megamart',
						array()
					);
					?>
				</div>
			</div>
			
			<div class="d-block mt-4 mt-md-7">
			<?php
			$APPLICATION->IncludeFile(
				SITE_DIR.'include/templates/cart/add_cart.php',
				array(),
				array(
					'SHOW_BORDER' => true
				)
			);
			?>
			</div>
			
			<?php else: ?>

			<div class="basket-empty">
				<div class="basket-empty__icon">
					<svg class="icon-svg"><use xlink:href="#svg-cart"></use></svg>
				</div>
				<h2 class="basket-empty__title"><?=Loc::getMessage('SBB_BASKET_EMPTY_TITLE');?></h2>
				<div class="basket-empty__descr"><?=Loc::getMessage('SBB_BASKET_EMPTY_DESCR');?></div>
				<div class="basket-empty__buttons">
					<a href="<?=$arParams['EMPTY_BASKET_HINT_PATH']?>" class="btn btn-primary"><?=Loc::getMessage('SBB_BASKET_EMPTY_CATALOG');?></a>
				</div>
			</div>

			<?php endif; ?>
		<?php
		$layout->end();
	} 
	else 
	{
		ShowError($arResult['ERROR_MESSAGE']);
	}
}
