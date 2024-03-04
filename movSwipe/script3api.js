const cardContainer = document.getElementById('card-container');
const tmdbApiKey = 'e698f4b66b2b715e8e77bac14c6ec11e'; // Replace with your TMDb API key

// Keep track of liked and disliked cards
let likedCards = [];
let dislikedCards = [];
let favorites = [];

async function fetchMovieGenres() {
  try {
    const url = `https://api.themoviedb.org/3/genre/movie/list?api_key=${tmdbApiKey}&language=en-US`;

    const response = await axios.get(url);
    const genres = response.data.genres;
    return genres;
  } catch (error) {
    console.error('Error fetching movie genres from TMDb API:', error);
    return [];
  }
}

async function fetchMovieDetails() {
  try {
    const movies = [];
    const genres = await fetchMovieGenres();

    for (let i = 0; i < 20; i++) {
      const randomMovie = await getRandomMovie();

      if (randomMovie) {
        const genreNames = randomMovie.genre_ids.map(genreId => {
          const genre = genres.find(genre => genre.id === genreId);
          return genre ? genre.name : 'N/A';
        }).join(', ');

        movies.push({
          title: randomMovie.title,
          year: randomMovie.release_date ? randomMovie.release_date.substring(0, 4) : 'N/A',
          poster: randomMovie.poster_path ? `https://image.tmdb.org/t/p/w500${randomMovie.poster_path}` : 'Noposter.png',
          genres: genreNames,
        });
      }
    }
    return movies;
  } catch (error) {
    console.error('Error fetching movie details from TMDb API:', error);
    return [];
  }
}

async function getRandomMovie() {
  while (true) {
    const randomPage = Math.floor(Math.random() * 500) + 1; // Adjust the range based on your needs
    const tmdbUrl = `https://api.themoviedb.org/3/discover/movie?api_key=${tmdbApiKey}&language=en-US&page=${randomPage}`;

    try {
      const response = await axios.get(tmdbUrl);
      const movies = response.data.results;

      if (movies.length > 0) {
        const randomIndex = Math.floor(Math.random() * movies.length);
        return movies[randomIndex];
      } else {
        console.log('No movies found on this page. Trying another page.');
      }
    } catch (error) {
      console.error('Error:', error.message);
      // Handle API request errors
    }
  }
}

function initializeCards() {
  fetchMovieDetails().then((movies) => {
    const shuffledMovies = shuffleArray(movies);
    let currentMovieIndex = 0;

    shuffledMovies.forEach((movie, index) => {
      const title = movie.title;
      const year = movie.year;
      const poster = movie.poster;
      const genres = movie.genres;

      const card = document.createElement('div');
      card.className = 'card';
      card.innerHTML = `
        </div>
        <img src="${poster}" alt="Movie Poster" class="card-image">
        <div class="text-container">
          <div class="card-details">
            <div class="title">${title}</div>
            <div class="year">${year}</div>
            <div class="genres">${genres}</div>
          </div>
        </div>
      `;
      cardContainer.appendChild(card);

      if (index === 0) {
        card.classList.add('active');
        card.style.zIndex = shuffledMovies.length + 1;
      } else {
        card.style.zIndex = shuffledMovies.length - index;
      }
    });

    const cards = document.querySelectorAll('.card');
    let isDragging = false;
    let startX, currentX, offsetX;

    cards.forEach((card, index) => {
      card.addEventListener('mousedown', (e) => startDrag(e, card));
      card.addEventListener('touchstart', (e) => startDrag(e, card));
    });

    document.addEventListener('mousemove', drag);
    document.addEventListener('touchmove', drag);

    document.addEventListener('mouseup', stopDrag);
    document.addEventListener('touchend', stopDrag);

    function startDrag(e, card) {
      if (isDragging) return;

      isDragging = true;
      startX = e.type === 'mousedown' ? e.clientX : e.touches[0].clientX;
      currentX = 0;
      offsetX = 0;

      card.style.transition = 'none';
    }

    function drag(e) {
      if (!isDragging) return;

      const clientX = e.type === 'mousemove' ? e.clientX : e.touches[0].clientX;
      offsetX = clientX - startX;

      const translateX = offsetX + currentX;

      const frontCard = document.querySelector('.card.active');

      if (frontCard) {
        frontCard.style.transform = `translateX(${translateX}px) rotate(${offsetX / 10}deg)`;
      }
    }

    function stopDrag() {
      if (!isDragging) return;

      isDragging = false;

      const threshold = 100;

      if (Math.abs(offsetX) > threshold) {
        const frontCard = document.querySelector('.card.active');
        if (frontCard) {
          frontCard.classList.remove('active');
          frontCard.remove();

          const nextCard = document.querySelector('.card:not(.active)');
          if (nextCard) {
            currentMovieIndex++;
            if (currentMovieIndex >= shuffledMovies.length) {
              currentMovieIndex = 0;
            }

            nextCard.querySelector('.card-image').src = shuffledMovies[currentMovieIndex].poster;
            nextCard.querySelector('.title').innerText = shuffledMovies[currentMovieIndex].title;
            nextCard.querySelector('.year').innerText = shuffledMovies[currentMovieIndex].year;
            nextCard.querySelector('.genres').innerText = shuffledMovies[currentMovieIndex].genres;
            nextCard.style.zIndex = shuffledMovies.length + 1;
            nextCard.classList.add('active');
          }
        }
      }

      cards.forEach((card) => {
        card.style.transition = 'transform 0.3s ease-in-out';
        card.style.transform = 'none';
      });

      setTimeout(() => {
        cards.forEach((card) => {
          card.style.transition = 'none';
        });
      }, 300);
    }
  });
}

function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

initializeCards();