            // Function to fetch data about a list of movies based on a random search term
            async function fetchRandomMovies(apiKey) {
                const baseURL = 'http://www.omdbapi.com/';
                const randomSearchTerm = generateRandomSearchTerm(); // Custom function to generate a random search term
                const queryParams = `?apikey=${apiKey}&s=${randomSearchTerm}`;
            
                try {
                    const response = await fetch(baseURL + queryParams);
                    const data = await response.json();
            
                    if (response.ok && data.Response === 'True' && data.Search && data.Search.length > 0) {
                        const randomMovie = data.Search[Math.floor(Math.random() * data.Search.length)];
                        return randomMovie;
                    } else {
                        console.error(`Error: ${data.Error}`);
                        return null;
                    }
                } catch (error) {
                    console.error(`Request failed: ${error}`);
                    return null;
                }
            }
            
            // Function to fetch detailed information about a movie using its IMDb ID
            async function fetchMovieDetails(apiKey, imdbID) {
                const baseURL = 'http://www.omdbapi.com/';
                const queryParams = `?apikey=${apiKey}&i=${imdbID}`;
            
                try {
                    const response = await fetch(baseURL + queryParams);
                    const data = await response.json();
            
                    if (response.ok && data.Response === 'True') {
                        return data;
                        console.log(data.Plot);
                    } else {
                        console.error(`Error: ${data.Error}`);
                        return null;
                    }
                } catch (error) {
                    console.error(`Request failed: ${error}`);
                    return null;
                }
            }
            
            // Function to generate a random search term (you can customize this based on your needs)
            function generateRandomSearchTerm() {
                const randomWords = ['action', 'comedy', 'drama', 'thriller', 'sci-fi', 'horror'];
                return randomWords[Math.floor(Math.random() * randomWords.length)];
            }
            
            // Replace 'YOUR_API_KEY' with your actual OMDb API key
            const apiKey = '121627';
            
            // Call the function to fetch a random movie
            fetchRandomMovies(apiKey)
                .then(async randomMovieData => {
                    if (randomMovieData) {
                        console.log('Random Movie Title:', randomMovieData.Title);
                        console.log('Type:', randomMovieData.Type);
            
                        // Fetch detailed information about the selected movie
                        const detailedMovieData = await fetchMovieDetails(apiKey, randomMovieData.imdbID);
            
                        if (detailedMovieData) {
                            console.log('Poster URL:', detailedMovieData.Poster);
                            console.log('Plot:',detailedMovieData.Plot);
                            console.log('Actor',detailedMovieData.Actors);
                            console.log('Genre',detailedMovieData.Genre);
                            console.log('Director',detailedMovieData.Director);
                            let url = location.href;
                            location.href = "Display.php?Name=" + randomMovieData.Title + "&Year=" + randomMovieData.Year + "&Director=" + detailedMovieData.Director + "&Actor=" + detailedMovieData.Actors +
                            "&Genre=" + detailedMovieData.Genre + "&Plot=" + detailedMovieData.Plot + "&Poster=" + detailedMovieData.Poster + "&ImdbID=" + detailedMovieData.imdbID +"&Type=3";
                            // You can display the poster in your HTML or manipulate it further as needed
                        } else {
                            console.log('Failed to fetch detailed information about the movie.');
                        }
                    } else {
                        console.log('Failed to fetch a random movie.');
                    }
                })
                .catch(error => console.error('Error fetching random movie:', error));
            
                    