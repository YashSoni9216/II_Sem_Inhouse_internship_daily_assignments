document.addEventListener("DOMContentLoaded", function() {
    const searchBtn = document.getElementById("searchBtn");
    const wordInput = document.getElementById("wordInput");
    const resultContainer = document.getElementById("resultContainer");
    const loadingDiv = document.getElementById("loading");
    const errorDiv = document.getElementById("errorMessage");

    
    const resultWord = document.getElementById("resultWord");
    const phonetic = document.getElementById("phonetic");
    const partOfSpeech = document.getElementById("partOfSpeech");
    const definition = document.getElementById("definition");
    const example = document.getElementById("example");
    const synonyms = document.getElementById("synonyms");

    
    searchBtn.addEventListener("click", function() {
        const word = wordInput.value.trim();
        if (word === "") {
            alert("Please enter a word to search!");
            return;
        }
        fetchWordData(word);
    });

    
    wordInput.addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
            searchBtn.click();
        }
    });

    
    const urlParams = new URLSearchParams(window.location.search);
    const wordParam = urlParams.get('word');
    if (wordParam) {
        wordInput.value = decodeURIComponent(wordParam);
        fetchWordData(wordParam);
    }

    
    function fetchWordData(word) {
        
        loadingDiv.classList.remove("hidden");
        resultContainer.classList.add("hidden");
        errorDiv.classList.add("hidden");

        const apiUrl = `https://api.dictionaryapi.dev/api/v2/entries/en/${word}`;

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Word not found in database.");
                }
                return response.json();
            })
            .then(data => {
                
                loadingDiv.classList.add("hidden");

                
                const wordInfo = data[0];
                const meaningInfo = wordInfo.meanings[0];
                const definitionInfo = meaningInfo.definitions[0];

                
                resultWord.textContent = wordInfo.word;
                phonetic.textContent = wordInfo.phonetic || "N/A";
                partOfSpeech.textContent = meaningInfo.partOfSpeech;
                definition.textContent = definitionInfo.definition;
                
                
                if (definitionInfo.example) {
                    example.textContent = `"${definitionInfo.example}"`;
                } else {
                    example.textContent = "No example available for this meaning.";
                }

               
                if (meaningInfo.synonyms && meaningInfo.synonyms.length > 0) {
                    synonyms.textContent = meaningInfo.synonyms.slice(0, 4).join(", ");
                } else {
                    synonyms.textContent = "None found.";
                }

                
                resultContainer.classList.remove("hidden");

                
                fetch(`index.php?word=${encodeURIComponent(word)}`);
            })
            .catch(error => {
                loadingDiv.classList.add("hidden");
                errorDiv.textContent = error.message;
                errorDiv.classList.remove("hidden");
            });
    }
});