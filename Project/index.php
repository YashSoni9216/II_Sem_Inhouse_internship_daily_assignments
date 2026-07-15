<?php

session_start();

function saveToHistory($word) {
    if (!empty($word)) {
        $file = 'history.txt';
        
        $word = htmlspecialchars(trim($word));
        
        
        $existing = file_exists($file) ? file_get_contents($file) : '';
        if (strpos($existing, $word) === false) {
            file_put_contents($file, $word . "\n", FILE_APPEND);
        }
    }
}


$searchedWord = "";
if (isset($_GET['word'])) {
    $searchedWord = $_GET['word'];
    saveToHistory($searchedWord);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictionary Word Explorer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <header>
            <h1>🔠 DICTIONARY WORD EXPLORER &hearts;</h1>
            <p>~Find definitions, synonyms, and parts of speech instantly~</p>
        </header>

        <div class="search-box">
            <input type="text" id="wordInput" placeholder="Type a word here.__." value="<?php echo urlencode($searchedWord); ?>">
            <button id="searchBtn">Search</button>
        </div>

        <div id="loading" class="hidden">Searching the web...</div>

        <div id="errorMessage" class="error-box hidden"></div>

        <div id="resultContainer" class="result-box hidden">
            <div class="result-header">
                <h2 id="resultWord">Word</h2>
                <span id="phonetic">/phonetic/</span>
            </div>
            
            <hr>

            <div class="result-body">
                <p><strong>Part of Speech:</strong> <span id="partOfSpeech">Noun</span></p>
                <p><strong>Definition:</strong></p>
                <blockquote id="definition">Word definition goes here...</blockquote>
                
                <p><strong>Example:</strong> <em id="example">Example sentence goes here...</em></p>
                
                <div id="synonymSection">
                    <p><strong>Synonyms:</strong> <span id="synonyms">None</span></p>
                </div>
            </div>
        </div>

        <div class="history-box">
            <h3>📜 Recent Searches</h3>
            <ul>
                <?php
                $file = 'history.txt';
                if (file_exists($file)) {
                    $lines = file($file);
                    
                    $lines = array_reverse($lines);
                    $count = 0;
                    foreach ($lines as $line) {
                        if ($count < 5 && trim($line) != "") {
                            echo "<li><a href='?word=" . trim($line) . "'>" . htmlspecialchars(trim($line)) . "</a></li>";
                            $count++;
                        }
                    }
                } else {
                    echo "<li>No recent searches yet.</li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <footer>
        <h2>~Submitted by: YASH SONI(25ESKCX123) &hearts;| II Semester Inhouse Internship Project⭐~</h2>
    </footer>

    <script src="script.js"></script>
</body>
</html>
