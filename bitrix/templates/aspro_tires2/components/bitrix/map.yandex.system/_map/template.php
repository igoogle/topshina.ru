<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<?$this->setFrameMode(true);?>
<script type="text/javascript">
if (!window.GLOBAL_arMapObjects)
	window.GLOBAL_arMapObjects = {};

var map;
var animateFunctionexists = false;
var markerSVG = '<svg xmlns="http://www.w3.org/2000/svg" width="46" height="61.156" viewBox="0 0 46 61.156">'
				 +'<defs><style>.cls-10,.cls-20 {fill: #fff;}.cls-20, .cls-30{fill-rule: evenodd;}.cls-20{opacity: 0.7;}</style></defs>'
				  +'<circle class="cls-10" cx="23" cy="23" r="12"/><path class="cls-20" d="M1000,742a23,23,0,1,1-23,23A23,23,0,0,1,1000,742Zm17,30,2,6s-18.31,23.26-19,24a4.464,4.464,0,0,1-4,1c-0.76-.313-2.159-0.161-2-4s3-23,3-23Z" transform="translate(-977 -742)"/><path id="Ellipse_196_copy_4" data-name="Ellipse 196 copy 4" class="cls-30" d="M1015.99,776.977L1016,777l-18,23h-1l2.178-15.041A20.016,20.016,0,1,1,1015.99,776.977ZM1000,754a11,11,0,1,0,11,11A11,11,0,0,0,1000,754Z" transform="translate(-977 -742)"/>'
				+'</svg>';

function init_<?echo $arParams['MAP_ID']?>()
{
	if (!window.ymaps)
		return;

	/*if(typeof window.GLOBAL_arMapObjects['<?echo $arParams['MAP_ID']?>'] !== "undefined")
		return;*/

	var node = BX("BX_YMAP_<?echo $arParams['MAP_ID']?>");
	node.innerHTML = '';

	map = window.GLOBAL_arMapObjects['<?echo $arParams['MAP_ID']?>'] = new ymaps.Map(node, {
		center: [<?echo $arParams['INIT_MAP_LAT']?>, <?echo $arParams['INIT_MAP_LON']?>],
		zoom: <?echo $arParams['INIT_MAP_SCALE']?>,
		type: 'yandex#<?=$arResult['ALL_MAP_TYPES'][$arParams['INIT_MAP_TYPE']]?>',
		// adjustZoomOnTypeChange: true
	});
	
	map.geoObjects.events.add('balloonclose', function (e){
		setTimeout(function(){
			$('.ymaps-image-with-content').each(function(){
				if(!$(this).find('.marker').length){
					$(this).prepend('<div class="marker">'+markerSVG+'</div>');
				}
			});
		}, 20);
	});
	
	map.events.add('boundschange', function (e) {
		//$('.ymaps-image-with-content .marker').remove();
		setTimeout(function(){
			$('.ymaps-image-with-content').each(function(){
				if(!$(this).find('.marker').length){
					$(this).prepend('<div class="marker">'+markerSVG+'</div>');
				}
			});
		}, 300);
	});

<?
foreach ($arResult['ALL_MAP_OPTIONS'] as $option => $method)
{
	if (in_array($option, $arParams['OPTIONS'])):
?>
	map.behaviors.enable("<?echo $method?>");
<?
	else:
?>
	if (map.behaviors.isEnabled("<?echo $method?>"))
		map.behaviors.disable("<?echo $method?>");
<?
	endif;
}

foreach ($arResult['ALL_MAP_CONTROLS'] as $control => $method)
{
	if (in_array($control, $arParams['CONTROLS'])):
?>
	map.controls.add('<?=$method?>');

<?
	endif;
}


if ($arParams['DEV_MODE'] == 'Y'):
?>
	window.bYandexMapScriptsLoaded = true;
<?
endif;

if ($arParams['ONMAPREADY']):
?>
	if (window.<?echo $arParams['ONMAPREADY']?>)
	{
<?
	if ($arParams['ONMAPREADY_PROPERTY']):
?>
		<?echo $arParams['ONMAPREADY_PROPERTY']?> = map;
		window.<?echo $arParams['ONMAPREADY']?>();
<?
	else:
?>
		window.<?echo $arParams['ONMAPREADY']?>(map);
<?
	endif;
?>
	}
<?
endif;
?>
}
<?
if ($arParams['DEV_MODE'] == 'Y'):
?>
function BXMapLoader_<?echo $arParams['MAP_ID']?>()
{
	if (null == window.bYandexMapScriptsLoaded)
	{
		function _wait_for_map(){
			if (window.ymaps && window.ymaps.Map)
				init_<?echo $arParams['MAP_ID']?>();
			else
				setTimeout(_wait_for_map, 50);
		}

		BX.loadScript('<?=$arResult['MAPS_SCRIPT_URL']?>', _wait_for_map);
	}
	else
	{
		init_<?echo $arParams['MAP_ID']?>();
	}
}
<?
	if ($arParams['WAIT_FOR_EVENT']):
?>
	<?=CUtil::JSEscape($arParams['WAIT_FOR_EVENT'])?> = BXMapLoader_<?=$arParams['MAP_ID']?>;
<?
	elseif ($arParams['WAIT_FOR_CUSTOM_EVENT']):
?>
	BX.addCustomEvent('<?=CUtil::JSEscape($arParams['WAIT_FOR_EVENT'])?>', BXMapLoader_<?=$arParams['MAP_ID']?>);
<?
	else:
?>
	BX.ready(BXMapLoader_<?echo $arParams['MAP_ID']?>);
<?
	endif;
else: // $arParams['DEV_MODE'] == 'Y'
?>
			
(function bx_ymaps_waiter(){
	if(typeof ymaps !== 'undefined')
		ymaps.ready(init_<?echo $arParams['MAP_ID']?>);
	else
		setTimeout(bx_ymaps_waiter, 100);
})();

<?
endif; // $arParams['DEV_MODE'] == 'Y'
?>

/* if map inits in hidden block (display:none)
*  after the block showed
*  for properly showing map this function must be called
*/
function BXMapYandexAfterShow(mapId)
{
	if(window.GLOBAL_arMapObjects[mapId] !== undefined)
		window.GLOBAL_arMapObjects[mapId].container.fitToViewport();
}
</script>
<div id="BX_YMAP_<?echo $arParams['MAP_ID']?>" class="bx-yandex-map" style="height: <?echo $arParams['MAP_HEIGHT'];?>; width: <?echo $arParams['MAP_WIDTH']?>;"><?echo GetMessage('MYS_LOADING'.($arParams['WAIT_FOR_EVENT'] ? '_WAIT' : ''));?></div>