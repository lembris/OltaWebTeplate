<!-- ============================================
     FAQ SECTION - REUSABLE
     ============================================ -->
<?php if (!empty($faqs)): ?>
<section class="ftco-section" style="background-color: #faf8f6;">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">FAQ</span>
                <h2 class="mb-4" style="color: #333;">Frequently Asked Questions</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <?php foreach ($faqs as $category => $questions): ?>
                <div class="faq-category mb-5">
                    <?php if (!empty($category)): ?>
                    <h3 style="color: var(--primary-color, #C7805C); margin-bottom: 20px; font-size: 1.3rem; border-bottom: 2px solid var(--primary-color, #C7805C); padding-bottom: 10px;">
                        <i class="fa fa-folder-open mr-2"></i><?php echo htmlspecialchars($category); ?>
                    </h3>
                    <?php endif; ?>
                    <div class="faq-list">
                        <?php foreach ($questions as $index => $faq): ?>
                        <div class="faq-item mb-3" style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
                            <div class="faq-question" onclick="toggleFaq(this)" style="cursor: pointer; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; font-weight: 600; color: #333;">
                                <span><i class="fa fa-question-circle mr-2" style="color: var(--primary-color, #C7805C);"></i><?php echo htmlspecialchars($faq->question); ?></span>
                                <i class="fa fa-chevron-down" style="color: var(--primary-color, #C7805C); transition: transform 0.3s ease;"></i>
                            </div>
                            <div class="faq-answer" style="display: none; padding: 0 20px 20px 20px; color: #666; line-height: 1.8; border-top: 1px solid #eee; margin-top: -5px; padding-top: 15px;">
                                <?php echo $faq->answer; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
