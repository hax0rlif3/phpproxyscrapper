<?php
#Saves to proxies.txt
$pattern = "/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?):\d{1,5}/";

$proxysites = array(
"http://www.example.com/",
"http://www.example.com/",
"http://www.example.com/",
"http://www.example.com/",
"http://www.example.com/",
"http://www.example.com/",
"http://www.example.com/",
);
echo "Proxy scraper developed by Andy Quez\nStarting scraper...\n";
$proxies = array();
$start = time();
foreach ($proxysites as $proxysite)
{
		$main = file_get_contents($proxysite);
		preg_match_all("/<h3 class='post-title entry-title' itemprop='name'>\n<a href='(.*?)'/", $main, $fetched, PREG_SET_ORDER);
		foreach ($fetched as $fetch) {
        $contents = file_get_contents($fetch[1]);
        preg_match_all($pattern, $contents, $matches);

        foreach ($matches[0] as $match)
        {
                $proxies[] = $match;
        }
	}
}

$proxies = array_unique($proxies);
$count = count($proxies);

$fh = fopen('proxies.txt', 'w');
fwrite($fh, implode("\n", $proxies));
fclose($fh);

echo "Succesfully scraped $count proxies in ".(time() - $start)." seconds!\n";
