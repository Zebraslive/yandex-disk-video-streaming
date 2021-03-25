<?php
function get_datax($url) {
    $ch = curl_init();
    $timeout = 50;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
function get_redifet($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $headers = curl_exec($ch);
    curl_close($ch);
    // Check if there's a Location: header (redirect)
    if (preg_match('/^Location: (.+)$/im', $headers, $matches))
        return trim($matches[1]);
    // If not, there was no redirect so return the original URL
    // (Alternatively change this to return false)
    return $url;
}
function yandex($url) {
     $ch = curl_init();
    $timeout = 50;
    curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT,
    "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:69.0) Gecko/20100101 Firefox/69.0");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    $scriptx = "";
$internalErrors = libxml_use_internal_errors(true);
$dom = new DOMDocument();
@$dom->loadHTML($data);
foreach($dom->getElementsByTagName('script') as $k => $js) {
    if ($js->getAttribute('id') === "store-prefetch") {
        $scriptx = $js->nodeValue; //append all js into variable.
    }


}
    $soxi = json_decode($scriptx, true);
$sk = $soxi['environment']['sk'];

$rootsourceId = $soxi['rootResourceId'];
$hash = urlencode($soxi['resources'][$rootsourceId]['hash']);
$obj = '{"hash":"'.$hash.'","sk":"'.$sk.'"}';

$download_link = get_datax('https://cloud-api.yandex.net/v1/disk/public/resources/download?public_key='.$hash.'');
$soi = json_decode($download_link, true);
return get_redifet($soi['href']);
}

echo yandex('https://disk.yandex.com/i/3UPrkmJrL2Ehaw');
?>
