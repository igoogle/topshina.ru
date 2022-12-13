<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<div class="social-icons">
	<!-- noindex -->
	<ul>
		<?if(!empty($arResult['SOCIAL_FACEBOOK'])):?>
			<li class="facebook">
				<a href="<?=$arResult['SOCIAL_FACEBOOK']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_FACEBOOK')?>">
					<?=CTires2::showIconSvg("fb", SITE_TEMPLATE_PATH."/images/svg/social/Facebook.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_FACEBOOK')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_VK'])):?>
			<li class="vk">
				<a href="<?=$arResult['SOCIAL_VK']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_VK')?>">
					<?=CTires2::showIconSvg("vk", SITE_TEMPLATE_PATH."/images/svg/social/Vk.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_VK')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_TWITTER'])):?>
			<li class="twitter">
				<a href="<?=$arResult['SOCIAL_TWITTER']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_TWITTER')?>">
					<?=CTires2::showIconSvg("tw", SITE_TEMPLATE_PATH."/images/svg/social/Twitter.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_TWITTER')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_INSTAGRAM'])):?>
			<li class="instagram">
				<a href="<?=$arResult['SOCIAL_INSTAGRAM']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_INSTAGRAM')?>">
					<?=CTires2::showIconSvg("inst", SITE_TEMPLATE_PATH."/images/svg/social/Instagram.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_INSTAGRAM')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_TELEGRAM'])):?>
			<li class="telegram">
				<a href="<?=$arResult['SOCIAL_TELEGRAM']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_TELEGRAM')?>">
					<?=CTires2::showIconSvg("tel", SITE_TEMPLATE_PATH."/images/svg/social/Telegram.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_TELEGRAM')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_YOUTUBE'])):?>
			<li class="ytb">
				<a href="<?=$arResult['SOCIAL_YOUTUBE']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_YOUTUBE')?>">
					<?=CTires2::showIconSvg("yt", SITE_TEMPLATE_PATH."/images/svg/social/Youtube.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_YOUTUBE')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_ODNOKLASSNIKI'])):?>
			<li class="odn">
				<a href="<?=$arResult['SOCIAL_ODNOKLASSNIKI']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_ODNOKLASSNIKI')?>">
					<?=CTires2::showIconSvg("ok", SITE_TEMPLATE_PATH."/images/svg/social/Odnoklassniki.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_ODNOKLASSNIKI')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_GOOGLEPLUS'])):?>
			<li class="gplus">
				<a href="<?=$arResult['SOCIAL_GOOGLEPLUS']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_GOOGLEPLUS')?>">
					<?=CTires2::showIconSvg("gp", SITE_TEMPLATE_PATH."/images/svg/social/Googleplus.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_GOOGLEPLUS')?>
				</a>
			</li>
		<?endif;?>
		<?if(!empty($arResult['SOCIAL_MAIL'])):?>
			<li class="mail">
				<a href="<?=$arResult['SOCIAL_MAIL']?>" class="dark-color" target="_blank" rel="nofollow" title="<?=GetMessage('TEMPL_SOCIAL_MAILRU')?>">
					<?=CTires2::showIconSvg("ml", SITE_TEMPLATE_PATH."/images/svg/social/Mailru.svg");?>
					<?=GetMessage('TEMPL_SOCIAL_MAILRU')?>
				</a>
			</li>
		<?endif;?>
	</ul>
	<!-- /noindex -->
</div>