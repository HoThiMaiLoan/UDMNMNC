document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.querySelector(".menu-toggle");
  const mobileMenu = document.querySelector(".mobile-menu");
  const menuClose = document.querySelector(".menu-close");
  const overlay = document.querySelector(".mobile-menu-overlay");

  if (menuToggle && mobileMenu && menuClose && overlay) {
    menuToggle.addEventListener("click", () => {
      mobileMenu.classList.add("active");
      overlay.classList.add("active");
    });

    menuClose.addEventListener("click", () => {
      mobileMenu.classList.remove("active");
      overlay.classList.remove("active");
    });

    overlay.addEventListener("click", () => {
      mobileMenu.classList.remove("active");
      overlay.classList.remove("active");
    });
  }
});
document.addEventListener("DOMContentLoaded", function() {
  const wrapper = document.querySelector(".slider-wrapper");
  const slides = document.querySelectorAll(".hero-slider .slide");
  const prevBtn = document.querySelector(".hero-slider .prev");
  const nextBtn = document.querySelector(".hero-slider .next");
  const dotsContainer = document.querySelector(".hero-slider .dots");

  let index = 0;

  if (slides.length > 0) {
    slides.forEach((_, i) => {
      const dot = document.createElement("span");
      dot.classList.add("dot");
      if (i === 0) dot.classList.add("active");
      dot.addEventListener("click", () => showSlide(i));
      dotsContainer.appendChild(dot);
    });
  }

  function showSlide(i) {
    if (i < 0) i = slides.length - 1;
    if (i >= slides.length) i = 0;
    wrapper.style.transform = `translateX(-${i * 100}%)`;
    dotsContainer.querySelectorAll(".dot").forEach((d, idx) => {
      d.classList.toggle("active", idx === i);
    });
    index = i;
  }

  prevBtn.addEventListener("click", () => showSlide(index - 1));
  nextBtn.addEventListener("click", () => showSlide(index + 1));

  showSlide(index);
});
jQuery(document).ready(function($){
  // init blog slider (nếu có .udmnmnc-blog-slider trên trang)
  if ($('.udmnmnc-blog-slider').length) {
    $('.udmnmnc-blog-slider').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2200,
      arrows: false,
      dots: true,
      responsive: [
        { breakpoint: 1024, settings: { slidesToShow: 3 } },
        { breakpoint: 768,  settings: { slidesToShow: 2 } },
        { breakpoint: 480,  settings: { slidesToShow: 1 } }
      ]
    });
  }

  // small ux: pause on focus/hover is default; ensure images lazy loaded
  // you can add more custom JS here if needed
});
