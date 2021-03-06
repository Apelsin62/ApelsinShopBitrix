<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->ShowAjaxHead();
$APPLICATION->AddHeadScript("/bitrix/js/main/dd.js");

if(SITE_CHARSET != "utf-8")
	$_REQUEST["arParams"] = $APPLICATION->ConvertCharsetArray($_REQUEST["arParams"], "utf-8", SITE_CHARSET);

$sComponentFolder = $_REQUEST["arParams"]["COMPONENT_PATH"];
$form_action = $_REQUEST["arParams"]["FORM_ACTION"];
$arParams = $_REQUEST["arParams"]["PARAMS"];
$element_id = $_REQUEST["arParams"]["ELEMENT_ID"];
$element_name = $_REQUEST["arParams"]["ELEMENT_NAME"];
$preview_img = $_REQUEST["arParams"]["PREVIEW_IMG"];
$captcha_code = $_REQUEST["arParams"]["CAPTCHA_CODE"];
$required = $_REQUEST["arParams"]["REQUIRED"];
$name = $_REQUEST["arParams"]["NAME"];
$email = $_REQUEST["arParams"]["EMAIL"];
$arMessage = $_REQUEST["arParams"]["MESS"];
$select_prop_div = $_REQUEST["arParams"]["SELECT_PROP_DIV"];

/***JS***/?>
<script type="text/javascript">
	/***SELECT_PROPS***/
	<?if(!empty($arParams["SELECT_PROP_DIV"])) {?>
		var selPropValueArr = [];
		ActiveItems = BX.findChildren(BX("<?=$arParams['SELECT_PROP_DIV']?>"), {tagName: "li", className: "active"}, true);
		if(!!ActiveItems && 0 < ActiveItems.length) {
			for(i = 0; i < ActiveItems.length; i++) {
				selPropValueArr[i] = ActiveItems[i].getAttribute("data-select-onevalue");			
			}
		}
		if(0 < selPropValueArr.length) {
			selPropValue = selPropValueArr.join("||");
			BX("bocElementSelectProps-<?=$arParams['ELEMENT_CODE'].$element_id?>").value = selPropValue;
		}
	<?}?>
	/***QUANTITY***/
	BX("bocQuantity-<?=$arParams['ELEMENT_CODE'].$element_id?>").value = BX("quantity_<?=$arParams['ELEMENT_CODE'].$element_id?>").value;	
</script>

<div class="container">
	<div class="info">
		<div class="image">
			<?if(is_array($preview_img)):?>
				<img src="<?=$preview_img['SRC']?>" width="<?=$preview_img['WIDTH']?>" height="<?=$preview_img['HEIGHT']?>" alt="<?=$element_name?>" />
			<?else:?>
				<img src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" width="150" height="150" alt="<?=$element_name?>" />
			<?endif?>
		</div>
		<div class="name"><?=$element_name?></div>
	</div>
	<form action="<?=$form_action?>" id="bocForm-<?=$arParams['ELEMENT_CODE'].$element_id?>" class="boc-form">
		<span id="echoBocForm-<?=$arParams['ELEMENT_CODE'].$element_id?>" class="echo-boc-form"></span>
		<div class="row MFT_BOC_DESCRIPTION"><?=$arMessage["MFT_BOC_DESCRIPTION"]?></div>
		<div class="row">
			<div class="span1">
				<?=$arMessage["MFT_NAME"]?><?if(empty($arParams["REQUIRED_ORDER_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_ORDER_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<div class="span2">
				<input type="text" class="input-text" id="bocName-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-name" value="<?=$name?>" />
			</div>
			<div class="clr"></div>
		</div>
		<div class="row">
			<div class="span1">
				<?=$arMessage["MFT_TEL"]?><?if(empty($arParams["REQUIRED_ORDER_FIELDS"]) || in_array("TEL", $arParams["REQUIRED_ORDER_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<div class="span2">
				<input type="text" class="input-text" id="bocTel-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-tel" value="" />
			</div>
			<div class="clr"></div>
		</div>
		<div class="row">
			<div class="span1">
				<?=$arMessage["MFT_EMAIL"]?><?if(empty($arParams["REQUIRED_ORDER_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_ORDER_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<div class="span2">
				<input type="text" class="input-text" id="bocEmail-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-email" value="<?=$email?>" />
			</div>
			<div class="clr"></div>
		</div>
		<div class="row">
			<div class="span1">
				<?=$arMessage["MFT_MESSAGE"]?><?if(empty($arParams["REQUIRED_ORDER_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_ORDER_FIELDS"])):?><span class="mf-req">*</span><?endif?>
			</div>
			<div class="span2">
				<textarea id="bocMessage-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-message" rows="3" cols="30"></textarea>
			</div>
			<div class="clear"></div>
		</div>
		<?if(!$USER->IsAuthorized()):?>
			<div class="row">
				<div class="span1">
					<?=$arMessage["MFT_CAPTCHA"];?><span class="mf-req">*</span>
				</div>
				<div class="span2">
					<input type="text" id="bocCaptchaWord-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-captcha-word" maxlength="50" value="" />
					<img id="bocCImg-<?=$arParams['ELEMENT_CODE'].$element_id?>" src="/bitrix/tools/captcha.php?captcha_sid=<?=$captcha_code?>" width="127" height="30" alt="CAPTCHA" />
					<input type="hidden" id="bocCaptchaSid-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-captcha-sid" value="<?=$captcha_code?>" />
				</div>
				<div class="clr"></div>
			</div>
		<?endif;?>		
		<input type="hidden" id="bocElementProps-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-element-props" value="<?=$arParams['ELEMENT_PROPS']?>"/>
		<input type="hidden" id="bocElementSelectProps-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-element-select-props" value="" />
		<input type="hidden" id="bocQuantity-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-quantity" value="" />
		<input type="hidden" id="bocPersonTypeId-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-person-type-id" value="<?=$arParams['DEFAULT_PERSON_TYPE']?>" />
		<input type="hidden" id="bocPropNameId-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-prop-name-id" value="<?=$arParams['DEFAULT_ORDER_PROP_NAME']?>" />
		<input type="hidden" id="bocPropTelId-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-prop-tel-id" value="<?=$arParams['DEFAULT_ORDER_PROP_TEL']?>" />
		<input type="hidden" id="bocPropEmailId-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-prop-email-id" value="<?=$arParams['DEFAULT_ORDER_PROP_EMAIL']?>" />
		<input type="hidden" id="bocDeliveryId-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-delivery-id" value="<?=$arParams['DEFAULT_DELIVERY']?>" />
		<input type="hidden" id="bocPaysystemId-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-paysystem-id" value="<?=$arParams['DEFAULT_PAYMENT']?>" />
		<input type="hidden" id="bocBuyMode-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-buy-mode" value="<?=$arParams['BUY_MODE']?>" />
		<input type="hidden" id="bocDubLetter-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="boc-dub-letter" value="<?=$arParams['DUB']?>" />
		<div class="submit">
			<button type="button" class="btn_buy popdef" id="bocSendButton-<?=$arParams['ELEMENT_CODE'].$element_id?>" name="send-button" onclick="bocFormSubmit('<?=$sComponentFolder?>', '<?=$required?>', '<?=$arParams["ELEMENT_CODE"]?>', '<?=$element_id?>');"><?=$arMessage["MFT_BUY"];?></button>
		</div>
	</form>
</div>