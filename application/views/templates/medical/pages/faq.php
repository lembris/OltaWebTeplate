<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
  .faq-hero {
    padding: 120px 0 80px;
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    position: relative;
  }

  .faq-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="%23059669" opacity="0.03"/></svg>');
    background-size: 30px 30px;
    pointer-events: none;
  }

  .page-header {
    margin-bottom: 3rem;
  }

  .page-header h1 {
    font-size: 2.75rem;
    font-weight: 800;
    color: var(--theme-primary);
    margin-bottom: 1rem;
  }

  .page-header p {
    font-size: 1.125rem;
    color: #64748b;
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
  }

  .faq-section {
    padding: 80px 0;
  }

  .faq-section:nth-child(even) {
    background: #f8fafc;
  }

  .faq-category-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--theme-primary);
    margin-top: 3rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .faq-category-title i {
    font-size: 1.75rem;
  }

  .faq-item {
    background: white;
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .faq-item:hover {
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
  }

  .faq-item.active {
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

  .faq-item.active .faq-question {
    background: linear-gradient(135deg, var(--theme-primary) 0%, var(--primary-dark) 100%);
    color: white;
  }

  .faq-question i {
    transition: transform 0.3s ease;
    font-size: 1.25rem;
  }

  .faq-item.active .faq-question i {
    transform: rotate(180deg);
  }

  .faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    padding: 0 1.5rem;
    color: #64748b;
    line-height: 1.6;
    font-size: 0.95rem;
  }

  .faq-item.active .faq-answer {
    max-height: 500px;
    padding: 0 1.5rem 1.5rem 1.5rem;
  }

  .faq-search-box {
    margin-bottom: 3rem;
  }

  .faq-search-box input {
    width: 100%;
    padding: 1rem 1.5rem;
    font-size: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 50px;
    transition: all 0.3s ease;
    background: white;
  }

  .faq-search-box input:focus {
    outline: none;
    border-color: var(--theme-primary);
    box-shadow: 0 0 0 4px rgba(var(--theme-primary-rgb), 0.1);
  }

  .faq-empty-state {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
  }

  .faq-empty-state i {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
  }

  .faq-empty-state p {
    color: #64748b;
    margin-bottom: 1.5rem;
  }

  @media (max-width: 768px) {
    .faq-hero {
      padding: 80px 0 60px;
    }

    .page-header h1 {
      font-size: 2rem;
    }

    .faq-section {
      padding: 60px 0;
    }

    .faq-question {
      padding: 1rem;
    }

    .faq-answer {
      padding: 0 1rem !important;
    }

    .faq-item.active .faq-answer {
      padding: 0 1rem 1rem 1rem !important;
    }
  }
</style>

<!-- Page Header -->
<section class="faq-hero">
  <div class="container">
    <div class="page-header" data-aos="fade-up">
      <h1>Frequently Asked Questions</h1>
      <p>Find answers to common questions about our services, consultations, and healthcare solutions</p>
    </div>
  </div>
</section>

<!-- FAQ Content -->
<section class="faq-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        
        <!-- Search Box -->
        <div class="faq-search-box" data-aos="fade-up">
          <input 
            type="text" 
            id="faqSearch" 
            placeholder="Search FAQs..." 
            aria-label="Search FAQs"
          >
        </div>

        <!-- FAQs by Category -->
        <?php if (!empty($all_faqs)): ?>
          <?php foreach ($all_faqs as $category => $faqs): ?>
            <?php if (!empty($category)): ?>
            <h3 class="faq-category-title" data-aos="fade-up">
              <i class="bi bi-folder-open"></i><?php echo htmlspecialchars($category); ?>
            </h3>
            <?php endif; ?>
            
            <?php foreach ($faqs as $index => $faq): ?>
            <div class="faq-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 50; ?>" data-category="<?php echo htmlspecialchars($category); ?>" data-question="<?php echo strtolower(htmlspecialchars($faq->question)); ?>">
              <div class="faq-question" onclick="toggleFaq(this)">
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
          <?php endforeach; ?>
        <?php else: ?>
          <div class="faq-empty-state" data-aos="fade-up">
            <i class="bi bi-info-circle"></i>
            <p>No FAQs available at the moment.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php echo $this->load->view('templates/medical/sections/home_cta', [], TRUE); ?>

<script>
function toggleFaq(element) {
    const item = element.closest('.faq-item');
    const isActive = item.classList.contains('active');
    
    // Close all other items
    document.querySelectorAll('.faq-item').forEach(faq => {
        faq.classList.remove('active');
    });
    
    // Toggle current item
    if (!isActive) {
        item.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('faqSearch');
    const faqItems = document.querySelectorAll('.faq-item');
    
    if (searchBox) {
        searchBox.addEventListener('keyup', function(e) {
            const searchTerm = this.value.toLowerCase();
            let hasVisibleItems = false;
            
            faqItems.forEach(item => {
                const question = item.getAttribute('data-question');
                const isMatch = question.includes(searchTerm);
                
                if (searchTerm === '' || isMatch) {
                    item.style.display = '';
                    hasVisibleItems = true;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide category titles based on visible items
            document.querySelectorAll('.faq-category-title').forEach(title => {
                const category = title.textContent.trim();
                let hasVisibleInCategory = false;
                
                faqItems.forEach(item => {
                    if (item.getAttribute('data-category') === category && item.style.display !== 'none') {
                        hasVisibleInCategory = true;
                    }
                });
                
                title.style.display = hasVisibleInCategory ? '' : 'none';
            });
        });
    }
});
</script>
