<?php
$pageTitle = "Contact DevNexusIT – Website Design and Development Company";
$pageDescription = "Get in touch with DevNexusIT, a leading website design and development company in India. Call us at +91 9671690371, email info@devnexusit.com, or visit our Faridabad office. Request a free SEO audit today.";
$pageKeywords = "contact web design company, website development India, get quote for website, DevNexusIT contact, web design agency Faridabad, Noida web development, call 9671690371, email support, info@devnexusit.com";
$pageCanonical = "https://devnexusit.com/contact";
?>
<?php include 'header.php'; ?>

  <style>

    /* Contact Section */
    .contact-section {
      width: 100%;
      padding: 5rem 5%;
      position: relative;
      background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);
    }

    /* 3 Column Contact Info Grid */
    .contact-info-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2rem;
      margin-bottom: 4rem;
    }

    .info-card {
      background: #ffffff;
      border-radius: 28px;
      padding: 2rem;
      text-align: center;
      transition: all 0.3s ease;
      border: 1px solid #eef2ff;
      box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
      position: relative;
      overflow: hidden;
    }

    .info-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #5f2eff, #8a5eff);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }

    .info-card:hover::before {
      transform: scaleX(1);
    }

    .info-card:hover {
      transform: translateY(-8px);
      border-color: #5f2eff;
      box-shadow: 0 20px 40px -12px rgba(95, 46, 255, 0.15);
    }

    .info-icon {
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, #f0f3ff, #e6ebff);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.2rem;
    }

    .info-icon i {
      font-size: 2rem;
      color: #5f2eff;
    }

    .info-card h3 {
      font-size: 1.4rem;
      font-weight: 700;
      color: #1a1f36;
      margin-bottom: 0.8rem;
    }

    .info-card p {
      color: #4a5568;
      line-height: 1.6;
      font-size: 1rem;
    }

    .info-card a {
      color: #4a5568;
      text-decoration: none;
      transition: color 0.3s;
    }

    .info-card a:hover {
      color: #5f2eff;
    }

    /* Enquiry Form Section */
    .form-section {
      background: #ffffff;
      border-radius: 32px;
      padding: 2.5rem;
      border: 1px solid #eef2ff;
      box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.08);
    }

    .form-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #1a1f36;
      margin-bottom: 0.5rem;
      text-align: center;
    }

    .form-subtitle {
      text-align: center;
      color: #6b7280;
      margin-bottom: 2rem;
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group.full-width {
      grid-column: span 2;
    }

    .form-group label {
      display: block;
      font-weight: 600;
      color: #1a1f36;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
    }

    .form-group label i {
      color: #5f2eff;
      margin-right: 6px;
    }

    /* Services Checkbox Grid */
    .services-checkbox-group {
      grid-column: span 2;
    }

    .checkbox-label {
      font-weight: 600;
      color: #1a1f36;
      margin-bottom: 1rem;
      display: block;
      font-size: 0.9rem;
    }

    .checkbox-label i {
      color: #5f2eff;
      margin-right: 6px;
    }

    .checkbox-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
    }

    .checkbox-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 0.6rem 1rem;
      background: #fafcff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .checkbox-item:hover {
      border-color: #5f2eff;
      background: #f0f3ff;
      transform: translateX(5px);
    }

    .checkbox-item input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
      accent-color: #5f2eff;
    }

    .checkbox-item label {
      cursor: pointer;
      margin-bottom: 0;
      font-weight: 500;
      color: #4a5568;
      font-size: 0.9rem;
    }

    /* Submit Button */
    .submit-btn {
      background: linear-gradient(95deg, #5f2eff, #8a5eff);
      color: white;
      border: none;
      padding: 1rem 2rem;
      border-radius: 50px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      justify-content: center;
      width: 100%;
      margin-top: 1rem;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -5px rgba(95, 46, 255, 0.4);
      background: linear-gradient(95deg, #7346ff, #9b5eff);
    }

    .submit-btn:active {
      transform: translateY(0);
    }

    /* Map Section */
    .map-section {
      margin-top: 3rem;
      border-radius: 32px;
      overflow: hidden;
      border: 1px solid #eef2ff;
    }

    .map-placeholder {
      background: linear-gradient(135deg, #f0f3ff, #e6ebff);
      padding: 3rem;
      text-align: center;
      color: #5f2eff;
    }

    .map-placeholder i {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 968px) {
      .contact-info-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }
      .form-grid {
        grid-template-columns: 1fr;
      }
      .form-group.full-width,
      .services-checkbox-group {
        grid-column: span 1;
      }
      .checkbox-grid {
        grid-template-columns: 1fr;
      }
      .section-title {
        font-size: 2.2rem;
      }
      .contact-section {
        padding: 3rem 1.5rem;
      }
      .form-section {
        padding: 1.5rem;
      }
    }

    @media (max-width: 550px) {
      .info-card {
        padding: 1.5rem;
      }
      .form-title {
        font-size: 1.5rem;
      }
    }

    /* Animations */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .info-card, .form-section {
      animation: fadeUp 0.6s ease forwards;
    }

    .info-card:nth-child(1) { animation-delay: 0.1s; }
    .info-card:nth-child(2) { animation-delay: 0.2s; }
    .info-card:nth-child(3) { animation-delay: 0.3s; }

    /* Success Toast */
    .toast-message {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: linear-gradient(95deg, #5f2eff, #8a5eff);
      color: white;
      padding: 1rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      z-index: 1000;
      animation: slideIn 0.3s ease;
      display: flex;
      align-items: center;
      gap: 10px;
    }

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
  </style>



  <section class="contact-section">
    <div class="container">
      <h2 class="section-title">Get In Touch</h2>
      <p class="section-subtitle">We'd love to hear from you. Reach out and let's create something amazing together.</p>

      <!-- 3 Column Contact Info -->
      <div class="contact-info-grid">
        <!-- Email Card -->
        <div class="info-card" style="opacity: 1; transform: translateY(0px); transition: opacity 0.6s, transform 0.6s;">
          <div class="info-icon">
            <i class="fas fa-envelope"></i>
          </div>
          <h3>Email Us</h3>
          <p>
            <a href="mailto:info@devnexusit.com">info@devnexusit.com</a><br>
            <!--<a href="mailto:support@devnexusit.com">support@devnexusit.com</a>-->
          </p>
          <p style="font-size: 0.85rem; margin-top: 0.5rem;">We reply within 24 hours</p>
        </div>

        <!-- Call Card -->
        <div class="info-card" style="opacity: 1; transform: translateY(0px); transition: opacity 0.6s, transform 0.6s;">
          <div class="info-icon">
            <i class="fas fa-phone-alt"></i>
          </div>
          <h3>Call Us</h3>
          <p>
            <a href="tel:+911234567890">+91 9671690371</a><br>
            <a href="tel:+919876543210">+91 8130310015</a>
          </p>
          <p style="font-size: 0.85rem; margin-top: 0.5rem;">Mon-Fri: 9AM - 7PM</p>
        </div>

        <!-- Address Card -->
        <div class="info-card" style="opacity: 1; transform: translateY(0px); transition: opacity 0.6s, transform 0.6s;">
          <div class="info-icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <h3>Visit Us</h3>
          <p>
            1388 - Nangla Enclave Part 2, Near Sagar School NIT, Faridabad 121005. 
          </p>
          <p style="font-size: 0.85rem; margin-top: 0.5rem;">Get directions →</p>
        </div>
      </div>

      <!-- Enquiry Form Section -->
   <div class="form-section">
    <h3 class="form-title">Send Us a Message</h3>
    <p class="form-subtitle">Fill out the form below and our team will get back to you shortly</p>

    <form id="contactFormPage" method="post">
        <div class="form-grid">
            <!-- Name -->
            <div class="form-group">
                <label><i class="fas fa-user"></i> Full Name *</label>
                <input type="text" id="contactName" name="name" placeholder="Enter your full name" required="">
            </div>

            <!-- Phone -->
            <div class="form-group">
                <label><i class="fas fa-phone"></i> Phone Number *</label>
                <input type="tel" id="contactPhone" name="phone" placeholder="Enter your mobile number" required="" pattern="[6-9]{1}[0-9]{9}" maxlength="10" inputmode="numeric">
            </div>

            <!-- Email -->
            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email Address *</label>
                <input type="email" id="contactEmail" name="email" placeholder="Enter your email address" required="">
            </div>

            <!-- Subject -->
            <div class="form-group">
                <label><i class="fas fa-tag"></i> Subject</label>
                <input type="text" id="contactSubject" name="subject" placeholder="What is this regarding?">
            </div>

            <!-- Services Checkbox (Full Width) -->
            <div class="services-checkbox-group">
                <div class="checkbox-label">
                    <i class="fas fa-cog"></i> Services You're Interested In *
                </div>
                <div class="checkbox-grid">
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_webdesign" name="services[]" value="Website Design">
                        <label for="service_webdesign">Website Design</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_dynamic" name="services[]" value="Dynamic Website">
                        <label for="service_dynamic">Dynamic Website</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_custom" name="services[]" value="Custom Website">
                        <label for="service_custom">Custom Website</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_seo" name="services[]" value="SEO">
                        <label for="service_seo">SEO</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_gmb" name="services[]" value="GMB">
                        <label for="service_gmb">GMB (Google My Business)</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_application" name="services[]" value="Application">
                        <label for="service_application">Application Development</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_logo" name="services[]" value="Logo Design">
                        <label for="service_logo">Logo Design</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_ecommerce" name="services[]" value="Ecommerce">
                        <label for="service_ecommerce">Ecommerce Website</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="service_shopify" name="services[]" value="Shopify Website">
                        <label for="service_shopify">Shopify Website</label>
                    </div>
                </div>
            </div>

            <!-- Message (Full Width) -->
            <div class="form-group full-width">
                <label><i class="fas fa-comment-dots"></i> Your Message</label>
                <textarea id="contactMessage" name="message" rows="4" placeholder="Tell us about your project requirements..." style="resize: vertical;"></textarea>
            </div>
            <input type="hidden" name="form_type" value="contact_form">
        </div>
        
        <!-- reCAPTCHA with unique class for contact form -->
        <div class="g-recaptcha-contact" data-sitekey="6LdU-6osAAAAAJQRqJscGrDsYiCa4w29DFb75sqh"></div>
        
        <button type="submit" class="submit-btn" id="contactSubmitBtn">
            <i class="fas fa-paper-plane"></i> Send Message
        </button>
    </form>
</div>
<script>
// ================== CONTACT FORM SCRIPT ==================
(function () {
    'use strict';

    let contactWidgetId;

    // ================== INIT RECAPTCHA ==================
    window.initContactCaptcha = function () {
        const el = document.querySelector('.g-recaptcha-contact');

        if (el && typeof grecaptcha !== 'undefined') {
            contactWidgetId = grecaptcha.render(el, {
                sitekey: '6LdU-6osAAAAAJQRqJscGrDsYiCa4w29DFb75sqh'
            });
        }
    };

    const form = document.getElementById("contactFormPage");
    if (!form) return;

    // ================== PHONE VALIDATION ==================
    const phoneInput = document.getElementById("contactPhone");
    if (phoneInput) {
        phoneInput.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });
    }

    // ================== GET CAPTCHA RESPONSE ==================
    function getContactRecaptchaResponse() {
        if (typeof grecaptcha !== 'undefined' && contactWidgetId !== undefined) {
            return grecaptcha.getResponse(contactWidgetId);
        }
        return '';
    }

    // ================== RESET CAPTCHA ==================
    function resetContactRecaptcha() {
        if (typeof grecaptcha !== 'undefined' && contactWidgetId !== undefined) {
            grecaptcha.reset(contactWidgetId);
        }
    }

    // ================== FORM SUBMIT ==================
    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        let captchaResponse = getContactRecaptchaResponse();

        if (!captchaResponse) {
            alert("Please complete the reCAPTCHA verification");
            return;
        }

        let formData = new FormData(form);
        formData.append('g-recaptcha-response', captchaResponse);

        let btn = document.getElementById("contactSubmitBtn");
        let originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

        try {
            let res = await fetch('send_contact.php', {
                method: "POST",
                body: formData
            });

            let data = await res.json();

            if (data.success) {
                alert("✅ Message sent successfully!");
                form.reset();
                resetContactRecaptcha();
            } else {
                alert(data.message || "Something went wrong. Please try again.");
                resetContactRecaptcha();
            }

        } catch (err) {
            console.error('Error:', err);
            alert("Server error. Please try again later.");
            resetContactRecaptcha();
        }

        btn.disabled = false;
        btn.innerHTML = originalText;
    });

})();
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=initContactCaptcha&render=explicit" async defer></script>
      <!-- Map Section (Optional) -->
      <div class="map-section">
        <div class="map-placeholder">
          <i class="fas fa-map-marked-alt"></i>
          <p style="margin-top: 0.5rem;">📍 B-42, Sector 63, Noida, Uttar Pradesh, India</p>
          <p style="font-size: 0.85rem; margin-top: 0.5rem;">View on Google Maps</p>
        </div>
      </div>
    </div>
  </section>

 
<?php include 'footer.php'; ?>

