// Featured slider data and navigation
const featuredGames = [
  {
    img: 'img/TOK slider.jpg',
    title: 'Legend of Zelda: Tears of the Kingdom',
    screenshots: [
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg',
      'img/Marjora Mask Slider.jpg'
    ],
    tags: ['Adventure', 'Open World', 'Fantasy', 'Single Player'],
    recommend: ['Adventure', 'Open World'],
    price: '$69.99'
  },
  {
    img: 'img/OOT slider.jpg',
    title: 'Legend of Zelda: Ocarina of Time',
    screenshots: [
      'img/TOK slider.jpg',
      'img/BOTW slider.jpg',
      'img/Marjora Mask Slider.jpg'
    ],
    tags: ['Adventure', 'Classic', 'Fantasy', 'Single Player'],
    recommend: ['Adventure', 'Classic'],
    price: '$19.99'
  },
  {
    img: 'img/LOZ-BOTW slider.png',
    title: 'Legend of Zelda: Breath of the Wild',
    screenshots: [
      'img/TOK slider.jpg',
      'img/OOT slider.jpg',
      'img/Marjora Mask Slider.jpg'
    ],
    tags: ['Adventure', 'Open World', 'Fantasy', 'Single Player'],
    recommend: ['Adventure', 'Open World'],
    price: '$49.99'
  },
  {
    img: 'img/Sekiro.jpg',
    title: 'Sekiro Shadows Die Twice',
    screenshots: [
      'img/TOK slider.jpg',
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg'
    ],
    tags: ['Souls-like', 'Stealth', 'Third Person', 'Single Player'],
    recommend: ['Souls-like', 'Stealth'],
    price: '$59.99'
  },
  {
    img: 'img/Mario Kart.png',
    title: 'Mario Kart World',
    screenshots: [
      'img/TOK slider.jpg',
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg'
    ],
    tags: ['Racing', 'Multiplayer', 'Family', 'Party'],
    recommend: ['Racing', 'Multiplayer'],
    price: '$79.99'
  },
  {
    img: 'img/COD-modern warfare1.png',
    title: 'Call of Duty: Modern Warfare',
    screenshots: [
      'img/TOK slider.jpg',
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg'
    ],
    tags: ['Action', 'Shooter', 'Multiplayer', 'Single Player'],
    recommend: ['Action', 'Shooter'],
    price: '$59.99'
  },
  {
    img: 'img/WorldWarZ1.png',
    title: 'World War Z',
    screenshots: [
      'img/TOK slider.jpg',
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg'
    ],
    tags: ['Action', 'Zombie', 'Post-Apocalypse', 'Co-op'],
    recommend: ['Action', 'Zombie'],
    price: '$29.99'
  },
  {
    img: 'img/FinalFantasy1.png', 
    title: 'Final Fantasy XVI',
    screenshots: [
      'img/TOK slider.jpg',
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg'
    ],
    tags: ['RPG', 'Fantasy', 'Single Player', 'Story Rich'],
    recommend: ['RPG', 'Fantasy'],
    price: '$49.99'
  },
  {
    img: 'img/Mech.png',
    title: 'Mech Battle',
    screenshots: [
      'img/TOK slider.jpg', 
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg'
    ],
    tags: ['Action', 'Mech', 'Multiplayer', 'Strategy'],
    recommend: ['Action', 'Mech'],
    price: '$19.99'
  },
  {
    img: 'img/Pixel.png',
    title: 'Pixel Quest',
    screenshots: [
      'img/TOK slider.jpg',
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg'
    ],
    tags: ['Adventure', 'Retro-style', 'Puzzle', 'Single Player'],
    recommend: ['Adventure', 'RPG'],
    price: '$4.99'
  },
  {
    img: 'img/LittleNightmare.png',
    title: 'Little Nightmares',
    screenshots: [
      'img/TOK slider.jpg',
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg'
    ],
    tags: ['Horror', 'Puzzle', 'Platformer', 'Single Player'],
    recommend: ['Horror', 'Puzzle'],
    price: '$14.99'
  },
  {
    img: 'img/LittleNightmare2.png',
    title: 'Little Nightmares II',
    screenshots: [
      'img/TOK slider.jpg',
      'img/OOT slider.jpg',
      'img/BOTW slider.jpg'
    ],
    tags: ['Horror', 'Puzzle', 'Platformer', 'Single Player'],
    recommend: ['Horror', 'Puzzle'],
    price: '$19.99'
  }
];

let featuredIndex = 0;
let sliderInterval = null;
let isPaused = false;


function updateFeaturedSlider(fade = true) {
  const game = featuredGames[featuredIndex];
  const mainImg = document.getElementById('featured-main-img');
  const mainDiv = document.querySelector('.featured-main');
  if (fade && mainDiv) {
    mainDiv.classList.add('fade-out');
    setTimeout(() => {
      mainImg.src = game.img;
      mainImg.alt = game.title;
      mainDiv.classList.remove('fade-out');
    }, 300);
  } else {
    mainImg.src = game.img;
    mainImg.alt = game.title;
  }
  document.getElementById('featured-title').textContent = game.title;
  // Screenshots removed
  const screenshotsDiv = document.getElementById('featured-screenshots');
  if (screenshotsDiv) screenshotsDiv.innerHTML = '';
  // Tags
  const tagsDiv = document.getElementById('featured-tags');
  tagsDiv.innerHTML = '';
  game.tags.forEach(tag => {
    const span = document.createElement('span');
    span.className = 'tag';
    span.textContent = tag;
    tagsDiv.appendChild(span);
  });
  // Recommend
  const recommendDiv = document.getElementById('featured-recommend');
  recommendDiv.innerHTML = '<span class="recommend-label">Recommended</span> because you played games tagged with ';
  game.recommend.forEach(tag => {
    const span = document.createElement('span');
    span.className = 'tag';
    span.textContent = tag;
    recommendDiv.appendChild(span);
  });
  // Price
  document.getElementById('featured-price').textContent = game.price;
  updateSliderDots();
}


function prevFeatured() {
  featuredIndex = (featuredIndex - 1 + featuredGames.length) % featuredGames.length;
  updateFeaturedSlider();
  resetSliderInterval();
}

function nextFeatured() {
  featuredIndex = (featuredIndex + 1) % featuredGames.length;
  updateFeaturedSlider();
  resetSliderInterval();
}


// Slider dots
function updateSliderDots() {
  const dotsDiv = document.getElementById('slider-dots');
  if (!dotsDiv) return;
  dotsDiv.innerHTML = '';
  for (let i = 0; i < featuredGames.length; i++) {
    const dot = document.createElement('button');
    dot.className = 'slider-dot' + (i === featuredIndex ? ' active' : '');
    dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
    dot.onclick = () => {
      featuredIndex = i;
      updateFeaturedSlider();
      resetSliderInterval();
    };
    dotsDiv.appendChild(dot);
  }
}

function startSliderInterval() {
  sliderInterval = setInterval(() => {
    if (!isPaused) nextFeatured();
  }, 4 * 1000); // 4 seconds in milliseconds
}

function resetSliderInterval() {
  clearInterval(sliderInterval);
  startSliderInterval();
}

// Pause on hover
document.addEventListener('DOMContentLoaded', function() {
  const slider = document.getElementById('featured-slider');
  if (slider) {
    slider.addEventListener('mouseenter', () => { isPaused = true; });
    slider.addEventListener('mouseleave', () => { isPaused = false; });
  }
});

// Initialize featured slider
updateFeaturedSlider(false);
startSliderInterval();

// --- Restored: Old slider code (undo) ---
const slides = document.querySelectorAll('.slide');
const slidesContainer = document.querySelector('.slides');
let current = 0;

function showSlide(index) {
    // Move the slides container horizontally
    slidesContainer.style.transform = `translateX(-${index * 100}%)`;
}

function nextSlide() {
    current = (current + 1) % slides.length;
    showSlide(current);
}

// Show the first slide initially
showSlide(current);

// Change slide every 4 seconds
setInterval(nextSlide, 4 * 1000); // 4 seconds in milliseconds
// --- End restored code ---

function toggleZeldaVersions() {
  const versions = document.getElementById('zelda-versions');
  versions.style.display = versions.style.display === 'none' ? 'block' : 'none';
}

function toggleCodVersions() {
  const versions = document.getElementById('cod-versions');
  versions.style.display = versions.style.display === 'none' ? 'block' : 'none';
}
function showSpinner() {
  document.getElementById('loading').style.display = 'flex';
}

function hideSpinner() {
  document.getElementById('loading').style.display = 'none';
}
