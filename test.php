<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("TEST");

?><?$APPLICATION->IncludeComponent("dev:example","",array('AJAX_MODE' => 'Y'));

?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>