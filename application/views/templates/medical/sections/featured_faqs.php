<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  /* Featured FAQ Section */
  .featured-faqs-section {
    padding: 80px 0;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
  }

  .home-faq-item {
    background: white;
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .home-faq-item.active {
    border-color: var(--theme-primary);
    box-shadow: 0 5px 20px rgba(var(--theme-primary-rgb), 0.1);
  }

  .faq-question {
    padding: 1.5rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
    color: var(--theme-primary);
    transition: background 0.3s ease;
    user-select: none;
  }

  .faq-question:hover {
    background: #f8fafc;
  }

  .home-faq-item.active .faq-question {
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    color: white;
  }

  .faq-question i {
    transition: transform 0.3s ease;
    font-size: 1.25rem;
  }

  .home-faq-item.active .faq-question i {
    transform: rotate(180deg);
  }

  .faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    padding: 0 1.5rem;
  }

  .home-faq-item.active .faq-answer {
    max-height: 500px;
    padding: 0 1.5rem 1.5rem 1.5rem;
  }

  .faq-answer {
    color: #64748b;
    line-height: 1.6;
    font-size: 0.95rem;
  }

  @media (max-width: 768px) {
    .featured-faqs-section {
      padding: 60px 0;
    }

    .faq-question {
      padding: 1rem;
    }

    .faq-answer {
      padding: 0 1rem !important;
    }

    .home-faq-item.active .faq-answer {
      padding: 0 1rem 1rem 1rem !important;
    }
  }
</style>

<!-- Featured FAQ Section -->
<?php if (!empty($featured_faqs)): ?>
<section id="featured-faqs" class="featured-faqs-section section">
  <div class="container">
    <div class="section-title text-center mb-5" data-aos="fade-up">
      <h2>Frequently Asked Questions</h2>
      <p>Find answers to common questions about our services</p>
    </div>

    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="faq-items">
          <?php foreach ($featured_faqs as $index => $faq): ?>
          <div class="faq-item home-faq-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
            <div class="faq-question" onclick="toggleHomeFaq(this)">
              <span>
                <i class="bi bi-question-circle me-2" style="color: var(--theme-accent);"></i>
                <?php echo htmlspecialchars($faq->question); ?>
              </span>
              <i class="bi bi-chevron-down"></i>
            </div>
            <div class="faq-answer">
              <?php echo $faq->answer; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="text-center mt-4">
          <a href="<?php echo base_url('faq'); ?>" class="btn btn-primary">
            <i class="bi bi-chat-dots me-2"></i>View All FAQs
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<script>
function toggleHomeFaq(element) {
    const item = element.closest('.home-faq-item');
    const isActive = item.classList.contains('active');
    
    // Close all other items
    document.querySelectorAll('.home-faq-item').forEach(faq => {
        faq.classList.remove('active');
    });
    
    // Toggle current item
    if (!isActive) {
        item.classList.add('active');
    }
}
</script>
