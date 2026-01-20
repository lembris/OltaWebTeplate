<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  /* YouTube Videos Section */
  .youtube-videos-section {
    padding: 80px 0;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
  }

  .video-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
  }

  .video-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  }

  .video-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 32px rgba(var(--theme-primary-rgb), 0.15);
    border-color: color-mix(in srgb, var(--theme-primary), white 70%);
  }

  .video-thumbnail-wrapper {
    position: relative;
    width: 100%;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
    background: #000;
  }

  .video-thumbnail {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .video-play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    background: rgba(255, 0, 0, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
  }

  .video-card:hover .video-play-button {
    background: rgba(255, 0, 0, 1);
    transform: translate(-50%, -50%) scale(1.1);
  }

  .video-play-button i {
    color: white;
    font-size: 24px;
    margin-left: 4px;
  }

  .video-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .video-category {
    display: inline-block;
    background: linear-gradient(135deg, #dbeafe, #e0e7ff);
    color: var(--theme-primary);
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.75rem;
    width: fit-content;
  }

  .video-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-bottom: 0.75rem;
    line-height: 1.4;
    flex: 1;
  }

  .video-description {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    flex: 1;
  }

  .video-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #94a3b8;
    font-size: 0.85rem;
    padding-top: 1rem;
    border-top: 1px solid #e2e8f0;
  }

  .video-meta i {
    color: var(--theme-primary);
  }

  .view-all-videos-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--theme-primary);
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-top: 3rem;
  }

  .view-all-videos-btn:hover {
    gap: 0.75rem;
    color: var(--theme-accent);
  }

  .video-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
  }

  .video-modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .video-modal-content {
    position: relative;
    width: 90%;
    max-width: 900px;
    aspect-ratio: 16 / 9;
  }

  .video-modal-close {
    position: absolute;
    top: -40px;
    right: 0;
    color: white;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .video-modal-close:hover {
    color: #ccc;
  }

  .video-modal iframe {
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 8px;
  }

  .no-videos {
    text-align: center;
    padding: 3rem 0;
    color: #64748b;
  }

  .no-videos i {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
  }

  @media (max-width: 768px) {
    .youtube-videos-section {
      padding: 60px 0;
    }

    .video-grid {
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }

    .video-modal-content {
      width: 95%;
    }
  }
</style>

<!-- YouTube Videos Section -->
<section id="youtube-videos" class="youtube-videos-section">

  <div class="container section-title" data-aos="fade-up">
    <h2>Featured Video Content</h2>
    <p>Watch our latest health education videos and insights</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <?php if (!empty($youtube_videos)): ?>
    <div class="video-grid">
      <?php foreach ($youtube_videos as $video): ?>
      <div class="video-card" data-aos="fade-up" data-aos-delay="100">
        <div class="video-thumbnail-wrapper">
          <img src="<?php echo htmlspecialchars($video->thumbnail_url); ?>" alt="<?php echo htmlspecialchars($video->title); ?>" class="video-thumbnail">
          <div class="video-play-button" onclick="playVideo('<?php echo htmlspecialchars($video->youtube_video_id); ?>', '<?php echo htmlspecialchars($video->title); ?>')">
            <i class="bi bi-play-fill"></i>
          </div>
        </div>
        <div class="video-content">
          <?php if (!empty($video->category)): ?>
          <span class="video-category"><?php echo htmlspecialchars($video->category); ?></span>
          <?php endif; ?>
          <h3 class="video-title"><?php echo htmlspecialchars($video->title); ?></h3>
          <?php if (!empty($video->description)): ?>
          <p class="video-description">
            <?php echo htmlspecialchars(substr($video->description, 0, 100)) . (strlen($video->description) > 100 ? '...' : ''); ?>
          </p>
          <?php endif; ?>
          <div class="video-meta">
            <i class="bi bi-youtube"></i>
            <span>Watch on YouTube</span>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="no-videos">
      <i class="bi bi-play-circle"></i>
      <p>No videos available at the moment</p>
    </div>
    <?php endif; ?>
  </div>

</section>

<!-- Video Modal -->
<div id="videoModal" class="video-modal">
  <div class="video-modal-content">
    <span class="video-modal-close" onclick="closeVideo()">&times;</span>
    <iframe id="videoFrame" allow="autoplay" allowfullscreen></iframe>
  </div>
</div>

<script>
function playVideo(videoId, title) {
  const modal = document.getElementById('videoModal');
  const iframe = document.getElementById('videoFrame');
  iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
  modal.classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeVideo() {
  const modal = document.getElementById('videoModal');
  const iframe = document.getElementById('videoFrame');
  iframe.src = '';
  modal.classList.remove('active');
  document.body.style.overflow = 'auto';
}

// Close modal when clicking outside the iframe
document.getElementById('videoModal').addEventListener('click', function(event) {
  if (event.target === this) {
    closeVideo();
  }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    closeVideo();
  }
});
</script>
