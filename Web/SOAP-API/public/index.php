<?php
require_once __DIR__ . '/../src/config.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>War Archive Portal – Republic Day</title>
</head>
<body>
<h1>🇮🇳 War Archive Portal</h1>
<p>Read-only SOAP access granted for Republic Day archives.</p>


<h3>Available Methods (Public Documentation)</h3>
<ul>
<li><b>getWarSummary(year)</b></li>
<li><b>listOperations()</b></li>
</ul>


<p>Internal methods are restricted to Defense Analysts.</p>


<!--
Hidden from UI but visible to source viewers.


WSDL is available but not rendered correctly by the browser.
Try looking deeper.


/services/WarArchiveService?wsdl
-->
</body>
</html>