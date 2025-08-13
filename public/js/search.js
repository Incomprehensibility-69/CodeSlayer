function filterGames() {
  const query = document.getElementById('search').value.toLowerCase();
  const cards = document.querySelectorAll('.game-card');
  const results = [];
  cards.forEach(card => {
    const title = card.querySelector('h4').textContent;
    if (title.toLowerCase().includes(query) && query.length > 0) {
      const img = card.querySelector('img').src;
      const price = card.querySelector('p').textContent;
      results.push({ title, img, price, card });
    }
  });

  const resultsDiv = document.getElementById('search-results');
  if (results.length > 0) {
    resultsDiv.innerHTML = results.map((item, idx) => `
      <div class="search-result-item" data-result-idx="${idx}">
        <img class="search-result-thumb" src="${item.img}" alt="${item.title}">
        <div class="search-result-info">
          <div class="search-result-title">${item.title}</div>
          <div class="search-result-price">${item.price}</div>
        </div>
      </div>
    `).join('');
    resultsDiv.style.display = 'block';

    // Add click listeners to each result
    Array.from(resultsDiv.querySelectorAll('.search-result-item')).forEach((el, idx) => {
      el.onclick = function() {
        // Scroll to the game card
        const card = results[idx].card;
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        // Highlight the card
        card.classList.add('highlight-game-card');
        setTimeout(() => {
          card.classList.remove('highlight-game-card');
        }, 2000);
        // Hide the search results
        resultsDiv.style.display = 'none';
      };
    });
  } else {
    resultsDiv.style.display = 'none';
  }
}
window.filterGames = filterGames;

document.addEventListener('click', function(e) {
  if (!e.target.closest('#search') && !e.target.closest('#search-results')) {
    document.getElementById('search-results').style.display = 'none';
  }
});