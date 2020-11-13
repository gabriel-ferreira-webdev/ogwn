// AUTHOR PROFILE DESCRIPTION SEE MORE...

var theme_uri = mainTheme.templateUrl;

function readMoreToggle() {
  const less = 'author-page-header-desc';
  const more = 'author-page-header-desc-open';
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

  if (!isOverflow) {
    const elToHide = document.getElementById('button-more');
    elToHide.style.display = 'none';
  }
};

// Mobile menu
function noScrollOnMenuOpen(checkbox) {
  if (checkbox.checked) document.body.classList.add('no-scroll-menu-open' + '-' +  checkbox.id);
  else document.body.classList.remove('no-scroll-menu-open' + '-' + checkbox.id);
}

// Now Playing

(function($){
  $(document).ready( function(){
      //setInterval(updateTitle, 1000);
      updateTitle();
  });

  function updateTitle(){
    $.ajax({
      url: theme_uri + "/nowplaying.php",
      type: 'GET',
      data: {
          'fetch': 1,
      },
      success: function(result){
          if(result){
              $(".live-title").html('<a>'+ result +'</a>')
          } else {
              console.log("failed to retrieve text");
          }
      }
    })
  }

})(jQuery);