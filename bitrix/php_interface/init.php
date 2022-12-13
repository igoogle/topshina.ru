<?
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/config/const.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/config/const.php");

function loadIncludes(){
    $includeFiles = scandir($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include_function/");

    foreach ($includeFiles as $include) :
        if ($include == "." || $include == "..") {
            continue;
        }
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include_function/" . $include)) {
            require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include_function/" . $include);
        }
    endforeach;
}

loadIncludes();

if (!function_exists('custom_mail') && COption::GetOptionString("webprostor.smtp", "USE_MODULE") == "Y")
{
    function custom_mail($to, $subject, $message, $additional_headers='', $additional_parameters='')
    {
        if(CModule::IncludeModule("webprostor.smtp"))
        {
            $smtp = new CWebprostorSmtp(SITE_ID);
            $result = $smtp->SendMail($to, $subject, $message, $additional_headers, $additional_parameters);

            if($result)
                return true;
            else
                return false;
        }
    }
}
