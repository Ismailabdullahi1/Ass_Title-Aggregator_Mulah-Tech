


<?php
function fetchArticles() {
    $url = 'https://www.wired.com/most-recent/';
    $html = file_get_contents($url);
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $items = $xpath->query("//li[contains(@class, 'archive-item-component')]");

    $articles = [];

    foreach ($items as $item) {
        $title = $xpath->query(".//h2", $item)[0]->nodeValue ?? '';
        $link = $xpath->query(".//a", $item)[0]->getAttribute('href') ?? '';
        $dateEl = $xpath->query(".//time", $item)[0];

        if ($dateEl) {
            $date = $dateEl->getAttribute('datetime');
            $dateObj = new DateTime($date);
            if ($dateObj >= new DateTime('2022-01-01')) {
                $articles[] = [
                    'title' => trim($title),
                    'url' => 'https://www.wired.com' . $link,
                    'date' => $dateObj
                ];
            }
        }
    }

    // Sort anti-chronologically
    usort($articles, fn($a, $b) => $b['date'] <=> $a['date']);
    return $articles;
}

$articles = fetchArticles();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Wired Title Aggregator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Wired Headlines (From Jan 1, 2022)</h1>
    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <a href="<?= htmlspecialchars($article['url']) ?>" target="_blank">
                    <?= htmlspecialchars($article['title']) ?>
                </a>
                <small>(<?= $article['date']->format('Y-m-d') ?>)</small>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
