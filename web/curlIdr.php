<?php 
error_reporting(0);
$data=["btcidr", "bchidr", "btgidr", "ethidr", "etcidr", "ignisidr", "ltcidr", "nxtidr", "tenidr", "wavesidr", "stridr", "xrpidr", "xzcidr"];
$ch=curl_init("https://api2.bitcoin.co.id/api/webdata/");
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
if($response){
    $result["market"]=getDataList(json_decode($response,true))  ;
}
curl_close($ch);
$i=0;
foreach ($data as $key => $market) {
        $hasil[$i]["market"] =strtoupper(substr_replace($market, "/", -3, 0));
        $hasil[$i]["code"] ="showDetail('".strtoupper($market)."')";
        $hasil[$i]["id"] =strtoupper($market);
        $hasil[$i]["prices"] =marketPrices($result["market"]["prices"][$market], substr($market, -3));
        $hasil[$i]["prices_24h"] = $result["market"]["prices_24h"][$market];
        $hasil[$i]["change"] = marketPrices(($result["market"]["prices"][$market] - $result["market"]["prices_24h"][$market]), substr($market, -3));
        $hasil[$i]["change_persen"] = number_format(( ( $result["market"]["prices"][$market] - $result["market"]["prices_24h"][$market] ) / ( $result["market"]["prices_24h"][$market])) * 100, 2  );
        $i++;
}

echo json_encode($hasil);  
        
function getDataList($data){
    $result["prices"]=$data["prices"];
    $result["prices_24h"]=$data["prices_24h"];
    return $result;
}
        
function marketPrices($data, $type){
    switch ($type) {
        case 'btc':
            $result=number_format(($data/100000000),8);
            break;
        
        default:
            $result=$data;
            break;
    }
    return $result;
}
