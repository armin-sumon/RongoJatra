<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Corporate Services - RongoJatra</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css?v=2" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<style>
.corporate-header {
    background: url('images/Corporate.png') center/cover no-repeat;
    background-size: cover;
    background-position: center center;
    width: 100%;
    height: 400px;
    position: relative;
    overflow: hidden;
}

.service-grid {
    padding: 60px 0;
    background: #f5f5f5;
}

.service-item {
    text-align: left;
    padding: 25px 20px;
    margin-bottom: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    min-height: 160px;
    border: 1px solid #e9ecef;
    height: 100%;
}

.service-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.service-item.special-card {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
}

.service-grid .row {
    margin: 0;
}

.service-grid .col-md-4 {
    padding: 0 10px;
    margin-bottom: 20px;
}

.service-icon {
    font-size: 2.2rem;
    color: #000;
    margin-bottom: 20px;
    display: inline-block;
}

.service-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 12px;
    line-height: 1.3;
}

    .service-description {
        color: #666;
        line-height: 1.5;
        font-size: 0.9rem;
    }

    /* Statistics Section */
    .stats-section {
        background: white;
        padding: 60px 0;
    }

    .stat-item {
        text-align: center;
        padding: 20px;
    }

    .stat-icon {
        font-size: 3rem;
        color: #007bff;
        margin-bottom: 15px;
        display: block;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 10px;
        display: block;
    }

    .stat-label {
        color: #666;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

.main-content {
    background: white;
    padding: 60px 0;
}

.content-title {
    font-size: 2.5rem;
    color: #333;
    text-align: center;
    margin-bottom: 30px;
    font-weight: bold;
}

.content-description {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.8;
    text-align: center;
    max-width: 800px;
    margin: 0 auto 50px;
}
</style>
</head>
<body>
<?php include('includes/header.php');?>

<!-- Corporate Header Section -->
<div class="corporate-header">
    <!-- No text content - just the background image -->
</div>

<!-- Main Content Section -->
<div class="main-content">
    <div class="container">
        <h2 class="content-title wow fadeInUp animated" data-wow-delay=".5s">Our Corporate Travel Services</h2>
        <p class="content-description wow fadeInUp animated" data-wow-delay=".7s">
            At RongoJatra, we specialize in crafting personalized travel and event experiences for corporate clients across Bangladesh and globally. From annual sales conferences and team retreats to AGMs and incentive trips, we take care of everything. Whether you're planning a strategy retreat or celebrating your team, our experts will ensure it's smooth, memorable, and impactful. Our services include:
        </p>
    </div>
</div>

<!-- Services Grid -->
<div class="service-grid">
    <div class="container">
        <div class="row">
            <!-- First Row -->
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay=".5s">
                    <div class="service-icon">
                        <i class="fa fa-globe" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Domestic & International Tour Packages</h3>
                    <p class="service-description">Tailored travel solutions for your corporate team—whether exploring Bangladesh or traveling worldwide.</p>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay=".7s">
                    <div class="service-icon">
                        <i class="fa fa-building" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Hotel and Venue Bookings</h3>
                    <p class="service-description">Seamless reservations for accommodations and event venues to ensure comfort and convenience.</p>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
                <div class="service-item special-card wow fadeInUp animated" data-wow-delay=".9s">
                    <div class="service-icon">
                        <i class="fa fa-bus" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Transport & Airport Transfers</h3>
                    <p class="service-description">Hassle-free ground transport and airport transfers for executives and teams.</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Second Row -->
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay="1.1s">
                    <div class="service-icon">
                        <i class="fa fa-users" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Team Building Activities & Excursions</h3>
                    <p class="service-description">Engaging activities and outings designed to strengthen teamwork and morale.</p>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay="1.3s">
                    <div class="service-icon">
                        <i class="fa fa-calendar-plus-o" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Event Management & Gala Dinners</h3>
                    <p class="service-description">Comprehensive planning and coordination for conferences, AGMs, and memorable corporate events.</p>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay="1.5s">
                    <div class="service-icon">
                        <i class="fa fa-headphones" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">24/7 Dedicated Support Team & Onsite Travel Desks</h3>
                    <p class="service-description">Around-the-clock assistance and onsite travel desks for large organizations.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="stat-item wow fadeInUp animated" data-wow-delay=".5s">
                    <i class="fa fa-list-alt stat-icon"></i>
                    <span class="stat-number" data-count="80000">0</span>
                    <div class="stat-label">Enquiries</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item wow fadeInUp animated" data-wow-delay=".7s">
                    <i class="fa fa-user stat-icon"></i>
                    <span class="stat-number" data-count="1900">0</span>
                    <div class="stat-label">Registered Users</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item wow fadeInUp animated" data-wow-delay=".9s">
                    <i class="fa fa-ticket stat-icon"></i>
                    <span class="stat-number" data-count="70000000">0</span>
                    <div class="stat-label">Booking</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Animated counter function
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);
    
    function updateCounter() {
        start += increment;
        if (start < target) {
            element.textContent = Math.floor(start).toLocaleString();
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target.toLocaleString();
        }
    }
    
    updateCounter();
}

// Initialize counters when page loads
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        animateCounter(counter, target);
    });
});
</script>

<?php include('includes/footer.php');?>
<!-- signup -->
<?php include('includes/signup.php');?>			
<!-- //signu -->
<!-- signin -->
<?php include('includes/signin.php');?>			
<!-- //signin -->
<!-- write us -->
<?php include('includes/write-us.php');?>			
<!-- //write us -->
<!-- ===== CHATBOT WIDGET ===== -->

<div id="chatbot-container">
    <div id="chatbot-header">
        <div id="chatbot-title">
            <span>RongoJatra Assistant</span>
            <span id="chatbot-status">Online</span>
        </div>
        <button id="chatbot-close">×</button>
    </div>
    
    <div id="chatbot-messages">
        <div class="message bot-message">
            <div class="message-content">
                Hello, and welcome to RongoJatra! How can we help you with your travel plans today?
            </div>
            <div class="message-time">Just now</div>
        </div>
    </div>
    
    <div id="chatbot-input-area">
        <input type="text" id="chatbot-input" placeholder="Type your message here..." maxlength="500">
        <button id="chatbot-send">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 2L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
    
    <div id="chatbot-suggestions">
        <div class="suggestion" data-query="packages">Popular Packages</div>
        <div class="suggestion" data-query="booking">Booking Process</div>
        <div class="suggestion" data-query="contact">Contact Info</div>
        <div class="suggestion" data-query="payment">Payment Options</div>
    </div>
</div>

<button id="chatbot-toggle">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8 12H16M8 8H16M8 16H12M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="white" stroke-width="2" stroke-linecap="round"/>
    </svg>
</button>

<style>
/* Chatbot Styles */
#chatbot-container {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    z-index: 1000;
    font-family: 'Open Sans', sans-serif;
    overflow: hidden;
    transform: translateY(20px);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

#chatbot-container.active {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}

#chatbot-header {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#chatbot-title {
    display: flex;
    flex-direction: column;
}

#chatbot-title span:first-child {
    font-weight: bold;
    font-size: 16px;
}

#chatbot-status {
    font-size: 12px;
    opacity: 0.8;
}

#chatbot-close {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#chatbot-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f8f9fa;
}

.message {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
}

.bot-message {
    align-items: flex-start;
}

.user-message {
    align-items: flex-end;
}

.message-content {
    padding: 10px 15px;
    border-radius: 18px;
    max-width: 80%;
    word-wrap: break-word;
}

.bot-message .message-content {
    background: white;
    border: 1px solid #e9ecef;
    border-top-left-radius: 5px;
}

.user-message .message-content {
    background: #007bff;
    color: white;
    border-top-right-radius: 5px;
}

.message-time {
    font-size: 10px;
    color: #6c757d;
    margin-top: 5px;
}

#chatbot-input-area {
    display: flex;
    padding: 15px;
    border-top: 1px solid #e9ecef;
    background: white;
}

#chatbot-input {
    flex: 1;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    padding: 10px 15px;
    outline: none;
    font-size: 14px;
}

#chatbot-input:focus {
    border-color: #007bff;
}

#chatbot-send {
    background: #007bff;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    margin-left: 10px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s;
}

#chatbot-send:hover {
    background: #0056b3;
}

#chatbot-suggestions {
    display: flex;
    padding: 0 15px 15px;
    gap: 8px;
    flex-wrap: wrap;
}

.suggestion {
    background: #e9ecef;
    border: none;
    border-radius: 15px;
    padding: 6px 12px;
    font-size: 12px;
    cursor: pointer;
    transition: background 0.3s;
}

.suggestion:hover {
    background: #dee2e6;
}

#chatbot-toggle {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    color: white;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
    transition: transform 0.3s;
}

#chatbot-toggle:hover {
    transform: scale(1.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #chatbot-container {
        width: calc(100% - 40px);
        right: 20px;
        height: 70vh;
        bottom: 90px;
    }
    
    #chatbot-toggle {
        right: 20px;
        bottom: 20px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotContainer = document.getElementById('chatbot-container');
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotClose = document.getElementById('chatbot-close');
    const chatbotInput = document.getElementById('chatbot-input');
    const chatbotSend = document.getElementById('chatbot-send');
    const chatbotMessages = document.getElementById('chatbot-messages');
    const suggestions = document.querySelectorAll('.suggestion');
    
    // Toggle chatbot visibility
    chatbotToggle.addEventListener('click', function() {
        chatbotContainer.classList.toggle('active');
    });
    
    chatbotClose.addEventListener('click', function() {
        chatbotContainer.classList.remove('active');
    });
    
    // Send message function
    function sendMessage() {
        const message = chatbotInput.value.trim();
        if (message === '') return;
        
        // Add user message
        addMessage(message, 'user');
        chatbotInput.value = '';
        
        // Simulate bot response after a short delay
        setTimeout(() => {
            const response = generateBotResponse(message);
            addMessage(response, 'bot');
        }, 1000);
    }
    
    // Send message on button click
    chatbotSend.addEventListener('click', sendMessage);
    
    // Send message on Enter key
    chatbotInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    // Add click handlers to suggestions
    suggestions.forEach(suggestion => {
        suggestion.addEventListener('click', function() {
            const queryType = this.getAttribute('data-query');
            let message = this.textContent;
            
            // Use predefined messages for suggestions
            const suggestionMessages = {
                'packages': 'What travel packages do you offer?',
                'booking': 'How do I book a package?',
                'contact': 'What is your contact information?',
                'payment': 'What payment methods do you accept?'
            };
            
            message = suggestionMessages[queryType] || message;
            addMessage(message, 'user');
            
            // Simulate bot response after a short delay
            setTimeout(() => {
                const response = generateBotResponse(message);
                addMessage(response, 'bot');
            }, 1000);
        });
    });
    
    // Add message to chat
    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        messageContent.textContent = text;
        
        const messageTime = document.createElement('div');
        messageTime.className = 'message-time';
        messageTime.textContent = getCurrentTime();
        
        messageDiv.appendChild(messageContent);
        messageDiv.appendChild(messageTime);
        
        chatbotMessages.appendChild(messageDiv);
        
        // Scroll to bottom
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }
    
    // Get current time for message timestamp
    function getCurrentTime() {
        const now = new Date();
        return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
    
    // Enhanced bot response based on your website content
    function generateBotResponse(userMessage) {
        const lowerMessage = userMessage.toLowerCase();
        
        // Package related queries
        if (lowerMessage.includes('package') || lowerMessage.includes('tour') || lowerMessage.includes('travel')) {
            return "We offer various travel packages including:\n• Family Packages\n• Couple Packages\n• Group Packages\n• Adventure Packages\n\nYou can browse all packages on our 'Package List' page. Each package includes accommodation, transportation, and guided tours. Is there a specific destination or package type you're interested in?";
        
        // Pricing queries
        } else if (lowerMessage.includes('price') || lowerMessage.includes('cost') || lowerMessage.includes('budget')) {
            return "Our package prices range from:\n• BDT 5,000 - 10,000 for budget packages\n• BDT 10,000 - 20,000 for standard packages\n• BDT 20,000+ for premium packages\n\nYou can use the price filter on our homepage to find packages within your budget. All prices include taxes and basic amenities.";
        
        // Booking process
        } else if (lowerMessage.includes('book') || lowerMessage.includes('reservation') || lowerMessage.includes('how to book')) {
            return "Booking process is simple:\n1. Browse packages on our website\n2. Select your preferred package\n3. Choose travel dates\n4. Fill booking form with details\n5. Make payment\n6. Receive confirmation\n\nYou need to create an account first. Would you like me to guide you through any specific step?";
        
        // Contact information
        } else if (lowerMessage.includes('contact') || lowerMessage.includes('email') || lowerMessage.includes('phone') || lowerMessage.includes('address')) {
            return "You can reach us through:\n📧 Email: info@rongojatra.com\n📞 Phone: +880 XXXX-XXXXXX\n📍 Address: Dhaka, Bangladesh\n\nOur customer service team is available 9 AM - 6 PM, 7 days a week. You can also use the contact form on our website.";
        
        // Payment methods
        } else if (lowerMessage.includes('payment') || lowerMessage.includes('pay') || lowerMessage.includes('credit card') || lowerMessage.includes('bkash')) {
            return "We accept multiple payment methods:\n• Credit/Debit Cards (Visa, MasterCard)\n• Mobile Banking (bKash, Nagad)\n• Bank Transfer\n• Cash on delivery (limited areas)\n\nAll payments are secure and encrypted. You'll receive payment confirmation immediately.";
        
        // About company
        } else if (lowerMessage.includes('about') || lowerMessage.includes('company') || lowerMessage.includes('what is rongojatra')) {
            return "RongoJatra is a leading travel agency in Bangladesh offering customized tour packages across the country. We specialize in:\n• Cultural tours\n• Adventure trips\n• Family vacations\n• Honeymoon packages\n\nWe've served over 1,900 customers with 80,000+ successful bookings!";
        
        // Cancellation policy
        } else if (lowerMessage.includes('cancel') || lowerMessage.includes('refund') || lowerMessage.includes('policy')) {
            return "Our cancellation policy:\n• 7+ days before travel: Full refund\n• 3-7 days before: 50% refund\n• Less than 3 days: No refund\n\nRefunds are processed within 7-10 business days. Special conditions may apply for peak season bookings.";
        
        // Help general
        } else if (lowerMessage.includes('help') || lowerMessage.includes('support')) {
            return "I'm here to help! I can assist with:\n• Package information and pricing\n• Booking process guidance\n• Payment methods\n• Contact information\n• Cancellation policies\n\nWhat specific assistance do you need today?";
        
        // Default response
        } else {
            return "Thank you for your message! I'm here to help with information about our travel packages, booking process, pricing, and any other travel-related queries. Could you please tell me more about what you're looking for?";
        }
    }
});
</script>
<!-- ===== END CHATBOT WIDGET ===== -->

</body>
</html>

