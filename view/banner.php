<div style="margin-left: 100px; margin-right:100px;">
  <div class="carousel">
    <div class="slides">
      <img src="./assets//images//slider//slider-1.png" alt="Hình 1" />
      <img src="./assets//images//slider//slider-2.png" alt="Hình 2" />
      <img src="./assets//images//slider//slider-3.png" alt="Hình 3" />
    </div>
    <button class=" prev" onclick="changeSlide(1)">❮</button>
    <button class="next" onclick="changeSlide(-1)">❯</button>
  </div>
</div>

<script>
let slideIndex = 0;
const slides = document.querySelector(".slides");
const slideImages = document.querySelectorAll(".slides img");
const totalSlides = slideImages.length;
const slideWidth = slideImages[0].clientWidth;
let autoSlideInterval; // Biến lưu trữ interval cho auto slide

function changeSlide(n) {
  slideIndex = (slideIndex + n + totalSlides) % totalSlides;
  const displacement = -slideWidth * slideIndex;
  slides.style.transform = `translateX(${displacement}px)`;
}

function startAutoSlide() {
  autoSlideInterval = setInterval(() => {
    changeSlide(1); // Chuyển slide tự động về phía bên phải (slide tiếp theo)
  }, 7000); // Thời gian giữa các slide là 3000ms (3 giây)
}

function stopAutoSlide() {
  clearInterval(autoSlideInterval); // Dừng auto slide khi người dùng tương tác
}

// Gọi hàm startAutoSlide để bắt đầu chuyển slide tự động
startAutoSlide();

// Hiển thị slide đầu tiên ban đầu
changeSlide(0);

// Dừng auto slide khi người dùng tương tác với các button prev/next
document.querySelector(".prev").addEventListener("click", () => {
  changeSlide(1);
  stopAutoSlide();
});

document.querySelector(".next").addEventListener("click", () => {
  changeSlide(-1);
  stopAutoSlide();
});
</script>