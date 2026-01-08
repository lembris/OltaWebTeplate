-- ============================================
-- Blog Posts Table for Osiram Safari
-- Version: 4.0
-- Created: December 5, 2025
-- ============================================

-- Create blog_posts table
CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uid` VARCHAR(36) NULL UNIQUE COMMENT 'UUID for URL usage',
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `category` VARCHAR(100) DEFAULT 'travel-tips',
    `excerpt` TEXT NULL,
    `content` LONGTEXT NOT NULL,
    `featured_image` VARCHAR(255) NULL,
    `author` VARCHAR(100) DEFAULT 'Osiram Safari',
    `published` TINYINT(1) DEFAULT 1 COMMENT '1 = published, 0 = draft',
    `views` INT(11) UNSIGNED DEFAULT 0,
    `theme` VARCHAR(50) DEFAULT 'all' COMMENT 'Theme filter: all or specific template name',
    `tags` TEXT NULL COMMENT 'Comma-separated tags',
    `seo_title` VARCHAR(255) NULL COMMENT 'For meta title tag',
    `seo_description` VARCHAR(255) NULL COMMENT 'For meta description tag',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`),
    UNIQUE KEY `uid` (`uid`),
    KEY `category` (`category`),
    KEY `published` (`published`),
    KEY `theme` (`theme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Sample Blog Posts Data
-- ============================================

INSERT INTO `blog_posts` (`title`, `slug`, `category`, `excerpt`, `content`, `featured_image`, `author`, `published`, `views`, `theme`) VALUES

-- Post 1: Best Time to Visit
('Best Time to Visit Tanzania for Safari', 
'best-time-visit-tanzania-safari', 
'travel-tips',
'Discover the ideal seasons for your African safari adventure and maximize your wildlife viewing experience.',
'<h2>When Should You Visit Tanzania?</h2>
<p>Tanzania offers incredible wildlife viewing year-round, but certain seasons provide exceptional experiences depending on what you want to see.</p>

<h3>Dry Season (June - October)</h3>
<p>The dry season is considered the best time for safari in Tanzania. During these months:</p>
<ul>
<li>Animals gather around water sources, making them easier to spot</li>
<li>Vegetation is thinner, improving visibility</li>
<li>The Great Migration reaches the Serengeti</li>
<li>Weather is pleasant with minimal rainfall</li>
</ul>

<h3>Wet Season (November - May)</h3>
<p>The wet season, also known as the "green season," offers its own advantages:</p>
<ul>
<li>Fewer tourists and lower prices</li>
<li>Lush, green landscapes perfect for photography</li>
<li>Bird watching is exceptional with migratory species</li>
<li>Calving season in the Serengeti (January - March)</li>
</ul>

<h3>The Great Migration</h3>
<p>If witnessing the Great Migration is your priority, plan your visit between July and October when millions of wildebeest and zebras cross the Mara River in the northern Serengeti.</p>

<blockquote>Pro Tip: Book your safari at least 6 months in advance during peak season to secure the best accommodations.</blockquote>

<p>Contact our safari experts to help you choose the perfect time for your adventure!</p>',
'safari-sunset.jpg',
'Safari Expert',
1,
245,
'college'),

-- Post 2: What to Pack
('Essential Safari Packing List: What to Bring', 
'essential-safari-packing-list', 
'travel-tips',
'Complete packing guide for your Tanzania safari - from clothing to camera gear, we have got you covered.',
'<h2>Your Complete Safari Packing Checklist</h2>
<p>Packing for a safari requires careful consideration of the unique environment and activities. Here is everything you need to bring.</p>

<h3>Clothing Essentials</h3>
<ul>
<li><strong>Neutral Colors:</strong> Khaki, olive, tan, and brown blend with the environment</li>
<li><strong>Long Sleeves:</strong> Protect against sun and insects</li>
<li><strong>Light Layers:</strong> Mornings and evenings can be cool</li>
<li><strong>Comfortable Walking Shoes:</strong> Closed-toe for bush walks</li>
<li><strong>Wide-Brimmed Hat:</strong> Essential sun protection</li>
<li><strong>Warm Fleece:</strong> For early morning game drives</li>
</ul>

<h3>Camera and Electronics</h3>
<ul>
<li>Camera with zoom lens (200-400mm recommended)</li>
<li>Extra memory cards and batteries</li>
<li>Binoculars (8x42 or 10x42)</li>
<li>Power bank for charging devices</li>
<li>Universal power adapter</li>
</ul>

<h3>Health and Safety</h3>
<ul>
<li>Prescription medications</li>
<li>Sunscreen (SPF 50+)</li>
<li>Insect repellent with DEET</li>
<li>Basic first aid kit</li>
<li>Hand sanitizer</li>
</ul>

<h3>What NOT to Bring</h3>
<ul>
<li>Bright colors or white clothing</li>
<li>Strong perfumes or colognes</li>
<li>Excessive jewelry</li>
<li>Camouflage patterns (restricted in some countries)</li>
</ul>

<p>Our team provides a detailed packing list when you book your safari with us!</p>',
'safari-packing.jpg',
'Safari Expert',
1,
189,
'college'),

-- Post 3: Big Five Guide
('The Big Five: Complete Wildlife Guide', 
'big-five-wildlife-guide', 
'wildlife',
'Learn about Africa''s most iconic animals and where to find them on your Tanzania safari.',
'<h2>Meet Africa''s Big Five</h2>
<p>The term "Big Five" was originally coined by big-game hunters referring to the five most difficult animals to hunt on foot. Today, these magnificent creatures are the most sought-after animals to see on safari.</p>

<h3>1. African Lion</h3>
<p>The king of the savanna, lions are social cats living in prides. Best spotted in the Serengeti and Ngorongoro Crater.</p>
<ul>
<li><strong>Best Time:</strong> Early morning and late afternoon</li>
<li><strong>Where:</strong> Serengeti, Ngorongoro Crater</li>
<li><strong>Tip:</strong> Look for them resting in trees during midday heat</li>
</ul>

<h3>2. African Elephant</h3>
<p>The largest land mammal on Earth, elephants are intelligent and family-oriented. Tarangire National Park has the highest concentration.</p>
<ul>
<li><strong>Best Time:</strong> Any time of day</li>
<li><strong>Where:</strong> Tarangire, Serengeti, Ngorongoro</li>
<li><strong>Tip:</strong> Watch for dust-bathing behavior</li>
</ul>

<h3>3. Cape Buffalo</h3>
<p>Often considered the most dangerous of the Big Five, buffalo travel in large herds and are protective of their young.</p>
<ul>
<li><strong>Best Time:</strong> Morning near water sources</li>
<li><strong>Where:</strong> Throughout Tanzania parks</li>
<li><strong>Tip:</strong> Look for oxpeckers on their backs</li>
</ul>

<h3>4. African Leopard</h3>
<p>The most elusive of the Big Five, leopards are solitary and nocturnal. Spotting one is a special treat.</p>
<ul>
<li><strong>Best Time:</strong> Dawn and dusk</li>
<li><strong>Where:</strong> Serengeti, Ruaha</li>
<li><strong>Tip:</strong> Check sausage trees where they rest</li>
</ul>

<h3>5. Black Rhinoceros</h3>
<p>Critically endangered, rhinos are rare but can be seen in protected areas of the Ngorongoro Crater and Serengeti.</p>
<ul>
<li><strong>Best Time:</strong> Early morning</li>
<li><strong>Where:</strong> Ngorongoro Crater</li>
<li><strong>Tip:</strong> Bring good binoculars as they keep their distance</li>
</ul>

<blockquote>Our expert guides know exactly where to find all Big Five species. Join us for an unforgettable experience!</blockquote>',
'big-five-lion.jpg',
'Wildlife Expert',
1,
312,
'college'),

-- Post 4: Photography Tips
('Safari Photography Tips for Beginners', 
'safari-photography-tips-beginners', 
'photography',
'Capture stunning wildlife photos on your safari with these expert photography tips and techniques.',
'<h2>Master Safari Photography</h2>
<p>Capturing the perfect wildlife shot requires preparation, patience, and the right techniques. Here are our top tips for stunning safari photos.</p>

<h3>Camera Settings</h3>
<ul>
<li><strong>Shutter Speed:</strong> Use at least 1/500s for moving animals, 1/1000s for birds in flight</li>
<li><strong>Aperture:</strong> f/5.6 to f/8 for sharp wildlife portraits with blurred backgrounds</li>
<li><strong>ISO:</strong> Don''t be afraid to increase ISO in low light - a grainy photo beats a blurry one</li>
<li><strong>Mode:</strong> Aperture Priority (Av/A) gives best control for wildlife</li>
</ul>

<h3>Composition Tips</h3>
<ul>
<li>Use the rule of thirds - place subjects off-center</li>
<li>Leave space in front of moving animals</li>
<li>Get eye-level when possible</li>
<li>Include environment for context</li>
<li>Wait for action and behavior</li>
</ul>

<h3>Recommended Gear</h3>
<ul>
<li><strong>Lens:</strong> 100-400mm or 200-500mm zoom</li>
<li><strong>Camera:</strong> Any DSLR or mirrorless with fast autofocus</li>
<li><strong>Support:</strong> Beanbag for vehicle window stability</li>
<li><strong>Storage:</strong> Multiple memory cards (shoot RAW)</li>
</ul>

<h3>Golden Hours</h3>
<p>The best light for photography is during the "golden hours" - the first hour after sunrise and the last hour before sunset. This warm, soft light creates magical images.</p>

<blockquote>Patience is key in wildlife photography. Sometimes the best shots come after hours of waiting!</blockquote>',
'safari-photography.jpg',
'Photo Guide',
1,
278,
'college'),

-- Post 5: Ngorongoro Guide
('Ngorongoro Crater: Complete Visitor Guide', 
'ngorongoro-crater-visitor-guide', 
'destinations',
'Everything you need to know about visiting the Ngorongoro Crater - Africa''s Garden of Eden.',
'<h2>Discover the Ngorongoro Crater</h2>
<p>The Ngorongoro Crater is one of Africa''s most spectacular natural wonders - a massive volcanic caldera teeming with wildlife.</p>

<h3>About the Crater</h3>
<ul>
<li><strong>Size:</strong> 260 square kilometers</li>
<li><strong>Depth:</strong> 600 meters deep</li>
<li><strong>Wildlife:</strong> Home to approximately 25,000 animals</li>
<li><strong>UNESCO Status:</strong> World Heritage Site since 1979</li>
</ul>

<h3>What to See</h3>
<p>The crater floor hosts an incredible density of wildlife:</p>
<ul>
<li>Black rhinos (one of the best places to spot them)</li>
<li>Lions, often seen hunting</li>
<li>Hippo pools with hundreds of hippos</li>
<li>Flamingos at Lake Magadi</li>
<li>Elephants, buffalo, and zebras</li>
</ul>

<h3>Visiting Tips</h3>
<ul>
<li>Arrive early (6 AM) to beat the crowds</li>
<li>Bring warm clothes - the rim is cold</li>
<li>Maximum 6 hours allowed on crater floor</li>
<li>Book crater fees in advance during peak season</li>
</ul>

<h3>Best Time to Visit</h3>
<p>The crater is excellent year-round, but dry season (June-October) offers the best visibility. November-December is great for bird watching.</p>

<blockquote>The Ngorongoro Crater is often called the "Eighth Wonder of the World" - and once you visit, you''ll understand why!</blockquote>',
'ngorongoro-crater.jpg',
'Safari Expert',
1,
198,
'college'),

-- Post 6: Safari Safety
('Safari Safety Tips: Stay Safe in the Wild', 
'safari-safety-tips', 
'travel-tips',
'Essential safety guidelines for your African safari adventure - from wildlife encounters to health precautions.',
'<h2>Your Safari Safety Guide</h2>
<p>While safaris are generally very safe, following these guidelines ensures a worry-free adventure.</p>

<h3>Vehicle Safety</h3>
<ul>
<li>Never stand up in the vehicle unless permitted</li>
<li>Keep all limbs inside the vehicle at all times</li>
<li>Never get out without your guide''s permission</li>
<li>Speak softly to avoid startling animals</li>
<li>Follow your driver''s instructions immediately</li>
</ul>

<h3>Wildlife Encounters</h3>
<ul>
<li>Maintain safe distances from all animals</li>
<li>Never feed wild animals</li>
<li>Avoid sudden movements or loud noises</li>
<li>Never come between a mother and her young</li>
<li>Respect animal right-of-way on roads</li>
</ul>

<h3>Camp Safety</h3>
<ul>
<li>Stay in your tent after dark unless escorted</li>
<li>Keep tent zipped at all times</li>
<li>Use a flashlight when walking at night</li>
<li>Don''t leave food in your tent</li>
<li>Listen for animal sounds and alert staff</li>
</ul>

<h3>Health Precautions</h3>
<ul>
<li>Take antimalarial medication as prescribed</li>
<li>Use insect repellent, especially at dusk</li>
<li>Drink only bottled or purified water</li>
<li>Wear sunscreen and stay hydrated</li>
<li>Bring any personal medications</li>
</ul>

<p>Our guides are trained in first aid and wildlife behavior, ensuring your safety throughout your adventure.</p>',
'safari-safety.jpg',
'Safety Expert',
1,
156,
'college');

-- ============================================
-- Create blog images directory note
-- ============================================
-- Note: Create folder: assets/img/blog/
-- Add images: safari-sunset.jpg, safari-packing.jpg, 
-- big-five-lion.jpg, safari-photography.jpg, 
-- ngorongoro-crater.jpg, safari-safety.jpg
