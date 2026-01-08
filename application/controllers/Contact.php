<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Frontend_Controller {

    function __construct() 
    {
        parent::__construct();
        $this->load->model(array('Model_common', 'Enquiry_model'));
        $this->load->library('form_validation');
        $this->load->helper(array('template', 'form'));
    }

    public function index()
    {
        $data = $this->get_common_data();
        $data['main_page'] = '';
        $data['current_page_name'] = 'Contact Us';
        
        $active_template = get_active_template();
        
        if ($active_template === 'college') {
            $data['page_title'] = 'Contact Us - Get in Touch';
            $data['meta_description'] = 'Contact our institution for admissions, inquiries, and more information about our programs.';
        } else {
            $data['page_title'] = 'Contact Us - Safari Booking Inquiries';
            $data['meta_description'] = 'Get in touch with Osiram Safari Adventure for safari bookings and travel inquiries.';
        }
        
        // Load footer programs for college template
        $data['footer_programs'] = $this->get_footer_programs();

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('contact', $data);
        load_template_view('footer', $data);
    }

    /**
     * ========================================
     * SECURITY HELPER METHODS
     * ========================================
     */
    
    /**
     * Check honeypot field - bots will fill this
     */
    private function check_honeypot()
    {
        $honeypot = $this->input->post('website_url');
        return empty($honeypot);
    }
    
    /**
     * Rate limiting - prevent form flooding
     */
    private function check_rate_limit($form_type = 'contact')
    {
        $session_key = $form_type . '_submissions';
        $time_key = $form_type . '_last_submit';
        
        $submissions = $this->session->userdata($session_key) ?? 0;
        $last_submit = $this->session->userdata($time_key) ?? 0;
        
        // Allow max 5 submissions per hour
        if ($submissions >= 5 && (time() - $last_submit) < 3600) {
            return false;
        }
        
        // Reset counter if more than an hour has passed
        if ((time() - $last_submit) >= 3600) {
            $submissions = 0;
        }
        
        // Update session
        $this->session->set_userdata($session_key, $submissions + 1);
        $this->session->set_userdata($time_key, time());
        
        return true;
    }
    
    /**
     * Sanitize input string
     */
    private function sanitize_input($input)
    {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $this->security->xss_clean($input);
    }
    
    /**
     * Validate email format strictly
     */
    private function is_valid_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && 
               preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
    }
    
    /**
     * Get CAPTCHA error message based on active theme
     */
    private function get_captcha_error_message()
    {
        $active_template = get_active_template();
        
        if ($active_template === 'college') {
            return '📚 Incorrect answer! That\'s not right. Let\'s test your knowledge again!';
        } else {
            return '🦁 Oops! Wrong safari answer. Are you sure you\'re not a hyena bot? Try again!';
        }
    }
    
    /**
     * Get CAPTCHA questions based on active theme
     */
    private function get_captcha_questions()
    {
        $active_template = get_active_template();
        
        if ($active_template === 'college') {
            return $this->get_college_questions();
        } else {
            return $this->get_safari_questions();
        }
    }
    
    /**
     * Get College CAPTCHA questions pool
     */
    private function get_college_questions()
    {
        return [
            // General Knowledge
            ['q' => '🎓 What degree is typically earned after 4 years of undergraduate study?', 'a' => 'bachelor', 'hint' => 'Bachelor\'s...'],
            ['q' => '📚 What is the traditional color of academic robes?', 'a' => 'black', 'hint' => 'Dark color...'],
            ['q' => '🏫 What is the main building at a university called?', 'a' => 'campus', 'hint' => 'The grounds...'],
            
            // Academic Terms
            ['q' => '📖 A period of teaching in a school year is called a...?', 'a' => 'semester', 'hint' => '6 months...'],
            ['q' => '✏️ What do students take to assess their knowledge?', 'a' => 'exam', 'hint' => 'Or test...'],
            ['q' => '🎒 What school supply do students use to write?', 'a' => 'pen', 'hint' => 'Or pencil...'],
            ['q' => '📝 A written task given by a teacher is called an...?', 'a' => 'assignment', 'hint' => 'Or homework...'],
            
            // Education Facts
            ['q' => '👨‍🎓 A student who studies at university is called a...?', 'a' => 'student', 'hint' => 'Or scholar...'],
            ['q' => '🧑‍🏫 A person who teaches at school is called a...?', 'a' => 'teacher', 'hint' => 'Or professor...'],
            ['q' => '🏆 What do students receive for completing a course?', 'a' => 'certificate', 'hint' => 'Or diploma...'],
            
            // Simple Questions
            ['q' => '🔤 How many letters are in the English alphabet?', 'a' => '26', 'hint' => 'Count them...'],
            ['q' => '🔢 Is math easier or harder for most students?', 'a' => 'harder', 'hint' => 'Challenging...'],
            ['q' => '📚 Are libraries good places to study? (yes/no)', 'a' => 'yes', 'hint' => 'Quiet spaces...'],
            ['q' => '✍️ Do students enjoy writing essays? (yes/no)', 'a' => 'yes', 'hint' => 'Most do...'],
            ['q' => '🎯 Is education important? (yes/no)', 'a' => 'yes', 'hint' => 'Very much...'],
            
            // University Life
            ['q' => '🎓 The head of a university is called a...?', 'a' => 'chancellor', 'hint' => 'Or principal...'],
            ['q' => '👥 What is a group of students in a class called?', 'a' => 'class', 'hint' => 'A cohort...'],
            ['q' => '📋 A list of classes you\'re taking is your...?', 'a' => 'schedule', 'hint' => 'Or timetable...'],
            ['q' => '🎓 What do you wear at graduation?', 'a' => 'gown', 'hint' => 'Academic robe...'],
            ['q' => '🎯 What is the official written record of grades called?', 'a' => 'transcript', 'hint' => 'Academic history...'],
            
            // Subject Areas
            ['q' => '📐 What subject deals with numbers and calculations?', 'a' => 'math', 'hint' => 'Or mathematics...'],
            ['q' => '🌍 What subject studies the Earth and its people?', 'a' => 'geography', 'hint' => 'Or social studies...'],
            ['q' => '⚗️ What subject studies matter and reactions?', 'a' => 'chemistry', 'hint' => 'Lab science...'],
            ['q' => '🔬 What subject studies living organisms?', 'a' => 'biology', 'hint' => 'Life science...'],
            ['q' => '📜 What subject studies past events?', 'a' => 'history', 'hint' => 'The past...'],
            
            // Learning Concepts
            ['q' => '💡 What is the process of gaining knowledge called?', 'a' => 'learning', 'hint' => 'Education...'],
            ['q' => '🧠 What is the organ you use to think and learn?', 'a' => 'brain', 'hint' => 'In your head...'],
            ['q' => '📖 What is a written work with many pages called?', 'a' => 'book', 'hint' => 'Reading material...'],
            ['q' => '🎒 What do students carry to school?', 'a' => 'backpack', 'hint' => 'Bag for books...'],
            ['q' => '⏰ What shows when classes start and end?', 'a' => 'bell', 'hint' => 'Or timer...'],
            
            // Degrees & Studies
            ['q' => '📊 What degree involves business studies?', 'a' => 'bba', 'hint' => 'Business admin...'],
            ['q' => '💻 What field studies computer systems?', 'a' => 'computer science', 'hint' => 'Tech field...'],
            ['q' => '⚡ What field studies electricity and magnetism?', 'a' => 'engineering', 'hint' => 'Building things...'],
            ['q' => '🔢 What field focuses on numbers and calculations?', 'a' => 'mathematics', 'hint' => 'Numbers...'],
            ['q' => '🩺 What field studies human health?', 'a' => 'medicine', 'hint' => 'Or health science...'],
        ];
    }
    
    /**
     * Get Safari CAPTCHA questions pool
     */
    private function get_safari_questions()
    {
        return [
            // Animal Facts
            ['q' => '🦓 What color are a zebra\'s stripes?', 'a' => 'black', 'hint' => 'Not white...'],
            ['q' => '🦁 Who is the "King of the Jungle"?', 'a' => 'lion', 'hint' => 'Starts with L...'],
            ['q' => '🐘 Which animal never forgets?', 'a' => 'elephant', 'hint' => 'Has a trunk...'],
            ['q' => '🦒 Which animal has the longest neck?', 'a' => 'giraffe', 'hint' => 'Reaches treetops...'],
            ['q' => '🦛 What\'s the most dangerous animal in Africa?', 'a' => 'hippo', 'hint' => 'Lives in water...'],
            ['q' => '🐆 Spots or stripes: What does a leopard have?', 'a' => 'spots', 'hint' => 'Not stripes...'],
            ['q' => '🦏 How many horns does a rhino have?', 'a' => '2', 'hint' => 'More than 1...'],
            ['q' => '🦩 What color is a flamingo?', 'a' => 'pink', 'hint' => 'Think about it...'],
            ['q' => '🐆 Is a cheetah fast or slow?', 'a' => 'fast', 'hint' => 'Fastest land animal!'],
            ['q' => '🦁 What sound does a lion make?', 'a' => 'roar', 'hint' => 'It\'s loud!'],
            
            // Geography
            ['q' => '🌍 Mount Kilimanjaro is in which country?', 'a' => 'tanzania', 'hint' => 'You\'re booking with us!'],
            ['q' => '🌊 What ocean borders Tanzania?', 'a' => 'indian', 'hint' => 'Not Atlantic...'],
            ['q' => '🌍 Is Tanzania in Africa or Antarctica?', 'a' => 'africa', 'hint' => 'It\'s warm there!'],
            ['q' => '🏝️ Zanzibar is an... (island/mountain)?', 'a' => 'island', 'hint' => 'Surrounded by water...'],
            
            // Silly/Easy Questions
            ['q' => '🐘 Is an elephant big or small?', 'a' => 'big', 'hint' => 'Very, very...'],
            ['q' => '🦒 Does a giraffe have a long or short neck?', 'a' => 'long', 'hint' => 'Reaches the trees...'],
            ['q' => '🐘 Do elephants have wings? (yes/no)', 'a' => 'no', 'hint' => 'They can\'t fly!'],
            ['q' => '🦁 Can a lion fly? (yes/no)', 'a' => 'no', 'hint' => 'They run instead!'],
            ['q' => '🦛 Can a hippo fit in your pocket? (yes/no)', 'a' => 'no', 'hint' => 'Way too big!'],
            ['q' => '🌍 Is Africa a continent? (yes/no)', 'a' => 'yes', 'hint' => 'Obviously...'],
            ['q' => '🐊 Do crocodiles live in water? (yes/no)', 'a' => 'yes', 'hint' => 'They swim!'],
            ['q' => '🦩 Are flamingos birds? (yes/no)', 'a' => 'yes', 'hint' => 'They have wings...'],
            
            // Safari Math
            ['q' => '🦁 1 lion + 1 lion = how many lions?', 'a' => '2', 'hint' => 'Basic math!'],
            ['q' => '🦓 How many legs does a zebra have?', 'a' => '4', 'hint' => 'Same as a horse...'],
            ['q' => '🐘 2 elephants + 3 elephants = ?', 'a' => '5', 'hint' => 'Count them!'],
            
            // Fun Safari Knowledge
            ['q' => '🌅 Best time for safari: morning or midnight?', 'a' => 'morning', 'hint' => 'Animals are active early!'],
            ['q' => '😴 Do lions sleep or run 20 hours a day?', 'a' => 'sleep', 'hint' => 'They\'re lazy cats!'],
            ['q' => '🦁 The Big 5: Lion, Leopard, Elephant, Buffalo and...?', 'a' => 'rhino', 'hint' => 'Has a horn...'],
            
            // Additional Questions (synced with view)
            ['q' => '🦜 Which bird can mimic human speech?', 'a' => 'parrot', 'hint' => 'Colorful bird...'],
            ['q' => '🐊 What animal has the strongest bite?', 'a' => 'crocodile', 'hint' => 'Lives in rivers...'],
            ['q' => '🦘 Which animal carries its baby in a pouch?', 'a' => 'kangaroo', 'hint' => 'Hops around...'],
            ['q' => '🐘 What does an elephant use to drink water?', 'a' => 'trunk', 'hint' => 'Long nose...'],
            ['q' => '🦓 Where do zebras live?', 'a' => 'africa', 'hint' => 'A continent...'],
            ['q' => '🦁 What is a group of lions called?', 'a' => 'pride', 'hint' => 'Like "pride of lions"...'],
            ['q' => '🦒 What do giraffes eat?', 'a' => 'leaves', 'hint' => 'From trees...'],
            ['q' => '🐆 What is the fastest land animal?', 'a' => 'cheetah', 'hint' => 'Spotted cat...'],
            ['q' => '🦏 What is rhino horn made of?', 'a' => 'keratin', 'hint' => 'Like fingernails...'],
            ['q' => '🦛 How much time do hippos spend in water?', 'a' => 'day', 'hint' => 'During the...'],
            ['q' => '🦉 Which bird hunts at night?', 'a' => 'owl', 'hint' => 'Wise bird...'],
            ['q' => '🐍 Which reptile has no legs?', 'a' => 'snake', 'hint' => 'Slithers...'],
            ['q' => '🦩 What makes flamingos pink?', 'a' => 'shrimp', 'hint' => 'Their diet...'],
            ['q' => '🐵 Which primate is known for climbing?', 'a' => 'monkey', 'hint' => 'Loves bananas...'],
            ['q' => '🦌 Which animal has antlers?', 'a' => 'deer', 'hint' => 'Or stag...'],
            ['q' => '🐅 What big cat has stripes?', 'a' => 'tiger', 'hint' => 'Orange and black...'],
            ['q' => '🦓 Are zebras black with white stripes or white with black stripes?', 'a' => 'black', 'hint' => 'The background color...'],
            ['q' => '🦁 What do lions primarily hunt?', 'a' => 'zebra', 'hint' => 'Or wildebeest...'],
            ['q' => '🐘 How do elephants communicate?', 'a' => 'trumpet', 'hint' => 'Loud sound...'],
            ['q' => '🦒 How tall can a giraffe grow?', 'a' => '18', 'hint' => 'In feet...'],
            ['q' => '🦛 What is a hippo\'s closest relative?', 'a' => 'whale', 'hint' => 'Marine mammal...'],
            ['q' => '🐆 Can leopards climb trees?', 'a' => 'yes', 'hint' => 'They drag prey up...'],
            ['q' => '🦏 What does "rhinoceros" mean?', 'a' => 'nose', 'hint' => 'Greek word...'],
            ['q' => '🌍 What is the largest desert in Africa?', 'a' => 'sahara', 'hint' => 'Very hot...'],
            ['q' => '🦩 Where do flamingos sleep?', 'a' => 'water', 'hint' => 'Standing up...'],
            ['q' => '🦜 What do parrots eat?', 'a' => 'nuts', 'hint' => 'And seeds...'],
            ['q' => '🐊 How long can crocodiles hold their breath?', 'a' => 'hours', 'hint' => 'Multiple...'],
            ['q' => '🦘 What is a baby kangaroo called?', 'a' => 'joey', 'hint' => 'Cute name...'],
            ['q' => '🦉 What can owls do with their heads?', 'a' => 'turn', 'hint' => 'Almost all the way...'],
            ['q' => '🐍 How do snakes move?', 'a' => 'slither', 'hint' => 'No legs...'],
            ['q' => '🐵 What is a monkey\'s favorite fruit?', 'a' => 'banana', 'hint' => 'Yellow fruit...'],
            ['q' => '🦌 When do deer shed antlers?', 'a' => 'winter', 'hint' => 'Cold season...'],
            ['q' => '🐅 Where do tigers live?', 'a' => 'asia', 'hint' => 'Not Africa...'],
            ['q' => '🦓 Can zebras be ridden?', 'a' => 'no', 'hint' => 'Unlike horses...'],
            ['q' => '🦁 How many hours do lions sleep?', 'a' => '20', 'hint' => 'Per day...'],
            ['q' => '🐘 What protects elephant skin?', 'a' => 'mud', 'hint' => 'They roll in it...'],
            ['q' => '🦒 How many neck bones does a giraffe have?', 'a' => '7', 'hint' => 'Same as humans...'],
            ['q' => '🦛 Can hippos swim?', 'a' => 'no', 'hint' => 'They walk underwater...'],
            ['q' => '🐆 What is a leopard\'s favorite tree?', 'a' => 'acacia', 'hint' => 'African tree...'],
        ];
    }
    
    /**
     * AJAX: Get new Safari CAPTCHA question
     */
    public function refresh_captcha()
    {
        // Check if AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $type = $this->input->post('type') ?? 'contact';
        $refresh_key = 'captcha_refresh_count_' . $type;
        $refresh_count = $this->session->userdata($refresh_key) ?? 0;
        
        // Max 3 refreshes
        if ($refresh_count >= 3) {
            echo json_encode([
                'success' => false,
                'message' => 'No more refreshes available! Answer this one 🦁',
                'remaining' => 0
            ]);
            return;
        }
        
        // Get random question
        $questions = $this->get_captcha_questions();
        $random_key = array_rand($questions);
        $captcha = $questions[$random_key];
        
        // Store answer and key in session
        $session_key = 'safari_captcha_' . $type;
        $this->session->set_userdata($session_key, strtolower($captcha['a']));
        $this->session->set_userdata($session_key . '_key', $random_key);
        
        // Increment refresh count
        $this->session->set_userdata($refresh_key, $refresh_count + 1);
        
        echo json_encode([
            'success' => true,
            'question' => $captcha['q'],
            'hint' => $captcha['hint'],
            'remaining' => 3 - ($refresh_count + 1)
        ]);
    }
    
    /**
     * Validate Safari CAPTCHA answer
     */
    private function check_safari_captcha($type = 'contact')
    {
        $user_answer = strtolower(trim($this->input->post('safari_answer') ?? ''));
        $session_key = 'safari_captcha_' . $type;
        $correct_answer = $this->session->userdata($session_key);
        
        if (empty($correct_answer)) {
            return false; // Session expired or tampered
        }
        
        $is_correct = $user_answer === $correct_answer;
        
        // Only clear after successful validation
        if ($is_correct) {
            $this->session->unset_userdata($session_key);
            $this->session->unset_userdata($session_key . '_key');
            // Also clear refresh count
            $this->session->unset_userdata('captcha_refresh_count_' . $type);
        }
        
        return $is_correct;
    }
    
    /**
     * Check for spam keywords in message
     */
    private function contains_spam($text)
    {
        $spam_keywords = [
            'viagra', 'cialis', 'casino', 'lottery', 'winner', 
            'bitcoin', 'crypto', 'investment opportunity', 'make money fast',
            'click here', 'act now', 'limited time', 'free money',
            'nigerian prince', 'inheritance', 'million dollars'
        ];
        
        $text_lower = strtolower($text);
        foreach ($spam_keywords as $keyword) {
            if (strpos($text_lower, $keyword) !== false) {
                return true;
            }
        }
        
        // Check for excessive links
        $link_count = preg_match_all('/https?:\/\//', $text);
        if ($link_count > 2) {
            return true;
        }
        
        return false;
    }

    /**
     * ========================================
     * CONTACT FORM HANDLER
     * ========================================
     */
    public function submit()
    {
        return $this->contact_query();
    }

    public function contact_query() 
    { 
        if ($this->input->method() !== 'post') {
            redirect(base_url('contact'));
            return;
        }

        // Security Check 1: Honeypot
        if (!$this->check_honeypot()) {
            log_message('error', 'Contact form honeypot triggered from IP: ' . $this->input->ip_address());
            redirect(base_url('contact'));
            return;
        }

        // Security Check 2: Rate Limiting
        if (!$this->check_rate_limit('contact')) {
            $this->session->set_flashdata('error', 'Too many submissions. Please try again later.');
            redirect(base_url('contact'));
            return;
        }

        // Security Check 3: CAPTCHA
         if (!$this->check_safari_captcha()) {
             $error_msg = $this->get_captcha_error_message();
             $this->session->set_flashdata('error', $error_msg);
             redirect(base_url('contact'));
             return;
         }

        // Form Validation Rules
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|max_length[150]');
        $this->form_validation->set_rules('subject', 'Subject', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('message', 'Message', 'required|min_length[10]|max_length[2000]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url('contact'));
            return;
        }

        // Sanitize all inputs
        $full_name = $this->sanitize_input($this->input->post('full_name'));
        $email = $this->sanitize_input($this->input->post('email_address'));
        $subject = $this->sanitize_input($this->input->post('subject'));
        $message = $this->sanitize_input($this->input->post('message'));

        // Security Check 3: Validate email format
        if (!$this->is_valid_email($email)) {
            $this->session->set_flashdata('error', 'Please enter a valid email address.');
            redirect(base_url('contact'));
            return;
        }

        // Security Check 4: Spam detection
        if ($this->contains_spam($message) || $this->contains_spam($subject)) {
            log_message('error', 'Spam detected in contact form from IP: ' . $this->input->ip_address());
            $this->session->set_flashdata('error', 'Your message could not be sent. Please try again.');
            redirect(base_url('contact'));
            return;
        }

        // Prepare data for database
        // Note: Using special_requirements for message since contact_enquiries table doesn't have subject/message columns
        $enquiry_data = [
            'email' => $email,
            'full_name' => $full_name,
            'trip_type' => 'Contact Form',
            'special_requirements' => "Subject: {$subject}\n\nMessage:\n{$message}",
            'ip_address' => $this->input->ip_address(),
        ];

        // Save to database
        $enquiry_id = $this->Enquiry_model->save_enquiry($enquiry_data);
        
        if (!$enquiry_id) {
            log_message('error', 'Failed to save contact enquiry to database');
            $this->session->set_flashdata('error', 'Something went wrong. Please try again later.');
            redirect(base_url('contact'));
            return;
        }

        // Build email
        $receiver_mail = 'osiramsafari@gmail.com';
        $email_subject = 'CONTACT - QUERY';

        $body = '<h3>New Contact Form Submission</h3>
                 <p><strong>From:</strong> ' . $email . '</p>
                 <p><strong>Name:</strong> ' . $full_name . '</p>
                 <p><strong>Subject:</strong> ' . $subject . '</p>
                 <p><strong>Message:</strong></p>
                 <p>' . nl2br($message) . '</p>
                 <hr>
                 <p><small>IP Address: ' . $this->input->ip_address() . '</small></p>
                 <p><small>Submitted: ' . date('Y-m-d H:i:s') . '</small></p>';

        // Send email (don't fail if email fails - data is already saved)
        $email_sent = $this->sendEmail($receiver_mail, $email_subject, $body);
        
        if ($email_sent) {
            $this->Enquiry_model->mark_email_sent($enquiry_id);
        }

        // Store contact submission data for success page
         $this->session->set_userdata('last_contact', (object) [
             'name' => $full_name,
             'email' => $email,
             'subject' => $subject,
             'message' => $message,
             'created_at' => date('Y-m-d H:i:s')
         ]);
         
         // Set success message
         $this->session->set_flashdata('success', '✓ Thank you! Your message has been sent successfully. We will get back to you as soon as possible.');
         
         redirect(base_url('contact/success'));
    }

    /**
     * Show success page
     */
    public function success()
    {
        $contact = $this->session->userdata('last_contact');
        
        if (!$contact) {
            redirect(base_url('contact'));
            return;
        }

        $data = $this->get_common_data();
        $data['current_page_name'] = 'Message Sent';
        $data['main_page'] = 'Contact';
        $data['contact'] = $contact;

        // Clear the session data
        $this->session->unset_userdata('last_contact');

        load_template_view('header', $data);
        load_template_view('navigation', $data);
        load_template_page('contact-success', $data);
        load_template_view('footer', $data);
    }

    /**
     * ========================================
     * BOOKING FORM HANDLER
     * ========================================
     */
    public function booking_query() 
    { 
        if (!$this->input->post('submit')) {
            redirect(base_url());
            return;
        }

        // Security Check 1: Honeypot
        if (!$this->check_honeypot()) {
            log_message('error', 'Booking form honeypot triggered from IP: ' . $this->input->ip_address());
            redirect(base_url());
            return;
        }

        // Security Check 2: Rate Limiting
        if (!$this->check_rate_limit('booking')) {
            $this->session->set_flashdata('error', 'Too many submissions. Please try again later.');
            redirect(base_url());
            return;
        }

        // Security Check 3: Safari CAPTCHA
        if (!$this->check_safari_captcha('booking')) {
            $this->session->set_flashdata('error', '🐘 Whoops! Even elephants know that answer! Try the safari quiz again.');
            redirect(base_url());
            return;
        }

        // Form Validation Rules
        $this->form_validation->set_rules('fullname', 'Full Name', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|max_length[150]');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('adult', 'Adults', 'required|integer|greater_than[0]|less_than[50]');
        $this->form_validation->set_rules('children', 'Children', 'integer|greater_than_equal_to[0]|less_than[50]');
        $this->form_validation->set_rules('arrival_date', 'Arrival Date', 'required');
        $this->form_validation->set_rules('message', 'Message', 'max_length[2000]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url());
            return;
        }

        // Sanitize all inputs
        $fullname = $this->sanitize_input($this->input->post('fullname'));
        $email = $this->sanitize_input($this->input->post('email_address'));
        $phone = $this->sanitize_input($this->input->post('phone_number'));
        $adult = (int) $this->input->post('adult');
        $children = (int) ($this->input->post('children') ?? 0);
        $arrival_date = $this->sanitize_input($this->input->post('arrival_date'));
        $budget = $this->sanitize_input($this->input->post('safari_budget') ?? '');
        $message = $this->sanitize_input($this->input->post('message') ?? '');

        // Security Check 3: Validate email format
        if (!$this->is_valid_email($email)) {
            $this->session->set_flashdata('error', 'Please enter a valid email address.');
            redirect(base_url());
            return;
        }

        // Security Check 4: Validate phone (basic)
        if (!preg_match('/^[\d\s\+\-\(\)]{6,20}$/', $phone)) {
            $this->session->set_flashdata('error', 'Please enter a valid phone number.');
            redirect(base_url());
            return;
        }

        // Security Check 5: Validate arrival date is in the future
        $arrival_timestamp = strtotime($arrival_date);
        if ($arrival_timestamp === false || $arrival_timestamp < strtotime('today')) {
            $this->session->set_flashdata('error', 'Please select a valid future arrival date.');
            redirect(base_url());
            return;
        }

        // Security Check 6: Spam detection
        if ($this->contains_spam($message)) {
            log_message('error', 'Spam detected in booking form from IP: ' . $this->input->ip_address());
            $this->session->set_flashdata('error', 'Your booking could not be submitted. Please try again.');
            redirect(base_url());
            return;
        }

        // Prepare data
        $data = [
            'fullName' => $fullname,
            'contact_phone' => $phone,
            'email_address' => $email,
            'adult' => $adult,
            'children' => $children,
            'arrival_date' => $arrival_date,
            'safari_budget' => $budget,
            'message' => $message,
            'ip_address' => $this->input->ip_address(),
            'submitted_at' => date('Y-m-d H:i:s')
        ];

        // Build email
        $receiver_mail = 'osiramsafari@gmail.com';
        $subject = 'QUICK BOOKING - QUERY';

        $body = '<h3>New Booking Request</h3>
                 <p><strong>Name:</strong> ' . $data['fullName'] . '</p>
                 <p><strong>Email:</strong> ' . $data['email_address'] . '</p>
                 <p><strong>Phone:</strong> ' . $data['contact_phone'] . '</p>
                 <p><strong>Adults:</strong> ' . $data['adult'] . '</p>
                 <p><strong>Children:</strong> ' . $data['children'] . '</p>
                 <p><strong>Arrival Date:</strong> ' . $data['arrival_date'] . '</p>
                 <p><strong>Budget:</strong> ' . ($data['safari_budget'] ?: 'Not specified') . '</p>
                 <p><strong>Special Requests:</strong></p>
                 <p>' . nl2br($data['message'] ?: 'None') . '</p>
                 <hr>
                 <p><small>IP Address: ' . $data['ip_address'] . '</small></p>
                 <p><small>Submitted: ' . $data['submitted_at'] . '</small></p>';

        // Send email
        if ($this->sendEmail($receiver_mail, $subject, $body)) {
            $this->session->set_flashdata('success', 'Your booking request was sent successfully! We will contact you within 24 hours.');
            redirect(base_url());
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again later.');
            redirect(base_url());
        }
    }

    /**
     * ========================================
     * EMAIL SENDER
     * ========================================
     */
    public function sendEmail($to, $subject, $message) 
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'lembris.internet@gmail.com',
            'smtp_pass' => 'oaau mhwh fevr fhhy',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'smtp_crypto' => 'tls',
            'newline' => "\r\n",
        );
        
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('lembris.internet@gmail.com', 'Osiram Safari Adventure');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        
        if ($this->email->send()) {
            return TRUE;
        } else {
            log_message('error', 'Email failed: ' . $this->email->print_debugger());
            return FALSE;
        }
    }
}
