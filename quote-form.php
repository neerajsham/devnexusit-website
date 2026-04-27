<!-- quote-form.php - Second form with unique IDs -->
<div class="quote-modal-content2">
    <div class="quote-modal-header">
        <h2>Get Free Quote</h2>
        <p>Fill out the form below and our team will get back to you within 24 hours</p>
        <!--<button class="quote-modal-close-consult" id="closeQuoteModalConsult">&times;</button>-->
    </div>
    <div class="quote-modal-body">
        <form id="quoteFormConsult" method="POST" action="send_quote.php" class="consult-form">
            <div class="form-group">
                <label for="quoteNameConsult"><i class="fas fa-user"></i> Full Name *</label>
                <input type="text" id="quoteNameConsult" name="name" required placeholder="Enter your full name">
            </div>
            
            <div class="form-group">
                <label for="quoteEmailConsult"><i class="fas fa-envelope"></i> Email Address *</label>
                <input type="email" id="quoteEmailConsult" name="email" required placeholder="Enter your email address">
            </div>
            
            <div class="form-group">
                <label for="quotePhoneConsult"><i class="fas fa-phone"></i> Phone Number *</label>
                <input type="tel" id="quotePhoneConsult" name="phone" required placeholder="Enter your phone number" pattern="[6-9]{1}[0-9]{9}" maxlength="10" inputmode="numeric">
            </div>
            
            <div class="form-group">
                <label for="quoteSubjectConsult"><i class="fas fa-tag"></i> Select a service *</label>
                <select id="quoteSubjectConsult" name="subject" required>
                    <option value="">Select a service</option>
                    <option value="Website Design & Development">Website Design & Development</option>
                    <option value="Software Development">Software Development</option>
                    <option value="Website Redesign">Website Redesign</option>
                    <option value="SEO & Digital Marketing">SEO & Digital Marketing</option>
                    <option value="E-commerce Solutions">E-commerce Solutions</option>
                    <option value="Mobile App Development">Mobile App Development</option>
                    <option value="AMC Services">AMC Services</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="quoteMessageConsult"><i class="fas fa-comment"></i> Message *</label>
                <textarea id="quoteMessageConsult" name="message" rows="5" required placeholder="Tell us about your project requirements..."></textarea>
            </div>
            
            <input type="text" name="website" style="display:none">
            <input type="hidden" name="form_type" value="consult_form">
            
            <div class="form-group checkbox-group quoteAgree">
                <input type="checkbox" id="quoteAgreeConsult" name="agree" required>
                <label for="quoteAgreeConsult">I agree to the <a href="#" target="_blank">Terms & Conditions</a> and <a href="#" target="_blank">Privacy Policy</a></label>
            </div>
            
            <!-- Google reCAPTCHA -->
            <div class="g-recaptcha-consult" data-sitekey="6LdU-6osAAAAAJQRqJscGrDsYiCa4w29DFb75sqh"></div>
            
            <button type="submit" class="quote-submit-btn" id="submitQuoteConsult">
                <i class="fas fa-paper-plane"></i> Send Quote Request
            </button>
        </form>
        
        <div id="quoteSuccessMessageConsult" class="quote-success" style="display: none;">
            <i class="fas fa-check-circle"></i>
            <h3>Thank You!</h3>
            <p>Your quote request has been sent successfully. Our team will contact you within 24 hours.</p>
            <button class="quote-success-close-consult">Close</button>
        </div>
    </div>
</div>

<!-- quote-form.php - Complete Updated JavaScript -->
<script>
// ========== GLOBAL RECAPTCHA HANDLER ==========
let recaptchaWidgets = {
    modal: null,
    consult: null,
    contact: null
};

// Make init globally accessible
window.initRecaptcha = function () {
    if (typeof grecaptcha === 'undefined') return;

    // MODAL CAPTCHA
    const modalCaptcha = document.querySelector('.g-recaptcha-modal');
    if (modalCaptcha && !recaptchaWidgets.modal) {
        recaptchaWidgets.modal = grecaptcha.render(modalCaptcha, {
            sitekey: '6LdU-6osAAAAAJQRqJscGrDsYiCa4w29DFb75sqh'
        });
    }

    // CONSULT CAPTCHA
    const consultCaptcha = document.querySelector('.g-recaptcha-consult');
    if (consultCaptcha && !recaptchaWidgets.consult) {
        recaptchaWidgets.consult = grecaptcha.render(consultCaptcha, {
            sitekey: '6LdU-6osAAAAAJQRqJscGrDsYiCa4w29DFb75sqh'
        });
    }

    // CONTACT CAPTCHA
    const contactCaptcha = document.querySelector('.g-recaptcha-contact');
    if (contactCaptcha && !recaptchaWidgets.contact) {
        recaptchaWidgets.contact = grecaptcha.render(contactCaptcha, {
            sitekey: '6LdU-6osAAAAAJQRqJscGrDsYiCa4w29DFb75sqh'
        });
    }
};

// Load reCAPTCHA safely
function loadRecaptcha() {
    if (typeof grecaptcha !== 'undefined') {
        window.initRecaptcha();
        return;
    }

    const script = document.createElement('script');
    script.src = "https://www.google.com/recaptcha/api.js?onload=initRecaptcha&render=explicit";
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", loadRecaptcha);
} else {
    loadRecaptcha();
}

// ========== HELPER FUNCTION FOR NOTIFICATIONS ==========
function showNotification(message, type = 'success') {
    const existingNotif = document.querySelector('.custom-notification');
    if (existingNotif) existingNotif.remove();
    
    const notification = document.createElement('div');
    notification.className = 'custom-notification';
    notification.innerHTML = `
        <div style="
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 10000;
            animation: slideIn 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 300px;
            font-family: Arial, sans-serif;
        ">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}" style="font-size: 20px;"></i>
            <span style="flex: 1;">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" style="
                background: none;
                border: none;
                color: white;
                cursor: pointer;
                font-size: 20px;
                margin-left: auto;
            ">&times;</button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification) notification.remove();
    }, 5000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .quote-success {
        text-align: center;
        padding: 40px 20px;
        animation: fadeIn 0.5s ease;
    }
    
    .quote-success i {
        font-size: 70px;
        color: #28a745;
        margin-bottom: 20px;
        animation: bounce 0.5s ease;
    }
    
    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    
    .quote-success h3 {
        font-size: 28px;
        margin-bottom: 15px;
        color: #333;
    }
    
    .quote-success p {
        font-size: 16px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 25px;
    }
    
    .quote-success-close-consult {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .quote-success-close-consult:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
`;
document.head.appendChild(style);

// ========== SECOND FORM (CONSULTATION) SCRIPT ==========
(function() {
    'use strict';
    
    // Phone number validation for second form
    const phoneInputConsult = document.getElementById("quotePhoneConsult");
    if (phoneInputConsult) {
        phoneInputConsult.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });
    }
    
    // Form submission for second form
    const formConsult = document.getElementById("quoteFormConsult");
    if (formConsult) {
        // IMPORTANT: Remove any existing event listeners by cloning and replacing
        const newForm = formConsult.cloneNode(true);
        formConsult.parentNode.replaceChild(newForm, formConsult);
        
        // Get the new form reference
        const finalForm = document.getElementById("quoteFormConsult");
        
        finalForm.addEventListener("submit", async function(e) {
            // PREVENT DEFAULT FORM SUBMISSION (THIS STOPS THE REDIRECT)
            e.preventDefault();
            e.stopPropagation();
            
            console.log("Form submission intercepted - no redirect will happen");
            
            // Check if reCAPTCHA is loaded
            if (typeof grecaptcha === 'undefined') {
                showNotification("Captcha not loaded. Please refresh page.", "error");
                return;
            }
            
            // Get reCAPTCHA response
            let captchaResponse = '';
            if (recaptchaWidgets.consult !== null) {
                captchaResponse = grecaptcha.getResponse(recaptchaWidgets.consult);
            }
            
            if (!captchaResponse) {
                showNotification("Please complete the reCAPTCHA verification", "error");
                return;
            }
            
            // Create FormData
            let formData = new FormData(finalForm);
            formData.append('g-recaptcha-response', captchaResponse);
            
            // Show loading state
            let submitBtn = document.getElementById("submitQuoteConsult");
            let originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;
            
            try {
                let response = await fetch('send_quote.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Tell server it's an AJAX request
                    }
                });
                
                let data = await response.json();
                console.log("Server response:", data);
                
                // Handle the JSON response
                if (data.success) {
                    // Hide the form
                    finalForm.style.display = "none";
                    
                    // Update success message with the message from server
                    const successDiv = document.getElementById("quoteSuccessMessageConsult");
                    const successMessage = successDiv.querySelector('p');
                    if (data.message) {
                        successMessage.innerHTML = data.message;
                    }
                    
                    // Show success message
                    successDiv.style.display = "block";
                    
                    // Reset reCAPTCHA
                    if (recaptchaWidgets.consult !== null) {
                        grecaptcha.reset(recaptchaWidgets.consult);
                    }
                    
                    // Show notification
                    showNotification(data.message || "Quote request sent successfully!", "success");
                    
                } else {
                    // Show error message from server
                    const errorMsg = data.message || "Something went wrong. Please try again.";
                    showNotification(errorMsg, "error");
                    
                    // Reset reCAPTCHA
                    if (recaptchaWidgets.consult !== null) {
                        grecaptcha.reset(recaptchaWidgets.consult);
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification("Server error. Please try again later.", "error");
                
                // Reset reCAPTCHA
                if (recaptchaWidgets.consult !== null) {
                    grecaptcha.reset(recaptchaWidgets.consult);
                }
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
            
            // Return false to prevent any default behavior
            return false;
        });
    }
    
    // Close success message for consult form
    const closeSuccessConsult = document.querySelector(".quote-success-close-consult");
    if (closeSuccessConsult) {
        closeSuccessConsult.addEventListener("click", function() {
            // Hide success message
            document.getElementById("quoteSuccessMessageConsult").style.display = "none";
            
            // Show form
            const form = document.getElementById("quoteFormConsult");
            form.style.display = "block";
            
            // Reset form
            form.reset();
            
            // Reset reCAPTCHA
            if (recaptchaWidgets.consult !== null) {
                grecaptcha.reset(recaptchaWidgets.consult);
            }
        });
    }
    
})();
</script>

