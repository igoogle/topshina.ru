<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заполнение формы");
?>
<style type="text/css">
section.page-top {display:none;}
.form.inline{margin-top:15px;}
.form .form-header{border-top: 1px solid #f5f5f5 !important;padding: 15px 0px 9px 0px;}
</style>
<?
CTires2::GetFrontParametrValue('', SITE_ID);

$form_id = isset($_REQUEST["form_id"]) ? $_REQUEST["form_id"] : 1;
if(\Bitrix\Main\Loader::includeModule("aspro.next"))
	CTires2::GetValidFormIDForSite($form_id);
$successMessage = ($isCallBack ? "<p>Наш менеджер перезвонит вам в ближайшее время.</p><p>Спасибо за ваше обращение!</p>" : "Спасибо! Ваше сообщение отправлено!");
$arDataTrigger = json_decode((isset($_REQUEST["data-trigger"]) ? $_REQUEST["data-trigger"] : '{}'), true); // allways UTF-8
$url_sizes = (htmlspecialchars($_REQUEST['url']) ? htmlspecialchars($_REQUEST['url']) : '');
?>
<?if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'auth'):?>
	<?include_once('../ajax/auth.php');?>
<?elseif($form_id == 'fast_view'):?>
	<?include_once('../ajax/fast_view.php');?>
<?elseif(isset($_REQUEST['type']) && $_REQUEST['type'] == 'review'):?>
	<?include_once('../ajax/review.php');?>
<?elseif($form_id == 'TABLES_SIZE'):?>
	<div class="TABLES_SIZE_frame swipeignore">
	<a href="#" class="close jqmClose"><i></i></a>
	<div class="form">
		<div class="form_head">
			<h2><?=\Bitrix\Main\Localization\Loc::getMessage('TABLES_SIZE_TITLE');?></h2>
		</div>
		<div class="form_body">
			<?include('../'.$url_sizes);?>
		</div>
	</div>
	</div>
<?elseif($form_id == 'city_chooser'):?>
	<?$APPLICATION->SetTitle("Выбор города");?>
	<?include_once('../ajax/city_chooser.php');?>
<?elseif($form_id == 'ocb'):?>
	<style type="text/css">
	.popup-intro .pop-up-title{padding: 30px 0px;font-size: 20px;font-weight: bold;color:#222;}
	</style>
	<?if($_REQUEST['name'] == 'one_click_buy'):?>
		<?include_once('../ajax/one_click_buy.php');?>
	<?else:?>
		<?include_once('../ajax/one_click_buy_basket.php');?>
	<?endif;?>
<?elseif($form_id == 'filter_all_hint'):?>
	<a href="#" class="close jqmClose"><i></i></a>
	<div class="form filter_all_hint">
		<div class="form_head">
			<h2><?=\Bitrix\Main\Localization\Loc::getMessage('FILTER_ALL_HINT_TITLE');?></h2>
		</div>
		<div class="form_body">
			<?include_once('../include/filter_all_hint/filter_all_hint.php');?>
		</div>
	</div>	
<?elseif($form_id):?>
	<?
	$APPLICATION->IncludeComponent(
		"bitrix:form",
		"inline",
		Array(
			"AJAX_MODE" => "Y",
			"SEF_MODE" => "N",
			"WEB_FORM_ID" => $form_id,
			"START_PAGE" => "new",
			"SHOW_LIST_PAGE" => "N",
			"SHOW_EDIT_PAGE" => "N",
			"SHOW_VIEW_PAGE" => "N",
			"SUCCESS_URL" => "",
			"SHOW_ANSWER_VALUE" => "N",
			"SHOW_ADDITIONAL" => "N",
			"SHOW_STATUS" => "N",
			"EDIT_ADDITIONAL" => "N",
			"EDIT_STATUS" => "Y",
			"HIDE_SUCCESS" => "Y",
			"NOT_SHOW_FILTER" => "",
			"NOT_SHOW_TABLE" => "",
			"CHAIN_ITEM_TEXT" => "",
			"CHAIN_ITEM_LINK" => "",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"USE_EXTENDED_ERRORS" => "Y",
			"CACHE_GROUPS" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600000",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"SHOW_LICENCE" => CTires2::GetFrontParametrValue('SHOW_LICENCE'),
			"HIDDEN_CAPTCHA" => CTires2::GetFrontParametrValue('HIDDEN_CAPTCHA'),
			"AJAX_OPTION_HISTORY" => "N",
			"VARIABLE_ALIASES" => Array(
				"action" => "action"
			)
		)
	);?>
	<?if($arDataTrigger && strlen($name)):?>
		<script type="text/javascript">
		var name = '<?=$name?>';
		var arTriggerAttrs = <?=json_encode($arDataTrigger)?>;
		$(document).ready(function() {
			$.each(arTriggerAttrs, function(index, val){
				if( /^data\-autoload\-(.+)$/.test(index)){
					var key = index.match(/^data\-autoload\-(.+)$/)[1];
					var el = $('input[data-sid="'+key.toUpperCase()+'"]');
					if(el.closest('.form-group').length)
						el.closest('.form-group').addClass('input-filed');
					el.val(val).attr('readonly', 'readonly').attr('title', val);
				}
			});
			
			if(name == 'order_product'){
				if(arTriggerAttrs['data-product'].length){
					$('input[name="PRODUCT"]').val(arTriggerAttrs['data-product']).attr('readonly', 'readonly').attr('title', arTriggerAttrs['data-product']);
				}
			}
		});
		</script>
	<?endif;?>
<?else:?>
	<div class="alert alert-warning">Не указан ID формы</div>
	<?CTires2::goto404Page();?>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>