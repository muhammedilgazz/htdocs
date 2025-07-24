<?php
require_once __DIR__ . '/../layouts/layoutTop.php';
$page_title = 'Youtube Videoları';
$page_description = 'Yapay zeka ve teknolojiyle ilgili seçilmiş YouTube videoları.';
$breadcrumb_active = 'YouTube';
require_once __DIR__ . '/../partials/page_header.php';
$playlist_date = 'Ağustos 2025';
$video_count = 20; // API ile dinamik de çekilebilir, şimdilik örnek
$API_KEY = 'AIzaSyCWmmyZEa8FBMU69M_kdx4zczAObAe02-Y';
$PLAYLIST_ID = 'PLKkUidM6vaSYdTk3ujS5cxJWB6g6neKA6';
?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Hero Section (Gradient, koyu, görselli) -->
            <div class="youtube-hero-section position-relative mb-4 p-4 p-md-5 rounded-4 overflow-hidden">
                <div class="youtube-hero-bg"></div>
                <div class="position-relative flex-grow-1 text-white mb-4 mb-md-0 pe-md-5" style="z-index:2;">
                    <div class="mb-2" style="font-size:1.1rem; opacity:0.85;">YOUTUBE PLAYLIST</div>
                    <h1 class="fw-bold display-5 mb-2" style="letter-spacing:-0.01em;">AI Videoları</h1>
                    <div class="mb-3" style="font-size:1.15rem; opacity:0.92;">Yapay zeka ve teknolojiyle ilgili seçilmiş YouTube videoları.</div>
                    <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                        <span class="badge rounded-pill bg-dark bg-opacity-50 px-4 py-2 fs-6">
                            <i class="bi bi-calendar-event me-1"></i> <?php echo $playlist_date; ?>
                        </span>
                        <span class="badge rounded-pill bg-dark bg-opacity-50 px-4 py-2 fs-6">
                            <i class="bi bi-collection-play me-1"></i> <span id="video-count-js"><?php echo $video_count; ?></span> video
                        </span>
                    </div>
                </div>
                <!-- Sağda ekstra görsel yok, arka plan cover olarak var -->
            </div>
            <!-- YouTube Playlist Grid -->
            <div id="video-grid" class="video-grid loading text-center py-5">Yükleniyor...</div>
            <!-- GIT ve GITHUB EĞİTİMİ HERO SECTION -->
            <div class="youtube-hero-section position-relative mb-4 p-4 p-md-5 rounded-4 overflow-hidden">
                <div class="youtube-hero-bg"></div>
                <div class="position-relative flex-grow-1 text-white mb-4 mb-md-0 pe-md-5" style="z-index:2;">
                    <div class="mb-2" style="font-size:1.1rem; opacity:0.85;">YOUTUBE PLAYLIST</div>
                    <h1 class="fw-bold display-5 mb-2" style="letter-spacing:-0.01em;">Git ve Github Eğitimi</h1>
                    <div class="mb-3" style="font-size:1.15rem; opacity:0.92;">Sıfırdan ileri seviyeye Git ve Github eğitim videoları.</div>
                    <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                        <span class="badge rounded-pill bg-dark bg-opacity-50 px-4 py-2 fs-6">
                            <i class="bi bi-calendar-event me-1"></i> Ağustos 2025
                        </span>
                        <span class="badge rounded-pill bg-dark bg-opacity-50 px-4 py-2 fs-6">
                            <i class="bi bi-collection-play me-1"></i> <span id="video-count-git">15</span> video
                        </span>
                    </div>
                </div>
            </div>
            <!-- GIT ve GITHUB EĞİTİMİ PLAYLIST GRID -->
            <div id="video-grid-git" class="video-grid loading text-center py-5">Yükleniyor...</div>
        </div>
    </div>
</div>
<style>
.youtube-hero-section {
    background: linear-gradient(90deg, #18122B 0%, #2D3250 60%, #18122B 100%);
    box-shadow: 0 4px 32px 0 rgba(24,18,43,0.10);
    min-height: 240px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
}
.youtube-hero-bg {
    position: absolute;
    inset: 0;
    z-index: 1;
    background: linear-gradient(90deg, rgba(24,18,43,0.98) 0%, rgba(24,18,43,0.85) 30%, rgba(24,18,43,0.5) 60%, rgba(24,18,43,0.1) 100%), url('https://earth.org/wp-content/uploads/2023/07/Untitled-683-%C3%97-1024px-1024-%C3%97-683px-2023-07-17T150611.308.jpg.webp') center right/cover no-repeat;
    opacity: 1;
    pointer-events: none;
}
.youtube-hero-section h1, .youtube-hero-section .display-5 { color: #fff; }
.youtube-hero-section .badge {
    background: rgba(0,0,0,0.25) !important;
    color: #fff !important;
    font-weight: 600;
    font-size: 1.08rem;
    letter-spacing: 0.01em;
    border: none;
}
.youtube-hero-img img {
    max-width: 320px;
    border-radius: 1.2rem;
    box-shadow: 0 4px 32px 0 rgba(0,0,0,0.18);
}
@media (max-width: 900px) {
    .youtube-hero-section { flex-direction: column !important; text-align: left; }
    .youtube-hero-img { margin-top: 2rem; }
}
@media (max-width: 600px) {
    .youtube-hero-section { padding: 1.2rem !important; }
    .youtube-hero-img img { max-width: 100%; }
}
.video-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem 1.5rem;
  margin: 0;
  padding-bottom: 2rem;
}
@media (max-width: 1200px) {
  .video-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 900px) {
  .video-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
  .video-grid { grid-template-columns: 1fr; }
}
.video-grid.loading {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 300px;
  font-size: 1.2rem;
  color: #888;
}
.video-item {
  background: #fff;
  border-radius: 1rem;
  box-shadow: 0 2px 12px 0 rgba(79,140,255,0.06);
  padding: 1rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: box-shadow .18s;
}
.video-item:hover {
  box-shadow: 0 8px 32px 0 rgba(0,0,0,0.10);
}
.video-item iframe {
  width: 100%;
  min-height: 180px;
  aspect-ratio: 16/9;
  border-radius: 0.7rem;
  border: none;
  background: #f3f3f3;
}
</style>
<script>
    const API_KEY = '<?php echo $API_KEY; ?>';
    const PLAYLIST_ID = '<?php echo $PLAYLIST_ID; ?>';
    const videoGrid = document.getElementById('video-grid');
    const MAX_RESULTS = 50;
    const apiUrl = `https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=${MAX_RESULTS}&playlistId=${PLAYLIST_ID}&key=${API_KEY}`;
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            videoGrid.innerHTML = '';
            videoGrid.classList.remove('loading');
            if (data.items) {
                document.getElementById('video-count-js').textContent = data.items.length;
                data.items.forEach(item => {
                    const videoId = item.snippet.resourceId.videoId;
                    const title = item.snippet.title;
                    const videoItemDiv = document.createElement('div');
                    videoItemDiv.className = 'video-item';
                    const iframe = document.createElement('iframe');
                    iframe.src = `https://www.youtube.com/embed/${videoId}`;
                    iframe.title = title;
                    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                    iframe.allowFullscreen = true;
                    videoItemDiv.appendChild(iframe);
                    const caption = document.createElement('div');
                    caption.textContent = title;
                    caption.style = 'font-size:1rem; font-weight:500; margin-top:0.7rem; text-align:center; color:#222;';
                    videoItemDiv.appendChild(caption);
                    // Butonlar
                    const btnGroup = document.createElement('div');
                    btnGroup.className = 'd-flex gap-2 justify-content-center mt-2';
                    const watchedBtn = document.createElement('button');
                    watchedBtn.className = 'btn btn-primary btn-sm';
                    watchedBtn.innerHTML = '<i class="bi bi-check2-circle me-1"></i>İzledim';
                    const notesBtn = document.createElement('button');
                    notesBtn.className = 'btn btn-outline-primary btn-sm';
                    notesBtn.innerHTML = '<i class="bi bi-journal-text me-1"></i>Notlar';
                    btnGroup.appendChild(notesBtn);
                    btnGroup.appendChild(watchedBtn);
                    videoItemDiv.appendChild(btnGroup);
                    videoGrid.appendChild(videoItemDiv);
                });
            } else {
                videoGrid.innerHTML = 'Videolar yüklenemedi. API anahtarını veya Oynatma Listesi ID\'sini kontrol edin.';
                console.error('API Hatası:', data);
            }
        })
        .catch(error => {
            console.error('Hata:', error);
            videoGrid.innerHTML = 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
        });
</script>
<script>
const GIT_PLAYLIST_ID = 'PLh9tR6B_Q32rDSbSaN7Xw9Geba0Va7kpd';
const videoGridGit = document.getElementById('video-grid-git');
const apiUrlGit = `https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=${GIT_PLAYLIST_ID}&key=${API_KEY}`;
fetch(apiUrlGit)
    .then(response => response.json())
    .then(data => {
        videoGridGit.innerHTML = '';
        videoGridGit.classList.remove('loading');
        if (data.items) {
            document.getElementById('video-count-git').textContent = data.items.length;
            data.items.forEach(item => {
                const videoId = item.snippet.resourceId.videoId;
                const title = item.snippet.title;
                const videoItemDiv = document.createElement('div');
                videoItemDiv.className = 'video-item';
                const iframe = document.createElement('iframe');
                iframe.src = `https://www.youtube.com/embed/${videoId}`;
                iframe.title = title;
                iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                iframe.allowFullscreen = true;
                videoItemDiv.appendChild(iframe);
                const caption = document.createElement('div');
                caption.textContent = title;
                caption.style = 'font-size:1rem; font-weight:500; margin-top:0.7rem; text-align:center; color:#222;';
                videoItemDiv.appendChild(caption);
                // Butonlar
                const btnGroup = document.createElement('div');
                btnGroup.className = 'd-flex gap-2 justify-content-center mt-2';
                const watchedBtn = document.createElement('button');
                watchedBtn.className = 'btn btn-primary btn-sm';
                watchedBtn.textContent = 'İzledim';
                const notesBtn = document.createElement('button');
                notesBtn.className = 'btn btn-outline-primary btn-sm';
                notesBtn.textContent = 'Notlar';
                btnGroup.appendChild(notesBtn);
                btnGroup.appendChild(watchedBtn);
                videoItemDiv.appendChild(btnGroup);
                videoGridGit.appendChild(videoItemDiv);
            });
        } else {
            videoGridGit.innerHTML = 'Videolar yüklenemedi. API anahtarını veya Oynatma Listesi ID\'sini kontrol edin.';
            console.error('API Hatası:', data);
        }
    })
    .catch(error => {
        console.error('Hata:', error);
        videoGridGit.innerHTML = 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.';
    });
</script>
<?php require_once __DIR__ . '/../layouts/layoutBottom.php'; ?> 