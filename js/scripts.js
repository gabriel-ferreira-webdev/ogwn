function readMoreToggle() {
  const less = 'bio';
  const more = 'bio-full';
  const elText = document.getElementById('more-less');
  const elLink= document.getElementById('button-more');

  if (elText.className === less){
    elText.className = more;
    elLink.innerHTML = 'Read less';
  } else {
    elText.className = less;
    elLink.innerHTML = 'Read more';
  }
}

function initAuthor() {
  const el = document.getElementById('more-less');
  const isOverflow = el.scrollHeight > el.clientHeight;

  if (isOverflow) {
    const elToHide = document.getElementById('button-more');
    elToHide.style.display = 'block';
  }
};

// Mobile menu
function noScrollOnMenuOpen(checkbox) {
  if (checkbox.checked) document.body.classList.add('no-scroll-menu-open' + '-' +  checkbox.id);
  else document.body.classList.remove('no-scroll-menu-open' + '-' + checkbox.id);
}
