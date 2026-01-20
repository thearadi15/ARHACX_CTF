<?php

ini_set('display_errors', 0);
error_reporting(0);


   //Serve WSDL if requested
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['wsdl'])) {
    header('Content-Type: text/xml');
    $wsdl = __DIR__ . '/../../wsdl/WarArchiveService.wsdl';
    if (is_readable($wsdl)) {
        readfile($wsdl);
        exit;
    }
    echo '<?xml version="1.0"?><error>WSDL not found</error>';
    exit;
}


   //Load core files
require_once __DIR__ . '/../../src/config.php';
require_once __DIR__ . '/../../src/soap_helpers.php';
require_once __DIR__ . '/../../src/operations.php';


   //Read raw SOAP request
$raw = file_get_contents('php://input');
if (!$raw) {
    header('Content-Type: text/xml');
    echo '<error>No SOAP request received</error>';
    exit;
}


   //Parse XML
libxml_disable_entity_loader(true);
$xml = @simplexml_load_string($raw);
if (!$xml) {
    header('Content-Type: text/xml');
    echo '<error>Malformed XML</error>';
    exit;
}


   //FIND SOAP BODY
$body = null;

$namespaces = $xml->getNamespaces(true);
foreach (['soapenv', 'soap'] as $p) {
    if (isset($namespaces[$p])) {
        $soap = $xml->children($namespaces[$p]);
        if (isset($soap->Body)) {
            $body = $soap->Body;
            break;
        }
    }
}


if (!$body) {
    foreach ($xml->children() as $child) {
        if (strcasecmp($child->getName(), 'Body') === 0) {
            $body = $child;
            break;
        }
        if (strcasecmp($child->getName(), 'Envelope') === 0) {
            foreach ($child->children() as $c) {
                if (strcasecmp($c->getName(), 'Body') === 0) {
                    $body = $c;
                    break 2;
                }
            }
        }
    }
}

if (!$body) {
    $stack = [$xml];
    while ($stack && !$body) {
        $node = array_pop($stack);
        foreach ($node->children() as $ch) {
            if (strcasecmp($ch->getName(), 'Body') === 0) {
                $body = $ch;
                break 2;
            }
            $stack[] = $ch;
        }
    }
}

if (!$body) {
    header('Content-Type: text/xml');
    echo '<error>No SOAP Body</error>';
    exit;
}


   //Extract operation
$operation = null;
foreach ($body->children() as $child) {
    $operation = $child;
    break;
}

if (!$operation) {
    header('Content-Type: text/xml');
    echo '<error>No operation provided</error>';
    exit;
}

$opName = $operation->getName();
header('Content-Type: text/xml');


   //ROUTING

if (stripos($opName, 'getWarSummary') !== false) {
    $year = isset($operation->year) ? trim((string)$operation->year) : '';
    if ($year !== (string)REF_YEAR) {
        echo '<error>No data for this year</error>';
        exit;
    }
    echo getWarSummaryResponse((int)$year);
    exit;
}

if (stripos($opName, 'listOperations') !== false) {
    echo listOperationsResponse();
    exit;
}

//HIDDEN METHOD
if (stripos($opName, 'getHiddenArchive') !== false) {
    $authHash = isset($operation->authHash)
        ? trim((string)$operation->authHash)
        : '';
    echo getHiddenArchiveResponse($authHash);
    exit;
}

echo '<error>Unknown operation</error>';
exit;

?>