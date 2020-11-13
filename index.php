<?php defined('_JEXEC') or die('Restricted access');?>
<!DOCTYPE html>
<html xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>One Great Work Network</title>
<jdoc:include type="head" />
<script type="text/javascript" src="templates/ogwn-scratch/js/scripts.js">

</script>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>
/templates/<?php echo $this->template ?>/style.css" type="text/css" />
</head>
<body>
  <div class="page-wrap">
    <header>
      <div class="header-flex container">

<a href="<?php echo $this->baseurl ?>" class="custom-logo-link" rel="home" aria-current="page">
  <img src="templates/ogwn-scratch/img/seal.png" class="custom-logo" alt="One Great Work Network" width="111" height="111">
</a>
        <a href="<?php echo $this->baseurl; ?>" class="title-img"></a>

        <form action="/" method="get" id="searchform" class="header-searchform">
          <input type="checkbox" name="search-cb" id="search-cb" onclick="noScrollOnMenuOpen(this)" />
          <label id="search-cb-label" for="search-cb">
            <div class="search-open"></div>
          </label>

          <div class="search-bg-mb" id="search-bg-mb">
            <input type="text" name="s" id="search" placeholder="Search" size="17" value="" />

            <button type="submit" id="search-button">
              <?php include("img/icons/search.svg"); ?>
            </button>
          </div>
        </form>

        <label for="search-cb" class="fade" id="fadesearch"></label>

        <nav id="hamnav">
          <!-- [THE HAMBURGER] -->
          <input type="checkbox" id="hammy" name="hammy" onclick="noScrollOnMenuOpen(this)" />
          <label for="hammy">&#9776;</label>

          <!-- [MENU ITEMS] -->
          <div id="hamitems">
            <jdoc:include type="modules" name="headermenu" />
          </div>
        </nav>
        <label for="hammy" class="fade" id="fademenu"></label>
      </div>
    </header>
<!--
PROPERLY IMPLEMENT HEADER AND FOOTER MODULES AND COMPONENT
 <jdoc:include type="modules" name="top" />
<jdoc:include type="component" />
<jdoc:include type="modules" name="footer" /> -->
<main  role=”main”>

  <section class="section section-gray" id="livefeed-featured-section">
    <div id="livefeed-featured" class="container">
      <!-- Twitch player -->
      <div class="live-player-container">
      <!-- Gets and trims website url for twitch iframe &parent -->

      <div class="iframe-container">
        <iframe class="iframe" src="https://player.twitch.tv/?channel=onegreatworknetwork&parent=&parent=" frameborder="0" allowfullscreen="true" scrolling="no" width="100%" height="300px"></iframe>
      </div>
      <div class="live-title">
      </div>
  </div>
    <!-- Featured Content -->
  <div class="feed-container container" id="featured-container">

    	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
    	</div><!-- #primary-sidebar -->

</div>  <!-- feed-container -->


</div>  <!-- livefeed-featured container -->
</section>  <!-- livefeed-featured section -->

    <!-- Content Creators -->
<section class="section" id="content-creators-section">
  <div class="container">

    <div class="section-header">
      <h5>CONTENT CREATORS</h5>
    </div>

<div class="author-list">


</div>  <!-- end author list -->

</div> <!-- end container -->
</section> <!-- end section -->

</main>

<footer class="site-footer">
  <div class="container">
    <div class="menu-footer-menu-container">


                <jdoc:include type="modules" name="footermenu" />
    </div>

    <a href="#" class="footer-logo"></a>


  </div>
</footer>

</div>
</body>
</html>
