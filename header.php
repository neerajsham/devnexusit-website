<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, viewport-fit=cover">
  <!-- Primary SEO -->
<title><?php echo $pageTitle ?? "DevNexusIT | Website Design & Development Company"; ?></title>
<meta name="description" content="<?php echo $pageDescription ?? "DevnexusIT is a leading website design and development company in India offering responsive, SEO-friendly, and high-performance websites to help businesses grow online."; ?>">

  <meta name="keywords" content="<?php echo $pageKeywords ?? "web design, development"; ?>">

  <link rel="canonical" href="<?php echo $pageCanonical ?? "https://devnexusit.com/"; ?>">
  <meta name="author" content="DevNexusIT">
<meta property="og:site_name" content="DevNexusIT">
<meta property="og:locale" content="en_IN">
  <!-- Favicon -->
<link rel="icon" type="image/png" href="https://devnexusit.com/images/favdev.webp">
  <link rel="shortcut icon" href="https://devnexusit.com/images/favdev.webp">
  <link rel="apple-touch-icon" href="images/favdev.webp">
  <link rel="sitemap" type="application/xml" title="Sitemap" href="https://devnexusit.com/sitemap.xml">
  
  <script src="https://analytics.ahrefs.com/analytics.js" data-key="oWa0YaUjJKhxDra9iexjww" async></script>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DXWQBKRWMF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-DXWQBKRWMF');
</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K494D5P4');</script>
<!-- End Google Tag Manager -->
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <meta name="robots" content="index, follow">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="/css/style.css">
  
  <!-- Open Graph (Facebook, LinkedIn) -->
  <meta property="og:type" content="website">
 <meta property="og:title" content="<?php echo $pageTitle ?? ''; ?>">
  <meta property="og:description" content="<?php echo $pageDescription ?? ''; ?>">
  <meta property="og:url" content="<?php echo $pageCanonical ?? ''; ?>">
  <meta property="og:image" content="https://devnexusit.com/images/favdev.webp">
  
  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://devnexusit.com/#organization",
      "name": "DevNexus IT",
      "url": "https://devnexusit.com",
      "logo": "https://devnexusit.com/images/favdev.webp",
      "sameAs": [
        "https://www.facebook.com/devnexusit",
        "https://www.linkedin.com/company/devnexusit"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-9671690371",
        "contactType": "customer service",
        "areaServed": "IN",
        "availableLanguage": ["en", "Hindi"]
      }
    },
    {
      "@type": "ProfessionalService",
      "@id": "https://devnexusit.com/service",
      "name": "DevNexus IT - Web Design & SEO Company",
      "image": "https://devnexusit.com/images/favdev.webp",
      "url": "https://devnexusit.com",
      "telephone": "+91-9671690371",
      "priceRange": "$$",
      "provider": {
        "@id": "https://devnexusit.com/#organization"
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "1388 - Nangla Enclave Part 2, Near Sagar School NIT",
        "addressLocality": "Faridabad",
        "addressRegion": "Haryana",
        "postalCode": "121005",
        "addressCountry": "IN"
      },
      "areaServed": {
        "@type": "Place",
        "name": "India"
      },
      "description": "DevNexus IT provides expert Web Design, Website Development, Mobile Apps and SEO services.",
      "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Web Services",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Website Design"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Website Development"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "SEO Services"
            }
          }
        ]
      }
    }
  ]
}
</script>

<style>
    /* Fix for mobile scrolling - Prevent page reload */
    html, body {
        overflow-x: hidden;
        position: relative;
        width: 100%;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
    .row{
        align-items: center;
    }
    
    /* ========== FIXED STICKY HEADER ========== */
    .main-header {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 4px 25px rgba(0, 10, 151, 0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
        width: 100%;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        padding: 8px 0;
    }
    
    /* Header when marquee is closed */
    body.marquee-closed .main-header {
        top: 0;
    }
    
    /* Ensure header stays sticky on all devices */
    @media (max-width: 768px) {
        .main-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #ffffff;
        }
    }
    
    /* Top Marquee Styles */
    
    
    .marquee-content {
        flex: 1;
        overflow: hidden;
        white-space: nowrap;
    }
    
    .marquee-content span {
        display: inline-block;
        animation: marquee 25s linear infinite;
        padding-left: 100%;
    }
    
    /* Pause animation on hover for better performance */
    .top-marquee:hover .marquee-content span {
        animation-play-state: paused;
    }
    
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-100%); }
    }
    
    /* Mobile optimization */
    @media (max-width: 768px) {
        .top-marquee {
            padding: 8px 12px;
            font-size: 11px;
        }
        
        .marquee-content span {
            animation: marquee 20s linear infinite;
        }
    }
    
    .close-marquee {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    
    .close-marquee:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.05);
    }
    
   
    /* Desktop Navigation */
    
    .nav-item {
        position: relative;
    }
    
    .nav-link {
        text-decoration: none;
        color: #1a2c3e;
        font-weight: 600;
        font-size: 15px;
        transition: color 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .nav-link:hover {
        color: #0b1b98;
    }
    
    /* Mega Menu */
    .mega-menu {
        position: absolute;
        top: 100%;
        left: -150px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        padding: 25px;
        min-width: 550px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 100;
    }
    
    .nav-item:hover .mega-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(10px);
    }
    
    .mega-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }
    
    .mega-col h4 {
        font-size: 16px;
        font-weight: 700;
        color: #0b1b98;
        margin-bottom: 15px;
    }
    
    .mega-col a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        color: #4a5568;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }
    
    .mega-col a:hover {
        color: #0b1b98;
    }
    
    .mega-badge {
        background: #f9a826;
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 10px;
        margin-left: 8px;
    }
    
    /* Header Actions */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    
    .menu-icon-mobile {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        color: #0b1b98;
        cursor: pointer;
        padding: 8px;
    }
    
    /* Mobile Drawer */
    .mobile-drawer {
        position: fixed;
        top: 0;
        right: -100%;
        width: 85%;
        max-width: 350px;
        height: 100%;
        background: white;
        z-index: 2000;
        transition: right 0.3s ease;
        box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }
    
    .mobile-drawer.active {
        right: 0;
    }
    
    .drawer-header {
        padding: 20px;
        border-bottom: 1px solid #eef2ff;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .drawer-logo img {
        height: 40px;
    }
    
    .close-drawer {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #4a5568;
        padding: 8px;
    }
    
    .drawer-nav {
        flex: 1;
        padding: 20px;
    }
    
    .drawer-nav-item {
        margin-bottom: 15px;
    }
    
    .drawer-nav-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        color: #1a2c3e;
        font-weight: 600;
        padding: 10px 0;
        cursor: pointer;
    }
    
    .drawer-submenu {
        display: none;
        padding-left: 20px;
        margin-top: 10px;
    }
    
 .drawer-submenu.active {
    display: block;
    max-height: fit-content;
}
    
    .drawer-submenu a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        text-decoration: none;
        color: #4a5568;
        font-size: 14px;
        transition: color 0.3s ease;
    }
    
    .drawer-submenu a:hover {
        color: #0b1b98;
    }
    
    .drawer-footer {
        padding: 20px;
        border-top: 1px solid #eef2ff;
    }
    
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .nav-menu {
            display: none;
        }
        
        .menu-icon-mobile {
            display: block;
        }
        
        .contact-btn span {
            display: none;
        }
        
        .contact-btn {
            padding: 10px;
        }
    }
    
    @media (max-width: 768px) {
        .header-container {
            padding: 12px 20px;
        }
        
        .logo img {
            height: 40px;
        }
        
        .contact-btn {
            padding: 8px 12px;
        }
        
        .contact-btn i {
            margin: 0;
        }
    }
    
    /* Prevent body scroll when drawer is open */
    body.drawer-open {
        overflow: hidden;
    }
</style>

<style>
/* Popup */
.googleformpopup {
  position: fixed;
  top: 70px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 9999;
  display: none;
}

.popup-box {
  width: 420px;
  background: #fff;
  border-radius: 6px;
  box-shadow: 0 5px 25px rgba(0,0,0,0.25);
  overflow: hidden;
  font-family: Arial, sans-serif;
}

/* Top Section */
.popup-top {
  display: flex;
  align-items: center;
  padding: 15px;
  gap: 12px;
  background: #f5f5f5;
}

.popup-icon {
  width: 45px;
  height: 45px;
}

.popup-text h4 {
  margin: 0;
  font-size: 16px;
  font-weight: bold;
}

.popup-text p {
  margin: 4px 0 0;
  font-size: 13px;
  color: #555;
}

/* Bottom Section */
.popup-bottom {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 15px;
}

.powered {
  font-size: 12px;
  color: #777;
}

/* Buttons */
.popup-buttons {
  display: flex;
  gap: 8px;
}

.deny-btn {
  background: #eee;
  border: 1px solid #ccc;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
}

.allow-btn {
  background: linear-gradient(#4da3ff, #2b7cff);
  color: #fff;
  border: none;
  padding: 6px 14px;
  border-radius: 4px;
  cursor: pointer;
}

/* Modal */
.gform {
  display: none;
  position: fixed;
  z-index: 99999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
}

.gform-content {
    position: relative;
    background: #fff;
    margin: 0% auto;
    padding: 10px;
    width: 90%;
    max-width: 700px;
    height: 100%;
    border-radius: 8px;
}

.close-modal {
  position: absolute;
  right: 10px;
  top: 5px;
  font-size: 22px;
  cursor: pointer;
}



/* ========== QUOTE MODAL STYLES ========== */
.quote-modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  backdrop-filter: blur(8px);
  z-index: 9999;
  align-items: center;
  justify-content: center;
  animation: fadeIn 0.3s ease;
}

.quote-modal.active {
  display: flex;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.quote-modal-content {
  background: white;
  border-radius: 24px;
  max-width: 480px;
  width: 90%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  animation: slideUp 0.3s ease;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
}

@keyframes slideUp {
  from {
    transform: translateY(50px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.quote-modal-header {
  color: #000;
  padding: 11px 22px 25px;
  border-radius: 24px 24px 0 0;
  position: relative;
}

.quote-modal-header h2 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 8px;
    align-items: center;
    gap: 12px;
    text-align: center;
}

.quote-modal-header h2 i {
  font-size: 1.6rem;
}
.quote-modal-header p {
    font-size: 0.9em;
    opacity: 0.9;
    margin: 0;
    text-align: center;
}

.quote-modal-close {
  position: absolute;
  top: 20px;
  right: 25px;
  background: rgba(255, 255, 255, 0.2);
  border: none;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  font-size: 24px;
  cursor: pointer;
  color: white;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.quote-modal-close:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: rotate(90deg);
}

.quote-modal-body {
    padding: 0px 24px 23px;
}
.modal-content h3 {
    text-align: center;
    font-size: 1.5em;
    font-weight: 800;
}
.modal-content p {
    text-align: center;
}
.form-group {
  margin-bottom: 10px;
}
.quoteAgree label {
    display: block !important;
}
.form-group label {
  display: none;
  margin-bottom: 8px;
  font-weight: 600;
  color: #1a2c3e;
  font-size: 0.7rem;
}

.form-group label i {
  color: #0b1b98;
  margin-right: 8px;
  width: 18px;
}

.form-group input, .form-group select, .form-group textarea {
    width: 100%;
    padding: 11px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    font-family: inherit;
    background: #f8fafc;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #0b1b98;
  box-shadow: 0 0 0 3px rgba(11, 27, 152, 0.1);
  background: white;
}

.form-group textarea {
  resize: vertical;
  min-height: 100px;
}

.checkbox-group {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 20px 0;
}

.checkbox-group input {
  width: auto;
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.checkbox-group label {
  margin: 0;
  font-size: 0.85rem;
  font-weight: normal;
  cursor: pointer;
}

.checkbox-group label a {
  color: #0b1b98;
  text-decoration: none;
}

.checkbox-group label a:hover {
  text-decoration: underline;
}

.quote-submit-btn {
  width: 100%;
  background: linear-gradient(135deg, #0b1b98, #1a2bb8);
  color: white;
  border: none;
  padding: 14px 24px;
  border-radius: 50px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.quote-submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(11, 27, 152, 0.3);
}

.quote-submit-btn:active {
  transform: translateY(0);
}

.quote-submit-btn.loading {
  opacity: 0.7;
  cursor: not-allowed;
  transform: none;
}

/* Success Message */
.quote-success {
  text-align: center;
  padding: 40px 20px;
}

.quote-success i {
  font-size: 70px;
  color: #10b981;
  margin-bottom: 20px;
}

.quote-success h3 {
  font-size: 1.8rem;
  color: #1a2c3e;
  margin-bottom: 10px;
}

.quote-success p {
  color: #64748b;
  margin-bottom: 25px;
}

.quote-success-close {
  background: #0b1b98;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 40px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.quote-success-close:hover {
  background: #1a2bb8;
  transform: translateY(-2px);
}

/* Scrollbar */
.quote-modal-content::-webkit-scrollbar {
  width: 0px;
}

/* Mobile Responsive */
@media (max-width: 768px) {
  .quote-modal-header {
    padding: 20px 20px 15px;
  }
  
  .quote-modal-header h2 {
    font-size: 1.4rem;
  }
  
  .quote-modal-body {
    padding: 20px;
  }
  
  .form-group input,
  .form-group select,
  .form-group textarea {
    padding: 10px 12px;
    font-size: 0.9rem;
  }
  
  .quote-submit-btn {
    padding: 12px 20px;
    font-size: 0.9rem;
  }
}
</style>

</head>
<body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K494D5P4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- ========== GET FREE QUOTE MODAL ========== -->
<!-- Modified Modal Form for Header -->
<div id="quoteModal" class="quote-modal">
  <div class="quote-modal-content">
    <div class="quote-modal-header">
      <h2>Get Free Quote</h2>
      <p>Fill out the form below and our team will get back to you within 24 hours</p>
      <button class="quote-modal-close" id="closeQuoteModal">&times;</button>
    </div>
    <div class="quote-modal-body">
      <form id="quoteFormModal" method="POST" action="send_quote.php" class="modal-form">
        <div class="form-group">
          <label for="quoteNameModal"><i class="fas fa-user"></i> Full Name *</label>
          <input type="text" id="quoteNameModal" name="name" required placeholder="Enter your full name">
        </div>
        
        <div class="form-group">
          <label for="quoteEmailModal"><i class="fas fa-envelope"></i> Email Address *</label>
          <input type="email" id="quoteEmailModal" name="email" required placeholder="Enter your email address">
        </div>
        
        <div class="form-group">
          <label for="quotePhoneModal"><i class="fas fa-phone"></i> Phone Number *</label>
          <input type="tel" id="quotePhoneModal" name="phone" required placeholder="Enter your phone number" pattern="[6-9]{1}[0-9]{9}" maxlength="10" inputmode="numeric">
        </div>
        
        <div class="form-group">
          <label for="quoteSubjectModal"><i class="fas fa-tag"></i> Select a service *</label>
          <select id="quoteSubjectModal" name="subject" required>
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
          <label for="quoteMessageModal"><i class="fas fa-comment"></i> Message *</label>
          <textarea id="quoteMessageModal" name="message" rows="5" required placeholder="Tell us about your project requirements..."></textarea>
        </div>
        
        <input type="text" name="website" style="display:none">
        <input type="hidden" name="form_type" value="modal_form">
        
        <div class="form-group checkbox-group quoteAgree">
          <input type="checkbox" id="quoteAgreeModal" name="agree" required>
          <label for="quoteAgreeModal">I agree to the <a href="#" target="_blank">Terms & Conditions</a> and <a href="#" target="_blank">Privacy Policy</a></label>
        </div>
        
        <!-- Google reCAPTCHA -->
        <div class="g-recaptcha-modal" data-sitekey="6LdU-6osAAAAAJQRqJscGrDsYiCa4w29DFb75sqh"></div>
        
        <button type="submit" class="quote-submit-btn" id="submitQuoteModal">
          <i class="fas fa-paper-plane"></i> Send Quote Request
        </button>
      </form>
      
      <div id="quoteSuccessMessageModal" class="quote-success" style="display: none;">
        <i class="fas fa-check-circle"></i>
        <h3>Thank You!</h3>
        <p>Your quote request has been sent successfully. Our team will contact you within 24 hours.</p>
        <button class="quote-success-close-modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
// ========== GLOBAL RECAPTCHA HANDLER ==========
let recaptchaWidgets = {
    modal: null,
    consult: null,
    contact: null
};

// Make init globally accessible (IMPORTANT)
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



// ========== MODAL FORM SCRIPT ==========
(function () {
    'use strict';

    const phoneInputModal = document.getElementById("quotePhoneModal");
    if (phoneInputModal) {
        phoneInputModal.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });
    }

    const formModal = document.getElementById("quoteFormModal");

    if (formModal) {
        formModal.addEventListener("submit", async function (e) {
            e.preventDefault();

            if (typeof grecaptcha === 'undefined') {
                alert("Captcha not loaded. Please refresh page.");
                return;
            }

            let captchaResponse = grecaptcha.getResponse(recaptchaWidgets.modal);

            if (!captchaResponse) {
                alert("Please complete the reCAPTCHA verification");
                return;
            }

            let formData = new FormData(this);
            formData.append("g-recaptcha-response", captchaResponse);

            let submitBtn = document.getElementById("submitQuoteModal");
            let originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;

            try {
                let response = await fetch("send_quote.php", {
                    method: "POST",
                    body: formData
                });

                let data = await response.json();

                if (data.success) {
                    document.getElementById("quoteFormModal").style.display = "none";
                    document.getElementById("quoteSuccessMessageModal").style.display = "block";

                    grecaptcha.reset(recaptchaWidgets.modal);
                } else {
                    alert(data.message || "Something went wrong.");
                    grecaptcha.reset(recaptchaWidgets.modal);
                }

            } catch (error) {
                console.error(error);
                alert("Server error. Please try again later.");
                grecaptcha.reset(recaptchaWidgets.modal);
            }

            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }



    // CLOSE SUCCESS MESSAGE
    const closeSuccessModal = document.querySelector(".quote-success-close-modal");

    if (closeSuccessModal) {
        closeSuccessModal.addEventListener("click", function () {
            document.getElementById("quoteSuccessMessageModal").style.display = "none";
            document.getElementById("quoteFormModal").style.display = "block";
            document.getElementById("quoteFormModal").reset();

            if (recaptchaWidgets.modal !== null) {
                grecaptcha.reset(recaptchaWidgets.modal);
            }
        });
    }



    // CLOSE MODAL
    const closeModal = document.getElementById("closeQuoteModal");
    const modal = document.getElementById("quoteModal");

    if (closeModal && modal) {
        closeModal.addEventListener("click", function () {
            modal.classList.remove("active");
            document.body.style.overflow = "";
        });
    }

    if (modal) {
        modal.addEventListener("click", function (e) {
            if (e.target === modal) {
                modal.classList.remove("active");
                document.body.style.overflow = "";
            }
        });
    }

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal && modal.classList.contains("active")) {
            modal.classList.remove("active");
            document.body.style.overflow = "";
        }
    });

})();
</script>
<!-- TOP MARQUEE -->
<div id="topMarquee2" class="top-marquee">
  <div class="marquee-content">
    <span>
      <i class="fas fa-trophy"></i> 🏆 100+ Websites Designed & Delivered Worldwide 
      <i class="fas fa-code"></i> 95 Happy Clients 
      <i class="fas fa-chart-line"></i> 99% Client Satisfaction 
      <i class="fas fa-crown"></i> 100+ Design Milestone — Industry Leaders 
      <i class="fas fa-bolt"></i> Free SEO Audit + Performance Boost 
      <i class="fas fa-globe"></i> Trusted by Global Brands
    </span>
  </div>
  <!--<button id="closeMarqueeBtn" class="close-marquee" aria-label="announcement">-->
  <!--  <i class="fas fa-times"></i>-->
  <!--</button>-->
</div>
 <!-- CTA Buttons - Centered -->
      <div class="banner-buttons">
  <button class="btn-primary-banner open-quote-modal">
    <i class="fas fa-calendar-check"></i> Start Your Project
  </button>

  <button class="btn-secondary-banner open-quote-modal">
    <i class="fas fa-comment-dots"></i> Talk to Experts
  </button>
</div>
  
<!-- MAIN HEADER -->
<header class="main-header" id="mainHeader">
  <div class="header-container">
    <div class="logo-area">
      <div class="logo">
        <a href="https://devnexusit.com/">
          <img src="/images/logodev.webp" alt="DevNexusIT Logo">
        </a>
      </div>
    </div>

    <!-- Desktop Navigation -->
    <ul class="nav-menu">
      <li class="nav-item"><a href="https://devnexusit.com/" class="nav-link">Home</a></li>
      <li class="nav-item">
        <a class="nav-link">Services <i class="fas fa-chevron-down"></i></a>
        <div class="mega-menu">
          <div class="mega-grid">
            <div class="mega-col">
              <h4>Development & Design</h4>
              <a href="/website-design-company-in-delhi"><i class="fas fa-laptop-code"></i> Website Design & Development <span class="mega-badge">Popular</span></a>
              <a href="/software-development"><i class="fas fa-cogs"></i> Software Development</a>
              <a href="/website-redesign"><i class="fas fa-paint-brush"></i> Website Redesign</a>
              <a href="/custom-website-solution"><i class="fas fa-code-branch"></i> Custom Website Solutions</a>
              <a href="#"><i class="fas fa-database"></i> Dynamic Web Applications</a>
            </div>
            <div class="mega-col">
              <h4>Growth & Support</h4>
              <a href="#"><i class="fas fa-chart-simple"></i> SEO & Digital Marketing</a>
              <a href="#"><i class="fas fa-headset"></i> AMC (Annual Maintenance)</a>
              <a href="https://devnexusit.com/e-commerce-website-design"><i class="fas fa-cart-shopping"></i> E‑commerce Solutions</a>
              <a href="#"><i class="fas fa-cloud-upload-alt"></i> Cloud Hosting & DevOps</a>
              <a href="#"><i class="fas fa-mobile-alt"></i> Mobile App Development</a>
            </div>
          </div>
          <div style="margin-top: 20px; padding-top: 12px; border-top: 1px solid #eef2ff; display: flex; justify-content: space-between;">
            <span style="font-size: 12px; color:#5b6e9c;"><i class="fas fa-headset"></i> 24/7 Expert Support</span>
            <span style="font-size: 12px; color:#0b1b98;"><i class="fas fa-gem"></i> 10K+ Projects Delivered</span>
          </div>
        </div>
      </li>
      <li class="nav-item"><a href="/about-us" class="nav-link">About Us</a></li>
      <li class="nav-item"><a href="#" class="nav-link">Projects </a></li>
      <li class="nav-item"><a href="https://devnexusit.com/blog/" target="_blank" class="nav-link">Blog</a></li>
      <li class="nav-item"><a href="#" class="nav-link">Customers</a></li>
      <li class="nav-item"><a href="/contact" class="nav-link">Contact us</a></li>
    </ul>

    <div class="header-actions">
<button class="contact-btn open-quote-modal">
  <i class="fas fa-calendar-check"></i>
  <span> Get Free Quote</span>
</button>      <button id="mobileMenuBtn" class="menu-icon-mobile"><i class="fas fa-bars"></i></button>
    </div>
    
  </div>
</header>

<!-- Mobile Drawer -->
<div id="mobileDrawer" class="mobile-drawer">
  <div class="drawer-header">
    <div class="drawer-logo"><img src="images/favdev.webp" alt="DevNexusIT"></div>
    <button id="closeDrawerBtn" class="close-drawer"><i class="fas fa-times"></i></button>
  </div>
  <div class="drawer-nav">
    <div class="drawer-nav-item"><a href="#" class="drawer-nav-link">Home</a></div>
    <div class="drawer-nav-item">
      <div class="drawer-nav-link toggle-submenu">
        Services <i class="fas fa-chevron-down"></i>
      </div>
      <div class="drawer-submenu" id="mobileServicesSub">
        <a href="/website-design-company-in-delhi"><i class="fas fa-laptop-code"></i> Website Design & Development</a>
        <a href="/software-development"><i class="fas fa-cogs"></i> Software Development</a>
        <a href="/website-redesign"><i class="fas fa-paint-brush"></i> Website Redesign</a>
        <a href="/custom-website-solution"><i class="fas fa-code-branch"></i> Custom Website</a>
        <a href="#"><i class="fas fa-chart-line"></i> SEO & Digital Marketing</a>
        <a href="#"><i class="fas fa-database"></i> Dynamic Website</a>
        <a href="#"><i class="fas fa-headset"></i> AMC Services</a>
        <a href="#"><i class="fas fa-mobile-alt"></i> Mobile Apps</a>
      </div>
    </div>
    <div class="drawer-nav-item"><a href="/about-us" class="drawer-nav-link">About Us</a></div>
    <div class="drawer-nav-item"><a href="#" class="drawer-nav-link">Projects</a></div>
    <div class="drawer-nav-item"><a href="https://devnexusit.com/blog/" class="drawer-nav-link">Blog</a></div>
    <div class="drawer-nav-item"><a href="#" class="drawer-nav-link">Customers</a></div>
    <div class="drawer-nav-item"><a href="/contact" class="drawer-nav-link">Contact us</a></div>
  </div>
  <div class="drawer-footer">
    <button class="contact-btn" style="width:100%; background:#0b1b98;"><i class="fas fa-paper-plane"></i> Start a Project</button>
    <p style="font-size: 12px; margin-top: 18px; text-align:center; color:#5e6f8d;">✨ 10,000+ websites delivered worldwide</p>
  </div>
</div>
<div id="drawerOverlay" class="overlay"></div>
<script>
document.addEventListener("DOMContentLoaded", function () {

  const modal = document.getElementById("quoteModal");
  const openBtns = document.querySelectorAll(".open-quote-modal");
  const closeBtn = document.getElementById("closeQuoteModal");

  // OPEN MODAL
  openBtns.forEach(btn => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      modal.classList.add("active");
      document.body.style.overflow = "hidden";
    });
  });

  // CLOSE MODAL (X)
  if (closeBtn) {
    closeBtn.addEventListener("click", closeModal);
  }

  // CLOSE OUTSIDE
  modal.addEventListener("click", function (e) {
    if (e.target === modal) {
      closeModal();
    }
  });

  // ESC KEY
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      closeModal();
    }
  });

  function closeModal() {
    modal.classList.remove("active");
    document.body.style.overflow = "";
  }

});
</script>
<script>
(function() {
    'use strict';
    
    // ========== FIX MARQUEE CLOSE BUTTON ==========
    const closeMarqueeBtn = document.getElementById('closeMarqueeBtn');
    const topMarquee = document.getElementById('topMarquee');
    
    if (closeMarqueeBtn && topMarquee) {
        // Check if marquee was closed before
        const isMarqueeClosed = localStorage.getItem('marqueeClosed');
        if (isMarqueeClosed === 'true') {
            topMarquee.style.display = 'none';
            document.body.classList.add('marquee-closed');
        }
        
        closeMarqueeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            topMarquee.style.display = 'none';
            document.body.classList.add('marquee-closed');
            localStorage.setItem('marqueeClosed', 'true');
        });
    }
    
    // ========== FIX MOBILE MENU/DRAWER ==========
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const drawerOverlay = document.getElementById('drawerOverlay');
    const closeDrawerBtn = document.getElementById('closeDrawerBtn');
    
    if (mobileMenuBtn && mobileDrawer && drawerOverlay) {
        function openDrawer() {
            mobileDrawer.classList.add('active');
            drawerOverlay.classList.add('active');
            document.body.classList.add('drawer-open');
            document.body.style.overflow = 'hidden';
        }
        
        function closeDrawer() {
            mobileDrawer.classList.remove('active');
            drawerOverlay.classList.remove('active');
            document.body.classList.remove('drawer-open');
            document.body.style.overflow = '';
        }
        
        // Open drawer
        mobileMenuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openDrawer();
        });
        
        // Close drawer with button
        if (closeDrawerBtn) {
            closeDrawerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeDrawer();
            });
        }
        
        // Close drawer by clicking overlay
        drawerOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            closeDrawer();
        });
        
        // Close drawer on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileDrawer.classList.contains('active')) {
                closeDrawer();
            }
        });
        
        // Prevent drawer from closing when clicking inside drawer
        mobileDrawer.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // ========== MOBILE SUBMENU TOGGLE (FIXED) ==========
    const toggleSubmenu = document.querySelector('.toggle-submenu');
    const mobileServicesSub = document.getElementById('mobileServicesSub');
    
    if (toggleSubmenu && mobileServicesSub) {
        // Remove any existing event listeners by cloning and replacing
        const newToggle = toggleSubmenu.cloneNode(true);
        toggleSubmenu.parentNode.replaceChild(newToggle, toggleSubmenu);
        
        // Get the new element and submenu
        const freshToggle = document.querySelector('.toggle-submenu');
        const freshSubmenu = document.getElementById('mobileServicesSub');
        
        if (freshToggle && freshSubmenu) {
            freshToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Toggle the active class on submenu
                freshSubmenu.classList.toggle('active');
                
                // Rotate the chevron icon
                const icon = this.querySelector('i');
                if (icon) {
                    if (freshSubmenu.classList.contains('active')) {
                        icon.style.transform = 'rotate(180deg)';
                        icon.style.transition = 'transform 0.3s ease';
                    } else {
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }
    }
    
    // ========== STICKY HEADER ON SCROLL ==========
    let header = document.querySelector('.main-header');
    let headerHeight = header ? header.offsetHeight : 80;
    
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 50) {
            if (header) header.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.1)';
        } else {
            if (header) header.style.boxShadow = '0 4px 25px rgba(0, 10, 151, 0.08)';
        }
    }, { passive: true });
    
    // ========== PREVENT PAGE RELOAD ON MOBILE SCROLL ==========
    let touchStartY = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartY = e.touches[0].clientY;
    }, { passive: true });
    
    document.addEventListener('touchmove', function(e) {
        // Prevent pull-to-refresh when at top of page
        if (window.scrollY === 0 && e.touches[0].clientY > touchStartY + 10) {
            e.preventDefault();
        }
    }, { passive: false });
    
    // ========== FIX FOR MOBILE MENU ITEMS CLOSE DRAWER ==========
    const drawerNavLinks = document.querySelectorAll('.drawer-nav-link');
    drawerNavLinks.forEach(link => {
        // Only add click handler for non-submenu links
        if (!link.classList.contains('toggle-submenu')) {
            link.addEventListener('click', function(e) {
                // Close drawer when clicking on navigation links
                const drawer = document.getElementById('mobileDrawer');
                const overlay = document.getElementById('drawerOverlay');
                if (drawer && drawer.classList.contains('active')) {
                    setTimeout(() => {
                        drawer.classList.remove('active');
                        overlay.classList.remove('active');
                        document.body.classList.remove('drawer-open');
                        document.body.style.overflow = '';
                    }, 100);
                }
            });
        }
    });
    
    // ========== ENSURE MARQUEE SHOWS ON LOAD ==========
    // Make sure top marquee is visible on page load
    const marqueeDisplay = localStorage.getItem('marqueeClosed');
    if (marqueeDisplay !== 'true') {
        const marquee = document.getElementById('topMarquee');
        if (marquee) {
            marquee.style.display = 'flex';
        }
    }
    
    // ========== FIX FOR ANY IFRAMES ==========
    const allIframes = document.querySelectorAll('iframe');
    allIframes.forEach(iframe => {
        iframe.setAttribute('loading', 'lazy');
    });
    
})();
</script>

<!-- Main Content Area - Your existing page content will go here -->
<!-- This is where your banner, about section, services, etc. will be placed -->
