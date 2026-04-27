<?php
$pageTitle = "HTML Sitemap | DevNexus IT";
$pageDescription = "Explore all main pages of DevNexus IT including website design, development, and digital services.";
?>
<?php include 'header.php'; ?>
    <style>
.sitemap-section {
  padding: 50px 10%;
  background: #fff;
}

.sitemap-container {
  margin: auto;
  padding: 35px;
  border-radius: 10px;
}

/* Heading */
.sitemap-container h1 {
  font-size: 26px;
  margin-bottom: 8px;
}

.sitemap-container p {
  color: #666;
  margin-bottom: 20px;
}

/* Grid */
.sitemap-list {
  list-style: none;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
}

/* Links */
.sitemap-list li a {
  display: block;
  padding: 4px 12px;
  background: #f7f9fc;
  border-radius: 6px;
  text-decoration: none;
  color: #000;
  transition: 0.3s;
  font-weight: 600;
}

/* Hover */
.sitemap-list li a:hover {
  background: #007bff;
  color: #fff;
}

/* Note */
.sitemap-note {
  margin-top: 20px;
  padding: 12px;
  background: #eef5ff;
  border-left: 4px solid #007bff;
  border-radius: 6px;
  font-size: 14px;
}

/* Responsive */
@media(max-width: 600px) {
  .sitemap-list {
    grid-template-columns: 1fr;
  }
}
    </style>
    <section class="sitemap-section">

  <div class="sitemap-container">

    <h1>Website Sitemap</h1>
    <p>Explore all main pages of our website</p>

    <ul class="sitemap-list">
      <li><a href="https://devnexusit.com/"> Home</a></li>
      <li><a href="https://devnexusit.com/about-us"> About Us</a></li>
      <li><a href="https://devnexusit.com/contact"> Contact</a></li>
      <li><a href="https://devnexusit.com/website-design-company-in-delhi">Website Design Company in delhi</a></li>
            <li><a href="https://devnexusit.com/website-design-company-in-faridabad">Website Design Company in Faridabad</a></li>
      <li><a href="https://devnexusit.com/software-development">Software Development</a></li>
      <li><a href="https://devnexusit.com/website-redesign">Website Redesign</a></li>
      <li><a href="https://devnexusit.com/custom-website-solution">Custom Website Solution</a></li>
      <li><a href="https://devnexusit.com/website-design">Website Design</a></li>
      <li><a href="https://devnexusit.com/e-commerce-website-design">E-Commerce Website</a></li>
    <li><a href="https://devnexusit.com/website-design-pricing-in-delhi">Website Design Cost In Delhi</a></li>
    </ul>

  </div>

</section>
<?php include 'footer.php'; ?>
