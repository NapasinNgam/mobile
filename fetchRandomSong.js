
async function fetchRandomMusicWithYouTubeLink() {
    const iTunesApiUrl = 'https://itunes.apple.com/search';
    const term = 'music'; // You can adjust the search term as needed
    const mediaType = 'music';
    const limit = 100; // Number of results per page (adjust as needed)

    try {
        const response = await axios.get(iTunesApiUrl, {
            params: {
                term,
                media: mediaType,
                limit,
            },
        });

        const musicResults = response.data.results;

        if (musicResults.length > 0) {
            // Shuffle the array to get a random order
            const shuffledMusicResults = shuffleArray(musicResults);

            // Select the first item (randomly shuffled) from the array
            const randomTrack = shuffledMusicResults[0];

            // Fetch YouTube video link using another API or method
            const youtubeLink = await fetchYouTubeLink(randomTrack.trackName, randomTrack.artistName);

            console.log('Random Music Information:');
            console.log(`Track Name: ${randomTrack.trackName}`);
            console.log(`Artist Name: ${randomTrack.artistName}`);
            console.log(`Album Name: ${randomTrack.collectionName}`);
            console.log(`Genre: ${randomTrack.primaryGenreName}`);
            
            // Check if artworkUrl100 is available before trying to access it
            if (randomTrack.artworkUrl100) {
                console.log(`Album Image URL (100x100): ${randomTrack.artworkUrl100}`);
            } else {
                console.log('Album Image URL (100x100) Not Available');
            }
            
            console.log(`YouTube Video Link: ${youtubeLink}`);
            console.log(`Preview: ${randomTrack.previewUrl}`);
            console.log('------------------------');
            let url = location.href;
            location.href = "Display.php?Name=" + randomTrack.trackName + "&Artist=" + randomTrack.artistName + "&Genre=" + randomTrack.primaryGenreName + "&Album=" + randomTrack.collectionName +
            "&Poster=" + randomTrack.artworkUrl100 + "&Youtube=" + youtubeLink +  "&Preview=" + randomTrack.previewUrl +"&Type=1";
        } else {
            console.log('No music found.');
        }
    } catch (error) {
        console.error(`Error fetching music data: ${error.message}`);
    }
}

// Fisher-Yates shuffle algorithm to shuffle the array
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

// Fetch YouTube video link using YouTube Data API
async function fetchYouTubeLink(trackName, artistName) {
    try {
        const youtubeResponse = await axios.get('https://www.googleapis.com/youtube/v3/search', {
            params: {
                q: `${trackName} ${artistName}`,
                type: 'video',
                key: 'AIzaSyBQZBmX4LhiscdwSMv8HgmmLhiRPhvy7Nk', // Replace with your actual YouTube Data API key
            },
        });

        const videoId = youtubeResponse.data.items[0]?.id.videoId;
        if (videoId) {
            return `https://www.youtube.com/watch?v=${videoId}`;
        } else {
            return 'YouTube Video Link Not Available';
        }
    } catch (error) {
        console.error(`Error fetching YouTube video link: ${error.message}`);
        return 'YouTube Video Link Not Available';
    }
}

