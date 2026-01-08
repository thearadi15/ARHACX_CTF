<?php
function getWarSummary($year)
{
$ref = 'REF-' . $year . '-ALPHA';
return "<getWarSummaryResponse xmlns=\"http://defense.gov.in/war\">
<summary>Victory achieved. Remember the nation’s colors.</summary>
<reference>$ref</reference>
</getWarSummaryResponse>";
}


function listOperations()
{
return "<listOperationsResponse xmlns=\"http://defense.gov.in/war\">
<operation>Operation Vijay</operation>
<operation>Operation Trishul</operation>
</listOperationsResponse>";
}


function getHiddenArchive($hash)
{
$expected = sha1('REF-' . REF_YEAR . '-ALPHA' . SALT);
if ($hash === $expected) {
return "<getHiddenArchiveResponse xmlns=\"http://defense.gov.in/war\">
<secret>Access Granted: " . FLAG . "</secret>
</getHiddenArchiveResponse>";
}
return "<getHiddenArchiveResponse xmlns=\"http://defense.gov.in/war\">
<secret>Access denied. Combine reference with patriotism.</secret>
</getHiddenArchiveResponse>";
}

?>