document.addEventListener('DOMContentLoaded', function() {
  console.log("Script loaded!"); // Debugging line

  // Sample product data
  const products = [
    {
      img: "https://via.placeholder.com/300x300?text=Graphic+Tee",
      title: "Graphic Print T-Shirt",
      price: "Ksh 700"
    },
    // ... (keep your other products)
  ];

  const sliderTrack = document.getElementById('sliderTrack');
  const prevBtn = document.querySelector('.prev-btn');
  const nextBtn = document.querySelector('.next-btn');

  if (!sliderTrack || !prevBtn || !nextBtn) {
    console.error("Missing required elements!");
    return;
  }

  let currentPosition = 0;
  const slideWidth = 270; // Adjust if needed
  let autoSlideInterval;

  function createSlides() {
    products.forEach(product => {
      const slide = document.createElement('div');
      slide.className = 'slider-slide';
      slide.innerHTML = `
        <img src="${product.img}" alt="${product.title}">
        <h3>${product.title}</h3>
        <p>${product.price}</p>
        <a href="cart.html" class="cart-btn">Add to Cart</a>
      `;
      sliderTrack.appendChild(slide);
    });
  }

  function moveToSlide(position) {
    sliderTrack.style.transform = `translateX(-${position}px)`;
  }

  function initSlider() {
    createSlides();
    
    prevBtn.addEventListener('click', () => {
      resetAutoSlide();
      currentPosition = Math.max(currentPosition - slideWidth * 3, 0);
      moveToSlide(currentPosition);
    });

    nextBtn.addEventListener('click', () => {
      resetAutoSlide();
      const maxPosition = slideWidth * (products.length - 3);
      currentPosition = Math.min(currentPosition + slideWidth * 3, maxPosition);
      moveToSlide(currentPosition);
    });

    startAutoSlide();
  }

  function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
      const maxPosition = slideWidth * (products.length - 3);
      if (currentPosition >= maxPosition) {
        currentPosition = 0;
      } else {
        currentPosition += slideWidth * 3;
      }
      moveToSlide(currentPosition);
    }, 5000);
  }

  function resetAutoSlide() {
    clearInterval(autoSlideInterval);
    startAutoSlide();
  }

  initSlider();
});