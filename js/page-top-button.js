// Get button element class
const pagetop_btn = document.querySelector(".page-top-button");;

// Click button to scroll to top
pagetop_btn.addEventListener("click", scroll_top);

// Scroll to top smoothly
function scroll_top() {
  window.scroll({ top: 0, behavior: "smooth" });
}

// Show button on scroll
window.addEventListener("scroll", scroll_event);
function scroll_event() {
  if (window.pageYOffset > 100) {
    pagetop_btn.style.opacity = "1";
  } else if (window.pageYOffset < 100) {
    pagetop_btn.style.opacity = "0";
  }
}
