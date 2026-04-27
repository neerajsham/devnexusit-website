
<style>
  .customer-logos {
  padding: 40px 0;
  text-align: center;
  background: #fff;
}

.customer-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  align-items: center;
}

.customer-item {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  border: 1px solid #eee;
  transition: 0.3s ease;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.customer-item img {
  max-width: 100%;
  height: 90px;
  object-fit: contain;
  /*filter: grayscale(100%);*/
  transition: 0.3s ease;
}

.customer-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.customer-item:hover img {
  filter: grayscale(0%);
}

/* Responsive */
@media (max-width: 992px) {
  .customer-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 500px) {
    .customer-item {
    padding: 8px;
}
  .customer-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
</style>
<section class="customer-logos">
  <div class="container">
<h2 class="section-title">Our happy clients and partners</h2>
<p>Our happy clients and partners – businesses who trust our services and grow with us</p>
    <div class="customer-grid">
      
      <div class="customer-item">
        <img src="https://devnexusit.com/images/mokshitandtomar-logo.jpeg" alt="mokshit and tomar client logo">
      </div>

      <div class="customer-item">
        <img src="https://devnexusit.com/images/rrindustries-logo.png" alt="rr industries client logo">
      </div>

      <div class="customer-item">
        <img src="https://devnexusit.com/images/thakursahab-logo.webp" alt="thakur sahab client logo">
      </div>

      <div class="customer-item">
        <img src="https://devnexusit.com/images/babasahib-logo.png" alt="baba sahib client logo">
      </div>

    </div>

  </div>
</section>