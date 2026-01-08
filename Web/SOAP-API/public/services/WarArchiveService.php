<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle WSDL request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['wsdl'])) {
    header("Content-Type: text/xml");
    readfile(__DIR__ . '/../../wsdl/WarArchiveService.wsdl');
    exit;
}

// Read SOAP POST body
$rawPost = file_get_contents("php://input");

if (!$rawPost) {
    die("No SOAP request received");
}

// Parse XML
$xml = simplexml_load_string($rawPost);
$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
$xml->registerXPathNamespace('war', 'http://defense.gov.in/war');

// Extract SOAP body
$body = $xml->xpath('//soapenv:Body')[0];

// Detect method
if (isset($body->children('http://defense.gov.in/war')->getWarSummary)) {

    $year = (string)$body
        ->children('http://defense.gov.in/war')
        ->getWarSummary
        ->year;

    if ($year === "1971") {
        echo <<<XML
<?xml version="1.0"?>
<response>
  <summary>Victory in Eastern Front</summary>
  <reference>REF-1971-ALPHA</reference>
</response>
XML;
    } else {
        echo "<error>No data for this year</error>";
    }

    exit;
}

// Hidden CTF method
if (isset($body->children('http://defense.gov.in/war')->getHiddenArchive)) {

    $token = (string)$body
        ->children('http://defense.gov.in/war')
        ->getHiddenArchive
        ->token;

    // First stage
    if ($token === "REF-1971-ALPHA") {
        echo <<<XML
<response>
  <status>ACCESS_GRANTED</status>
  <archiveCode>REF-1971-ALPHA|JAIHIND</archiveCode>
  <hint>Integrity is verified using SHA1</hint>
</response>
XML;
        exit;
    }

    // Final stage
    if ($token === sha1("REF-1971-ALPHA|JAIHIND")) {
        echo <<<XML
<response>
  <flag>CTF{JAI_HIND_1971_VICTORY}</flag>
</response>
XML;
        exit;
    }

    echo "<error>Invalid token</error>";
    exit;
}

echo "<error>Invalid SOAP operation</error>";

?>