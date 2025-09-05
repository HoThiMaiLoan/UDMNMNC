(function(){
  document.addEventListener('DOMContentLoaded', function(){
    // simple slider: rotate slides with class "active"
    var slider = document.querySelector('.unmnmnc-slider');
    if(!slider) return;
    var slides = slider.querySelectorAll('.slide');
    var idx = 0;
    slides[idx].classList.add('active');
    setInterval(function(){
      slides[idx].classList.remove('active');
      idx = (idx + 1) % slides.length;
      slides[idx].classList.add('active');
    }, 4000);
  });
})();