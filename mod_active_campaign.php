<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Helper\ModuleHelper;

$url = $params->get('account_url');
$apiKey = $params->get('api_key');
$formId = $params->get('form_id');
$btnClass = $params->get('btn_class');
$replacements = $params->get('replacements');
$styleOverride = $params->get('style_override');
$aaParams = array(
    'api_key'      => $apiKey,
    'api_action'   => 'form_html',
    'api_output'   => 'json',
    'id'           => (int)$formId,
);
$query = "";
foreach ($aaParams as $key => $value) $query .= urlencode($key) . '=' . urlencode($value) . '&';
$query = rtrim($query, '& ');

// clean up the url
$url = rtrim($url, '/ ');

// This sample code uses the CURL library for php to establish a connection,
// submit your request, and show (print out) the response.
if (!function_exists('curl_init')) die('CURL not supported. (introduced in PHP 4.0.2)');

// If JSON is used, check if json_decode is present (PHP 5.2.0+)
if ($aaParams['api_output'] == 'json' && !function_exists('json_decode')) {
    die('JSON not supported. (introduced in PHP 5.2.0)');
}

// define a final API request - GET
$api = $url . '/admin/api.php?' . $query;

$request = curl_init($api); // initiate curl object
curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
//curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS
curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

$form = (string)curl_exec($request); // execute curl fetch and store results in $response
//echo $form;
// additional options may be required depending upon your server configuration
// you can find documentation on curl options at http://www.php.net/curl_setopt
curl_close($request); // close curl object

$form = str_replace('class="_submit"', 'class="' . $btnClass . '"', $form);
foreach ($replacements as $listItem) {
    //echo $listItem->original_label;
    $form = str_replace($listItem->original_label, $listItem->new_label, $form);
}

require ModuleHelper::getLayoutPath('mod_active_campaign', $params->get('layout', 'default'));

//if ( !$form) {
//    die('Nothing was returned. Do you have a connection to Email Marketing server?');
//}