 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daus News</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Daus News</a>
  </div>
</nav>

<div class="container mt-5">
    <
    <h2 class="text-center mb-4">Mau Baca Berita Apa Hari Ini?</h2>
    <form id="searchForm" class="d-flex justify-content-center">
        <input type="text" id="query" placeholder="Ketik kata kunci berita..." class="form-control w-50 me-2">
        <button type="submit" class="btn btn-dark">Cari</button>
    </form>

    <
    <div id="alertBox" class="mt-3"></div>tuk menampilkan pesan error

    
    <div id="newsCards" class="row mt-4">
    </div>
</div>

<script>

async function fetchNews(query = 'tesla') {
    const apiKey = 'baa031dca91c490198d74c5eb0183724';
    const url = `https://newsapi.org/v2/everything?q=${query}&sortBy=publishedAt&apiKey=${apiKey}`;
    
    try {
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.status === 'error') {
            displayError(data.message);
        } else if (!data.articles || data.articles.length === 0) {
            displayError('Berita tidak ditemukan untuk kata kunci tersebut.');
        } else {
            displayNews(data.articles);
        }
    } catch (error) {
        displayError('Terjadi kesalahan saat memuat berita. Periksa koneksi internet Anda.');
    }
}

// Fungsi untuk menampilkan pesan error
function displayError(message) {
    const alertBox = document.getElementById('alertBox');
    alertBox.innerHTML = `<div class="alert alert-danger text-center">${message}</div>`;
}

// Fungsi untuk menampilkan berita
function displayNews(articles) {
    const newsCards = document.getElementById('newsCards');
    newsCards.innerHTML = '';
    
    articles.forEach(article => {
        newsCards.innerHTML += `
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="${article.urlToImage || 'https://via.placeholder.com/400x200?text=No+Image'}" class="card-img-top" alt="Gambar berita">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${article.title || 'Tidak ada judul'}</h5>
                        <h6 class="text-muted">${article.author || 'Tidak diketahui'}</h6>
                        <p class="card-text">${article.description || 'Tidak ada deskripsi.'}</p>
                        <a href="${article.url}" target="_blank" class="btn btn-dark mt-auto">Baca Selengkapnya</a>
                    </div>
                    <div class="card-footer text-muted">
                        ${new Date(article.publishedAt).toLocaleDateString('id-ID')}
                    </div>
                </div>
            </div>
        `;
    });
}

// Event listener untuk form pencarian
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const query = document.getElementById('query').value.trim();
    fetchNews(query);
});

// Memuat berita default saat pertama kali halaman dibuka
fetchNews();
</script>

</body>
</html>
