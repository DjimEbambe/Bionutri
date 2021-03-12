
// ========= Preloader
window.onload = function () {
  window.setTimeout(fadeout, 500);
}

function fadeout() {
  document.querySelector('.preloader').style.opacity = '0';
  document.querySelector('.preloader').style.display = 'none';
}

// ====== main-menu-dark 1 activation 
let openBtnDark1 = document.querySelector('.menu-dark-1 .open-btn');
let closeBtnDark1 = document.querySelector('.menu-dark-1 .close-btn');
let mainMenuWrapperDark1 = document.querySelector('.menu-dark-1 .main-menu-wrapper');
let mainMenuOverlayDark1 = document.querySelector('.menu-dark-1 .main-menu-overlay');

openBtnDark1.addEventListener('click', () => {
  mainMenuWrapperDark1.classList.add('open');
  mainMenuOverlayDark1.classList.add('open');
})
closeBtnDark1.addEventListener('click', () => {
  mainMenuWrapperDark1.classList.remove('open');
  mainMenuOverlayDark1.classList.remove('open');
})
mainMenuOverlayDark1.addEventListener('click', () => {
  mainMenuWrapperDark1.classList.remove('open');
  mainMenuOverlayDark1.classList.remove('open');
})



//======== tiny slider for header-items-active-dark-1
tns({
  autoplay: true,
  autoplayButtonOutput: false,
  mouseDrag: true,
  gutter: 0,
  container: ".header-items-active-dark-1",
  center: true,
  nav: true,
  controls: false,
  speed: 400,
  controlsText: [
      '<i class="lni lni-arrow-left-circle"></i>',
      '<i class="lni lni-arrow-right-circle"></i>',
  ],
  responsive: {
      0: {
          items: 1,
      },
  }
});