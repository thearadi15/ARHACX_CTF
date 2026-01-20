<?php
// operations.php — returns XML strings used by service

function getWarSummaryResponse($year) {
    // provide small tilted hint about the salt
    $reference = sprintf('REF-%d-ALPHA', $year);
    $summary = 'Victory achieved. Remember the nation\'s colors.';
    return <<<XML
<getWarSummaryResponse xmlns="http://defense.gov.in/war">
  <summary>{$summary}</summary>
  <reference>{$reference}</reference>
</getWarSummaryResponse>
XML;
}

function listOperationsResponse() {
    return <<<XML
<listOperationsResponse xmlns="http://defense.gov.in/war">
  <operation>Operation Vijay</operation>
  <operation>Operation Trishul</operation>
</listOperationsResponse>
XML;
}



function getHiddenArchiveResponse($authHash) {
    $expected_ref = sprintf('REF-%d-ALPHA', REF_YEAR);
    $expected = sha1($expected_ref . SALT);

    if ($authHash !== '' && hash_equals($expected, $authHash)) {
        return
            '<getHiddenArchiveResponse xmlns="http://defense.gov.in/war">' .
            '<secret>Access granted. Secret recovered: ' . FLAG . '</secret>' .
            '</getHiddenArchiveResponse>';
    }

    // gentle tilt for beginners
    return
        '<getHiddenArchiveResponse xmlns="http://defense.gov.in/war">' .
        '<secret>
        Access denied. 
        Maybe Reference Could Help.
        Also think of combing the nation it belongs to three colors, one order, all capitals.
        Old SOAP services preferred legacy hashing.
        </secret>' .
        '</getHiddenArchiveResponse>';
}


?>