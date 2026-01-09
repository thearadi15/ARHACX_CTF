<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>War Archive Portal - Republic Day</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif;
      background: #f8f9fa;
      color: #212529;
      line-height: 1.6;
    }
    
    .container {
      max-width: 900px;
      margin: 0 auto;
      background: white;
      min-height: 100vh;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }
    
    header {
      background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
      color: white;
      padding: 2.5rem 2rem;
      border-bottom: 3px solid #ff6f00;
    }
    
    h1 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .subtitle {
      color: rgba(255,255,255,0.9);
      font-size: 0.95rem;
    }
    
    main {
      padding: 2rem;
    }
    
    .welcome {
      background: #e3f2fd;
      border-left: 4px solid #1976d2;
      padding: 1.25rem;
      margin-bottom: 2rem;
      border-radius: 4px;
    }
    
    h2 {
      color: #1a237e;
      font-size: 1.4rem;
      margin: 2rem 0 1rem 0;
      padding-bottom: 0.5rem;
      border-bottom: 2px solid #e0e0e0;
    }
    
    ul {
      list-style: none;
      margin: 1.5rem 0;
    }
    
    li {
      background: #fafafa;
      border: 1px solid #e0e0e0;
      padding: 1rem 1.25rem;
      margin: 0.75rem 0;
      border-radius: 4px;
      transition: all 0.2s;
    }
    
    li:hover {
      background: #f5f5f5;
      border-color: #1976d2;
      transform: translateX(4px);
    }
    
    strong {
      color: #1a237e;
      font-family: 'Courier New', monospace;
      font-size: 1.05rem;
    }
    
    .param {
      color: #d84315;
    }
    
    .restricted {
      background: #fff3e0;
      border-left: 4px solid #ff6f00;
      padding: 1rem 1.25rem;
      margin: 2rem 0;
      border-radius: 4px;
      color: #e65100;
    }
    
    footer {
      background: #263238;
      color: #b0bec5;
      padding: 1.5rem 2rem;
      text-align: center;
      font-size: 0.9rem;
      margin-top: 3rem;
    }
    
    footer small {
      display: block;
      margin-top: 0.5rem;
      color: #78909c;
      font-size: 0.85rem;
    }
    
    .comment {
      color: #757575;
      font-size: 0.85rem;
      font-style: italic;
      margin-top: 0.5rem;
    }
    
    .method-link {
      cursor: pointer;
      color: #1a237e;
      text-decoration: none;
      display: inline-block;
    }
    
    .method-link:hover {
      color: #1976d2;
    }
    
    .soap-example {
      display: none;
      background: #263238;
      color: #aed581;
      padding: 1rem;
      margin-top: 1rem;
      border-radius: 4px;
      font-family: 'Courier New', monospace;
      font-size: 0.9rem;
      line-height: 1.6;
      overflow-x: auto;
      border: 2px solid #1976d2;
    }
    
    .soap-example.active {
      display: block;
      animation: slideDown 0.3s ease;
    }
    
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .xml-tag {
      color: #81c784;
    }
    
    .xml-attr {
      color: #ffb74d;
    }
    
    .xml-value {
      color: #fff59d;
    }
    
    .xml-comment {
      color: #90a4ae;
      font-style: italic;
    }
    
    .copy-btn {
      background: #1976d2;
      color: white;
      border: none;
      padding: 0.4rem 1rem;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.85rem;
      margin-top: 0.5rem;
    }
    
    .copy-btn:hover {
      background: #1565c0;
    }
    
    .copy-btn:active {
      background: #0d47a1;
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>War Archive Portal</h1>
      <p class="subtitle">Republic Day 2026 - Historical SOAP Service</p>
    </header>
    
    <main>
      <div class="welcome">
        <strong>Welcome.</strong> For Republic Day, a small public SOAP subset is exposed for historians and researchers.
      </div>
      
      <h2>Public Methods (Documentation)</h2>
      <ul>
        <li>
          <span class="method-link" onclick="toggleSoap('soap1')">
            <strong>getWarSummary(<span class="param">year</span>)</strong>
          </span>
          <div class="comment">Returns a short summary and a reference identifier for the requested year.</div>
          <div id="soap1" class="soap-example">
<span class="xml-tag">&lt;?xml version=<span class="xml-value">"1.0"</span> encoding=<span class="xml-value">"UTF-8"</span>?&gt;</span>
<span class="xml-tag">&lt;Envelope</span> <span class="xml-attr">xmlns</span>=<span class="xml-value">"http://schemas.xmlsoap.org/soap/envelope/"</span><span class="xml-tag">&gt;</span>
  <span class="xml-tag">&lt;Body&gt;</span>
    <span class="xml-tag">&lt;getWarSummary</span> <span class="xml-attr">xmlns</span>=<span class="xml-value">"http://defense.gov.in/war"</span><span class="xml-tag">&gt;</span>
      <span class="xml-tag">&lt;year&gt;</span><span class="xml-tag">&lt;/year&gt;</span> <span class="xml-comment"></span>
    <span class="xml-tag">&lt;/getWarSummary&gt;</span>
  <span class="xml-tag">&lt;/Body&gt;</span>
<span class="xml-tag">&lt;/Envelope&gt;</span>
            <button class="copy-btn" onclick="copySoap('soap1')">Copy SOAP Request</button>
          </div>
        </li>
        <li>
          <span class="method-link" onclick="toggleSoap('soap2')">
            <strong>listOperations()</strong>
          </span>
          <div class="comment">Lists known operation code names.</div>
          <div id="soap2" class="soap-example">
<span class="xml-tag">&lt;?xml version=<span class="xml-value">"1.0"</span> encoding=<span class="xml-value">"UTF-8"</span>?&gt;</span>
<span class="xml-tag">&lt;Envelope</span> <span class="xml-attr">xmlns</span>=<span class="xml-value">"http://schemas.xmlsoap.org/soap/envelope/"</span><span class="xml-tag">&gt;</span>
  <span class="xml-tag">&lt;Body&gt;</span>
    <span class="xml-tag">&lt;listOperations</span> <span class="xml-attr">xmlns</span>=<span class="xml-value">"http://defense.gov.in/war"</span><span class="xml-tag">/&gt;</span>
  <span class="xml-tag">&lt;/Body&gt;</span>
<span class="xml-tag">&lt;/Envelope&gt;</span>
            <button class="copy-btn" onclick="copySoap('soap2')">Copy SOAP Request</button>
          </div>
        </li>
      </ul>
      
      <div class="restricted">
        <strong>Note:</strong> Internal methods are restricted to defense analysts.
      </div>
    </main>
    
    <footer>
      National Digital Defense - Archive Maintenance
    </footer>
  </div>
  
  <script>
    function toggleSoap(id) {
      var element = document.getElementById(id);
      if (element.classList.contains('active')) {
        element.classList.remove('active');
      } else {
        element.classList.add('active');
      }
    }
    
    function copySoap(id) {
      var cleanXml = '';
      
      if (id === 'soap1') {
        cleanXml = '&lt;?xml version="1.0" encoding="UTF-8"?>\n';
        cleanXml += '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">\n';
        cleanXml += '  <Body>\n';
        cleanXml += '    <getWarSummary xmlns="http://defense.gov.in/war">\n';
        cleanXml += '      <year></year>\n';
        cleanXml += '    </getWarSummary>\n';
        cleanXml += '  </Body>\n';
        cleanXml += '</Envelope>';
      } else if (id === 'soap2') {
        cleanXml = '&lt;?xml version="1.0" encoding="UTF-8"?>\n';
        cleanXml += '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">\n';
        cleanXml += '  <Body>\n';
        cleanXml += '    <listOperations xmlns="http://defense.gov.in/war"/>\n';
        cleanXml += '  </Body>\n';
        cleanXml += '</Envelope>';
      }
      
      var temp = document.createElement('textarea');
      temp.value = cleanXml;
      temp.style.position = 'fixed';
      temp.style.left = '-9999px';
      document.body.appendChild(temp);
      temp.select();
      
      try {
        document.execCommand('copy');
        var element = document.getElementById(id);
        var btn = element.querySelector('.copy-btn');
        var originalText = btn.textContent;
        btn.textContent = 'Copied!';
        btn.style.background = '#4caf50';
        
        setTimeout(function() {
          btn.textContent = originalText;
          btn.style.background = '#1976d2';
        }, 2000);
      } catch (err) {
        alert('Failed to copy');
      }
      
      document.body.removeChild(temp);
    }
  </script>
  
  <!-- WSDL is enabled for developers at /services/WarArchiveService.php?wsdl. Do not publish in production -->
</body>
</html>