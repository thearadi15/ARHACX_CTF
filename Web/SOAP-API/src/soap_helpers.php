<?php
function soap_response($inner)
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\"?>";
echo '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">';
echo '<soapenv:Body>';
echo $inner;
echo '</soapenv:Body></soapenv:Envelope>';
exit;
}


function soap_error($msg)
{
http_response_code(500);
soap_response("<error>$msg</error>");
}

?>