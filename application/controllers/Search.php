<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Frontend_Controller {

    public function index()
    {
        // Get common site data
        $data = $this->get_common_data();
        
        // Get search parameters
        $data['destination'] = $this->input->get('destination');
        $data['travelers'] = $this->input->get('travelers');
        $data['travel_date'] = $this->input->get('date');
        
        // Page-specific data
        $data['main_page'] = 'Search';
        $data['current_page_name'] = 'Safari Search Results';

        // Sample packages data (will be replaced with DB query later)
        $data['packages'] = $this->get_sample_packages($data['destination'], $data['travelers']);

        $this->load->view('includes/header', $data);
        $this->load->view('includes/navigation', $data);
        $this->load->view('pages/search-results', $data);
        $this->load->view('includes/footer', $data);
    }

    // Osiram Safari Adventure - Unique Package Collection
    private function get_sample_packages($destination = '', $travelers = '')
    {
        $all_packages = [
            // ============ SERENGETI PACKAGES ============
            [
                'id' => 1,
                'name' => '7 Days Serengeti Great Migration Safari',
                'slug' => 'serengeti-great-migration-7-days',
                'destination' => 'Serengeti National Park',
                'duration' => '7 Days / 6 Nights',
                'price' => 2850,
                'old_price' => 3200,
                'rating' => 4.9,
                'reviews' => 287,
                'image' => 'serengeti.jpg',
                'gallery' => ['serengeti-1.jpg', 'serengeti-2.jpg', 'serengeti-3.jpg'],
                'highlights' => ['Witness Great Migration', 'Big Five Encounters', 'Luxury Tented Camps', 'Balloon Safari Option'],
                'max_people' => 6,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'June - October',
                'description' => 'Witness nature\'s greatest spectacle - the Great Wildebeest Migration. Over 2 million wildebeest, zebras, and gazelles traverse the endless Serengeti plains in search of fresh grazing. This carefully crafted 7-day journey places you at the heart of the action.',
                'itinerary' => [
                    'Day 1' => 'Arrival in Arusha, briefing & overnight at Gran Melia Hotel',
                    'Day 2' => 'Drive to Serengeti via Ngorongoro, game drive en route',
                    'Day 3' => 'Full day Serengeti game drives following the migration',
                    'Day 4' => 'Serengeti exploration, optional hot air balloon safari',
                    'Day 5' => 'Morning game drive, transfer to Central Serengeti',
                    'Day 6' => 'Final Serengeti game drives, sundowner experience',
                    'Day 7' => 'Morning game drive, fly back to Arusha, departure'
                ],
                'includes' => ['4x4 Land Cruiser with pop-up roof', 'Professional English-speaking guide', 'All park fees & taxes', 'Full board accommodation', 'Bottled water during game drives', 'Airport transfers', 'Flying Doctors emergency evacuation'],
                'excludes' => ['International flights', 'Visa fees', 'Travel insurance', 'Tips & gratuities', 'Balloon safari ($599)', 'Personal expenses'],
                'accommodation' => ['Gran Melia Arusha', 'Serengeti Serena Safari Lodge', 'Mbuzi Mawe Tented Camp'],
                'badge' => '🔥 Best Seller',
                'category' => 'Wildlife Safari'
            ],
            [
                'id' => 2,
                'name' => '4 Days Serengeti Express Safari',
                'slug' => 'serengeti-express-4-days',
                'destination' => 'Serengeti National Park',
                'duration' => '4 Days / 3 Nights',
                'price' => 1650,
                'old_price' => 1850,
                'rating' => 4.8,
                'reviews' => 156,
                'image' => 'serengeti.jpg',
                'gallery' => ['serengeti-4.jpg', 'serengeti-5.jpg'],
                'highlights' => ['Big Five Safari', 'Scenic Flights', 'Luxury Lodge', 'Expert Guides'],
                'max_people' => 8,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Year-round',
                'description' => 'Short on time but big on adventure? Our 4-day Serengeti Express delivers an unforgettable wildlife experience with scenic flights and guaranteed Big Five sightings.',
                'itinerary' => [
                    'Day 1' => 'Fly from Arusha to Serengeti, afternoon game drive',
                    'Day 2' => 'Full day game drive with picnic lunch',
                    'Day 3' => 'Morning & afternoon game drives',
                    'Day 4' => 'Final game drive, fly back to Arusha'
                ],
                'includes' => ['Return flights Arusha-Serengeti', 'All game drives', 'Park fees', 'Full board accommodation', 'Expert guide'],
                'excludes' => ['International flights', 'Tips', 'Travel insurance'],
                'accommodation' => ['Four Seasons Safari Lodge Serengeti'],
                'badge' => '⚡ Quick Escape',
                'category' => 'Wildlife Safari'
            ],

            // ============ NGORONGORO PACKAGES ============
            [
                'id' => 3,
                'name' => '3 Days Ngorongoro Crater Safari',
                'slug' => 'ngorongoro-crater-3-days',
                'destination' => 'Ngorongoro Crater',
                'duration' => '3 Days / 2 Nights',
                'price' => 1250,
                'old_price' => 1450,
                'rating' => 4.9,
                'reviews' => 198,
                'image' => 'ngorongoro.jpg',
                'gallery' => ['ngorongoro-1.jpg', 'ngorongoro-2.jpg'],
                'highlights' => ['Crater Floor Game Drive', 'Black Rhino Sightings', 'Maasai Village Visit', 'Crater Rim Lodge'],
                'max_people' => 6,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Year-round',
                'description' => 'Descend into the world\'s largest intact volcanic caldera - a UNESCO World Heritage Site home to over 25,000 animals. The Ngorongoro Crater offers the best chance to spot the endangered black rhino.',
                'itinerary' => [
                    'Day 1' => 'Drive from Arusha to Ngorongoro, Maasai village visit',
                    'Day 2' => 'Full day crater floor game drive with picnic lunch',
                    'Day 3' => 'Morning crater rim walk, return to Arusha'
                ],
                'includes' => ['4x4 Safari vehicle', 'Professional guide', 'Crater fees', 'Full board', 'Maasai village visit'],
                'excludes' => ['Flights', 'Tips', 'Personal items'],
                'accommodation' => ['Ngorongoro Serena Safari Lodge'],
                'badge' => '🦏 Rhino Territory',
                'category' => 'Wildlife Safari'
            ],
            [
                'id' => 4,
                'name' => '5 Days Ngorongoro & Serengeti Combo',
                'slug' => 'ngorongoro-serengeti-combo-5-days',
                'destination' => 'Ngorongoro Crater',
                'duration' => '5 Days / 4 Nights',
                'price' => 2150,
                'old_price' => 2400,
                'rating' => 4.9,
                'reviews' => 234,
                'image' => 'ngorongoro.jpg',
                'gallery' => ['combo-1.jpg', 'combo-2.jpg', 'combo-3.jpg'],
                'highlights' => ['Two Iconic Parks', 'Big Five Guaranteed', 'Crater Descent', 'Sundowner Drinks'],
                'max_people' => 6,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'June - October',
                'description' => 'The perfect combination of Tanzania\'s two most famous wildlife destinations. Experience the crater\'s concentrated wildlife and the endless Serengeti plains in one unforgettable journey.',
                'itinerary' => [
                    'Day 1' => 'Arusha to Ngorongoro Conservation Area',
                    'Day 2' => 'Crater floor game drive, drive to Serengeti',
                    'Day 3' => 'Full day Serengeti game drives',
                    'Day 4' => 'Morning game drive, afternoon at leisure',
                    'Day 5' => 'Final game drive, return to Arusha'
                ],
                'includes' => ['All transport', 'Park fees', 'Full board', 'Guide', 'Water'],
                'excludes' => ['Flights', 'Tips', 'Balloon safari'],
                'accommodation' => ['Ngorongoro Sopa Lodge', 'Serengeti Sopa Lodge'],
                'badge' => '⭐ Top Rated',
                'category' => 'Wildlife Safari'
            ],

            // ============ KILIMANJARO PACKAGES ============
            [
                'id' => 5,
                'name' => '7 Days Kilimanjaro Machame Route',
                'slug' => 'kilimanjaro-machame-7-days',
                'destination' => 'Mount Kilimanjaro',
                'duration' => '7 Days / 6 Nights',
                'price' => 2450,
                'old_price' => 2750,
                'rating' => 4.8,
                'reviews' => 145,
                'image' => 'kilimanjaro.jpg',
                'gallery' => ['kili-1.jpg', 'kili-2.jpg', 'kili-3.jpg'],
                'highlights' => ['98% Summit Success Rate', 'Scenic Machame Route', 'Experienced Mountain Crew', 'All Equipment Provided'],
                'max_people' => 10,
                'min_people' => 1,
                'difficulty' => 'Challenging',
                'best_time' => 'Jan-Mar, Jun-Oct',
                'description' => 'Conquer Africa\'s highest peak (5,895m) via the scenic "Whiskey Route". Our expert guides and proven acclimatization schedule ensure the highest possible summit success rate.',
                'itinerary' => [
                    'Day 1' => 'Machame Gate (1,800m) to Machame Camp (3,000m)',
                    'Day 2' => 'Machame Camp to Shira Camp (3,840m)',
                    'Day 3' => 'Shira Camp to Barranco Camp (3,960m) via Lava Tower',
                    'Day 4' => 'Barranco Camp to Karanga Camp (4,035m)',
                    'Day 5' => 'Karanga Camp to Barafu Camp (4,640m)',
                    'Day 6' => 'Summit night! Uhuru Peak (5,895m), descend to Mweka Camp',
                    'Day 7' => 'Mweka Camp to Mweka Gate, transfer to hotel'
                ],
                'includes' => ['Mountain crew (guides, porters, cook)', 'Park fees', 'Camping equipment', 'All meals on mountain', 'Rescue fees', 'Certificate'],
                'excludes' => ['Flights', 'Tips ($250-350 recommended)', 'Personal gear', 'Travel insurance'],
                'accommodation' => ['Mountain camping', 'Keys Hotel Moshi (pre/post)'],
                'badge' => '🏔️ Summit Adventure',
                'category' => 'Mountain Trekking'
            ],
            [
                'id' => 6,
                'name' => '6 Days Kilimanjaro Marangu Route',
                'slug' => 'kilimanjaro-marangu-6-days',
                'destination' => 'Mount Kilimanjaro',
                'duration' => '6 Days / 5 Nights',
                'price' => 2150,
                'old_price' => 2400,
                'rating' => 4.6,
                'reviews' => 89,
                'image' => 'kilimanjaro.jpg',
                'gallery' => ['kili-4.jpg', 'kili-5.jpg'],
                'highlights' => ['Hut Accommodation', 'Classic "Coca-Cola" Route', 'Gradual Ascent', 'Beginner Friendly'],
                'max_people' => 10,
                'min_people' => 1,
                'difficulty' => 'Moderate',
                'best_time' => 'Jan-Mar, Jun-Oct',
                'description' => 'The only route with hut accommodation, Marangu is perfect for those preferring comfort on the mountain. Known as the "Coca-Cola Route" for its relative ease.',
                'itinerary' => [
                    'Day 1' => 'Marangu Gate to Mandara Hut (2,700m)',
                    'Day 2' => 'Mandara Hut to Horombo Hut (3,720m)',
                    'Day 3' => 'Acclimatization day at Horombo',
                    'Day 4' => 'Horombo Hut to Kibo Hut (4,700m)',
                    'Day 5' => 'Summit night! Uhuru Peak, descend to Horombo',
                    'Day 6' => 'Horombo to Marangu Gate'
                ],
                'includes' => ['Hut accommodation', 'All meals', 'Mountain crew', 'Park fees', 'Rescue fees'],
                'excludes' => ['Flights', 'Tips', 'Personal gear'],
                'accommodation' => ['Mountain huts', 'Springlands Hotel Moshi'],
                'badge' => '🛏️ Comfort Route',
                'category' => 'Mountain Trekking'
            ],

            // ============ ZANZIBAR PACKAGES ============
            [
                'id' => 7,
                'name' => '5 Days Zanzibar Beach & Culture',
                'slug' => 'zanzibar-beach-culture-5-days',
                'destination' => 'Zanzibar Island',
                'duration' => '5 Days / 4 Nights',
                'price' => 1450,
                'old_price' => 1650,
                'rating' => 4.9,
                'reviews' => 276,
                'image' => 'zanzibar.jpg',
                'gallery' => ['zanzibar-1.jpg', 'zanzibar-2.jpg', 'zanzibar-3.jpg'],
                'highlights' => ['Stone Town UNESCO Tour', 'Pristine Beaches', 'Spice Plantation Visit', 'Sunset Dhow Cruise'],
                'max_people' => 12,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Jun-Oct, Dec-Feb',
                'description' => 'Discover the Spice Island\'s perfect blend of pristine beaches, rich Swahili culture, and aromatic spice plantations. This 5-day escape offers the ultimate beach and cultural experience.',
                'itinerary' => [
                    'Day 1' => 'Arrival Zanzibar, transfer to beach resort',
                    'Day 2' => 'Stone Town walking tour & spice plantation',
                    'Day 3' => 'Beach day, optional water sports',
                    'Day 4' => 'Jozani Forest (red colobus monkeys), sunset dhow cruise',
                    'Day 5' => 'Leisure morning, departure'
                ],
                'includes' => ['Airport transfers', 'Beach resort accommodation', 'Breakfast daily', 'Stone Town tour', 'Spice tour', 'Dhow cruise'],
                'excludes' => ['Flights', 'Lunch & dinner', 'Water sports', 'Tips'],
                'accommodation' => ['Diamonds La Gemma dell\'Est or similar 4*'],
                'badge' => '🏖️ Beach Escape',
                'category' => 'Beach Holiday'
            ],
            [
                'id' => 8,
                'name' => '3 Days Zanzibar Quick Break',
                'slug' => 'zanzibar-quick-break-3-days',
                'destination' => 'Zanzibar Island',
                'duration' => '3 Days / 2 Nights',
                'price' => 850,
                'old_price' => 950,
                'rating' => 4.7,
                'reviews' => 124,
                'image' => 'zanzibar.jpg',
                'gallery' => ['zanzibar-4.jpg', 'zanzibar-5.jpg'],
                'highlights' => ['Beach Relaxation', 'Stone Town', 'Snorkeling', 'Seafood Dinner'],
                'max_people' => 12,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Year-round',
                'description' => 'Perfect post-safari extension! Unwind on white sand beaches after your wildlife adventure with this short but sweet Zanzibar getaway.',
                'itinerary' => [
                    'Day 1' => 'Arrival, beach resort check-in, sunset',
                    'Day 2' => 'Morning snorkeling, afternoon Stone Town tour',
                    'Day 3' => 'Leisure morning, departure'
                ],
                'includes' => ['Transfers', 'Resort stay', 'Breakfast', 'Snorkeling trip', 'Stone Town tour'],
                'excludes' => ['Flights', 'Other meals', 'Tips'],
                'accommodation' => ['Karafuu Beach Resort or similar'],
                'badge' => '⚡ Safari Add-on',
                'category' => 'Beach Holiday'
            ],

            // ============ TARANGIRE PACKAGES ============
            [
                'id' => 9,
                'name' => '4 Days Tarangire & Lake Manyara Safari',
                'slug' => 'tarangire-manyara-4-days',
                'destination' => 'Tarangire National Park',
                'duration' => '4 Days / 3 Nights',
                'price' => 1350,
                'old_price' => 1550,
                'rating' => 4.7,
                'reviews' => 112,
                'image' => 'tarangire.jpg',
                'gallery' => ['tarangire-1.jpg', 'tarangire-2.jpg'],
                'highlights' => ['Giant Elephant Herds', 'Ancient Baobab Trees', 'Tree-Climbing Lions', '500+ Bird Species'],
                'max_people' => 6,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Jun-Oct (dry season)',
                'description' => 'Home to Tanzania\'s largest elephant population and iconic baobab trees, Tarangire offers an authentic off-the-beaten-path safari experience. Combined with Lake Manyara\'s famous tree-climbing lions.',
                'itinerary' => [
                    'Day 1' => 'Arusha to Tarangire, afternoon game drive',
                    'Day 2' => 'Full day Tarangire exploration',
                    'Day 3' => 'Drive to Lake Manyara, game drive',
                    'Day 4' => 'Morning game drive, return to Arusha'
                ],
                'includes' => ['Safari vehicle', 'Guide', 'Park fees', 'Full board', 'Water'],
                'excludes' => ['Flights', 'Tips', 'Drinks'],
                'accommodation' => ['Tarangire Sopa Lodge', 'Lake Manyara Serena Lodge'],
                'badge' => '🐘 Elephant Kingdom',
                'category' => 'Wildlife Safari'
            ],

            // ============ LAKE MANYARA PACKAGES ============
            [
                'id' => 10,
                'name' => '2 Days Lake Manyara Safari',
                'slug' => 'lake-manyara-2-days',
                'destination' => 'Lake Manyara',
                'duration' => '2 Days / 1 Night',
                'price' => 650,
                'old_price' => 750,
                'rating' => 4.6,
                'reviews' => 87,
                'image' => 'manyara.jpg',
                'gallery' => ['manyara-1.jpg', 'manyara-2.jpg'],
                'highlights' => ['Tree-Climbing Lions', 'Pink Flamingos', 'Hippo Pools', 'Great Rift Valley Views'],
                'max_people' => 6,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Year-round',
                'description' => 'A compact but spectacular safari to one of Tanzania\'s most scenic parks. Famous for tree-climbing lions and massive flamingo flocks along the alkaline lake.',
                'itinerary' => [
                    'Day 1' => 'Morning drive from Arusha, afternoon game drive',
                    'Day 2' => 'Early morning game drive, return to Arusha'
                ],
                'includes' => ['Transport', 'Park fees', 'Lunch & dinner', 'Lodge stay', 'Guide'],
                'excludes' => ['Tips', 'Drinks'],
                'accommodation' => ['Lake Manyara Serena Safari Lodge'],
                'badge' => '🦁 Weekend Safari',
                'category' => 'Wildlife Safari'
            ],

            // ============ RUAHA PACKAGES ============
            [
                'id' => 11,
                'name' => '6 Days Ruaha Wilderness Safari',
                'slug' => 'ruaha-wilderness-6-days',
                'destination' => 'Ruaha National Park',
                'duration' => '6 Days / 5 Nights',
                'price' => 3250,
                'old_price' => 3650,
                'rating' => 4.9,
                'reviews' => 56,
                'image' => 'ruaha.jpg',
                'gallery' => ['ruaha-1.jpg', 'ruaha-2.jpg', 'ruaha-3.jpg'],
                'highlights' => ['Tanzania\'s Largest Park', 'Massive Lion Prides', 'Walking Safaris', 'Remote & Exclusive'],
                'max_people' => 4,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Jun-Nov',
                'description' => 'Experience true African wilderness in Tanzania\'s largest national park. Ruaha offers exceptional predator viewing with minimal crowds - the Africa of your dreams.',
                'itinerary' => [
                    'Day 1' => 'Fly Dar es Salaam to Ruaha, afternoon game drive',
                    'Day 2' => 'Full day game drives along Great Ruaha River',
                    'Day 3' => 'Morning walking safari, afternoon game drive',
                    'Day 4' => 'Full day exploration, sundowner',
                    'Day 5' => 'Game drives, night drive',
                    'Day 6' => 'Morning game drive, fly to Dar es Salaam'
                ],
                'includes' => ['Return flights', 'Luxury camp', 'All meals & drinks', 'Game drives', 'Walking safari', 'Park fees'],
                'excludes' => ['International flights', 'Tips', 'Travel insurance'],
                'accommodation' => ['Jongomero Camp or Kwihala Camp'],
                'badge' => '💎 Exclusive',
                'category' => 'Wildlife Safari'
            ],

            // ============ COMBINATION PACKAGES ============
            [
                'id' => 12,
                'name' => '10 Days Ultimate Tanzania Safari & Beach',
                'slug' => 'ultimate-tanzania-10-days',
                'destination' => 'Serengeti National Park',
                'duration' => '10 Days / 9 Nights',
                'price' => 4950,
                'old_price' => 5500,
                'rating' => 5.0,
                'reviews' => 98,
                'image' => 'serengeti.jpg',
                'gallery' => ['ultimate-1.jpg', 'ultimate-2.jpg', 'ultimate-3.jpg'],
                'highlights' => ['4 National Parks', 'Big Five Guarantee', 'Hot Air Balloon', 'Zanzibar Beach Finale'],
                'max_people' => 6,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Jun-Oct',
                'description' => 'The complete Tanzania experience! Explore the Northern Circuit\'s finest parks - Tarangire, Ngorongoro, and Serengeti - before unwinding on Zanzibar\'s pristine beaches.',
                'itinerary' => [
                    'Day 1' => 'Arrive Arusha, overnight at lodge',
                    'Day 2' => 'Arusha to Tarangire National Park',
                    'Day 3' => 'Tarangire to Ngorongoro',
                    'Day 4' => 'Ngorongoro Crater full day',
                    'Day 5' => 'Drive to Serengeti',
                    'Day 6' => 'Full day Serengeti, balloon safari',
                    'Day 7' => 'Serengeti game drives',
                    'Day 8' => 'Fly to Zanzibar, beach check-in',
                    'Day 9' => 'Zanzibar beach & Stone Town',
                    'Day 10' => 'Departure'
                ],
                'includes' => ['All transport & flights', 'Luxury accommodation', 'All meals', 'All park fees', 'Balloon safari', 'Stone Town tour', 'Guide'],
                'excludes' => ['International flights', 'Visa', 'Tips', 'Travel insurance'],
                'accommodation' => ['Arusha Coffee Lodge', 'Ngorongoro Serena', 'Four Seasons Serengeti', 'Baraza Resort Zanzibar'],
                'badge' => '👑 Premium',
                'category' => 'Luxury Safari'
            ],
            [
                'id' => 13,
                'name' => '8 Days Northern Circuit Classic',
                'slug' => 'northern-circuit-classic-8-days',
                'destination' => 'Serengeti National Park',
                'duration' => '8 Days / 7 Nights',
                'price' => 3450,
                'old_price' => 3850,
                'rating' => 4.9,
                'reviews' => 187,
                'image' => 'serengeti.jpg',
                'gallery' => ['northern-1.jpg', 'northern-2.jpg'],
                'highlights' => ['Tarangire', 'Ngorongoro', 'Serengeti', 'Lake Manyara'],
                'max_people' => 6,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Year-round',
                'description' => 'Our most popular safari covering all the iconic parks of Tanzania\'s Northern Circuit. Perfect for first-time visitors wanting the complete African safari experience.',
                'itinerary' => [
                    'Day 1' => 'Arrive Arusha',
                    'Day 2' => 'Arusha to Lake Manyara',
                    'Day 3' => 'Lake Manyara to Serengeti',
                    'Day 4' => 'Full day Serengeti',
                    'Day 5' => 'Serengeti game drives',
                    'Day 6' => 'Serengeti to Ngorongoro',
                    'Day 7' => 'Ngorongoro Crater',
                    'Day 8' => 'Return to Arusha, departure'
                ],
                'includes' => ['4x4 vehicle', 'Professional guide', 'All meals', 'Park fees', 'Accommodation'],
                'excludes' => ['Flights', 'Tips', 'Optional activities'],
                'accommodation' => ['Manyara Serena', 'Serengeti Serena', 'Ngorongoro Serena'],
                'badge' => '🌟 Classic Safari',
                'category' => 'Wildlife Safari'
            ],

            // ============ BUDGET PACKAGES ============
            [
                'id' => 14,
                'name' => '4 Days Budget Camping Safari',
                'slug' => 'budget-camping-4-days',
                'destination' => 'Serengeti National Park',
                'duration' => '4 Days / 3 Nights',
                'price' => 950,
                'old_price' => 1100,
                'rating' => 4.5,
                'reviews' => 234,
                'image' => 'serengeti.jpg',
                'gallery' => ['budget-1.jpg', 'budget-2.jpg'],
                'highlights' => ['Affordable Adventure', 'Camping Experience', 'Same Wildlife', 'Cook & Guide'],
                'max_people' => 6,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Year-round',
                'description' => 'Experience the magic of the Serengeti without breaking the bank! Our budget camping safari offers the same incredible wildlife with a more adventurous camping experience.',
                'itinerary' => [
                    'Day 1' => 'Arusha to Ngorongoro, camp at Simba Campsite',
                    'Day 2' => 'Crater tour, drive to Serengeti',
                    'Day 3' => 'Full day Serengeti game drives',
                    'Day 4' => 'Morning game drive, return to Arusha'
                ],
                'includes' => ['Camping fees', 'All meals', 'Safari vehicle', 'Guide & cook', 'Park fees', 'Camping equipment'],
                'excludes' => ['Sleeping bag (-$15/day rental)', 'Tips', 'Drinks'],
                'accommodation' => ['Public campsites with basic facilities'],
                'badge' => '💰 Budget Friendly',
                'category' => 'Budget Safari'
            ],
            [
                'id' => 15,
                'name' => '3 Days Ngorongoro Budget Safari',
                'slug' => 'ngorongoro-budget-3-days',
                'destination' => 'Ngorongoro Crater',
                'duration' => '3 Days / 2 Nights',
                'price' => 750,
                'old_price' => 850,
                'rating' => 4.4,
                'reviews' => 156,
                'image' => 'ngorongoro.jpg',
                'gallery' => ['budget-3.jpg', 'budget-4.jpg'],
                'highlights' => ['Crater Descent', 'Camping Adventure', 'Maasai Village', 'Affordable'],
                'max_people' => 6,
                'min_people' => 2,
                'difficulty' => 'Easy',
                'best_time' => 'Year-round',
                'description' => 'Experience the wonder of Ngorongoro Crater on a budget. Camp on the crater rim and descend into the caldera for an unforgettable wildlife experience.',
                'itinerary' => [
                    'Day 1' => 'Arusha to Ngorongoro, Maasai village visit',
                    'Day 2' => 'Full day crater floor game drive',
                    'Day 3' => 'Morning rim walk, return to Arusha'
                ],
                'includes' => ['Transport', 'Camping', 'Meals', 'Park fees', 'Guide'],
                'excludes' => ['Sleeping bag', 'Tips'],
                'accommodation' => ['Simba Campsite A'],
                'badge' => '💰 Value Deal',
                'category' => 'Budget Safari'
            ]
        ];

        // Filter by destination if provided
        if (!empty($destination)) {
            $filtered = array_filter($all_packages, function($package) use ($destination) {
                return stripos($package['destination'], $destination) !== false || 
                       stripos($destination, explode(' ', $package['destination'])[0]) !== false;
            });
            
            // If we found matches, return them; otherwise return all
            if (!empty($filtered)) {
                return array_values($filtered);
            }
        }

        return $all_packages;
    }
}
