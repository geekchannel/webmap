<?
# Path where all files stored
# Example values: /home/node/results/
# Or just: xml/
# Must be readble/writable for web server! so chmod 777 xml/
define('RESULTS_PATH', 'xml/');

# Nmap string arguments for web scanning
# Example: -sV -Pn
define('NMAP_ARGS', '-sV -T5 --script=http-headers');

# Comment this line to disable web scans
define('WEB_SCANS', 'enable');

# URL of application
# for example: http://example.com/scanner/
# Or just: /scanner/
define('APP_URL', '/blacknode/');

# Secret word to protect webface (reserved)
# Uncomment to set it!
# define('secret_word', '1337passw0rd');

?>
