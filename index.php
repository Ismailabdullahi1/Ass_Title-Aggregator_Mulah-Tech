

<?php
function fetchArticlesFromRSS() {
    $rssUrl = "https://www.wired.com/feed/rss";
    $rss = simplexml_load_file($rssUrl);

    $articles = [];

    foreach ($rss->channel->item as $item) {
        $title = (string) $item->title;
        $link = (string) $item->link;
        $pubDate = strtotime($item->pubDate); // Convert to timestamp

        // Debugging - Output the pubDate to see what's being fetched
        echo "Pub Date: " . date("Y-m-d H:i:s", $pubDate) . "<br>";  // Add this to check the dates being processed

        // Filter articles from Jan 1, 2022 onwards
        if ($pubDate >= strtotime("2022-01-01")) {
            $articles[] = [
                'title' => $title,
                'url' => $link,
                'date' => $pubDate
            ];
        }
    }

    // Sort anti-chronologically (latest first)
    usort($articles, fn($a, $b) => $b['date'] <=> $a['date']);
    return $articles;
}

$articles = fetchArticlesFromRSS();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ISMAIL-2nd Ass -Mulah Tech</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f7fa;
            color: #333;
            font-family: 'Roboto', sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1rem;
            line-height: 1.6;
        }

        h1 {
            font-size: 3rem;
            text-align: center;
            color: #333;
            margin-bottom: 2rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin-bottom: 2rem;
        }

        li {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            padding: 1.2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        li:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        a {
            color: #333;
            font-size: 1.25rem;
            font-weight: 500;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #2d72d9;
            text-decoration: underline;
        }

        .date {
            font-size: 0.95rem;
            color: #888;
            margin-top: 0.5rem;
        }

        header {
            text-align: center;
            padding: 2rem;
            background-color: #2d72d9;
            color: white;
            border-radius: 10px;
            margin-bottom: 3rem;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            body {
                padding: 2rem 1rem;
            }

            h1 {
                font-size: 2.5rem;
            }

            ul {
                padding-left: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Wired Headlines (From Jan 1, 2022)</h1>
        <p> the latest articles from Wired</p>
    </header>

    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <a href="<?= htmlspecialchars($article['url']) ?>" target="_blank">
                    <?= htmlspecialchars($article['title']) ?>
                </a>
                <span class="date"><?= date("F j, Y", $article['date']) ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

<!-- Done  -->
