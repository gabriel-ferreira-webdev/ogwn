
<?php defined('_JEXEC') or die('Restricted access');?>

<!DOCTYPE html>
<html xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>One Great Work Network</title>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>
/templates/<?php echo $this->template ?>/css/stylev101.css" type="text/css" />
<meta property="og:image" content="img/ogwn-splash.jpg" />
<meta property="og:title" content="One Great Work Network" />
<meta property="og:description" content="Ending Slavery, One Mind At A Time." />
</head>
<body>
  <div class="page-wrap">
    <header>
      <div class="header-flex container">

<a href="<?php echo $this->baseurl ?>" class="custom-logo-link" rel="home" aria-current="page">
  <img src="templates/<?php echo $this->template ?>/img/seal.png" class="custom-logo" alt="One Great Work Network" width="111" height="111">
</a>
        <a href="<?php echo $this->baseurl; ?>" class="title-img"></a>

        <div id="searchform" class="header-searchform">
          <input type="checkbox" name="search-cb" id="search-cb" onclick="noScrollOnMenuOpen(this)" />
          <label id="search-cb-label" for="search-cb">
            <div class="search-open"></div>
          </label>

          <div class="search-bg-mb" id="search-bg-mb">
            <!-- <input type="text" name="s" id="search" placeholder="Search" size="17" value="" /> -->
      <jdoc:include type="modules" name="search"/>
          </div>
        </div>

        <label for="search-cb" class="fade" id="fadesearch"></label>

        <nav id="hamnav">
          <!-- [THE HAMBURGER] -->
          <input type="checkbox" id="hammy" name="hammy" onclick="noScrollOnMenuOpen(this)" />
          <label for="hammy">&#9776;</label>

          <!-- [MENU ITEMS] -->
          <div id="hamitems">
            <jdoc:include type="modules" name="headermenu"/>
          </div>
        </nav>
        <label for="hammy" class="fade" id="fademenu"></label>
      </div>
    </header>
<!--
PROPERLY IMPLEMENT HEADER AND FOOTER MODULES AND COMPONENT
 <jdoc:include type="modules" name="top" />

<jdoc:include type="modules" name="footer" /> -->
<main  role="main">


<jdoc:include type="message"/>
  <section class="section section-gray">
    <div class="bg-gradient">
    </div>
    <div class="container">

      <?php $app = JFactory::getApplication();
      if ($app->getMenu()->getActive()->home) {
      ?>
<div class="player-title">
      <jdoc:include type="modules" name="live"/>
      <jdoc:include type="modules" name="live-title"/>
</div>
<?php
}
else {
  // you are out!
} ?>
      <jdoc:include type="modules" name="featured"/>
      <span class="titles">
      <jdoc:include type="modules" name="titles"/>
      </span>

      <jdoc:include type="component"/>
      <jdoc:include type="modules" name="main"/>

      </div>
      <div class="bg-gradient bg-gradient-r">
      </div>
</section>  <!-- livefeed-featured section -->
<?php $app = JFactory::getApplication();
if ($app->getMenu()->getActive()->home) {
?>
<section class="section" id="content-creators-section">
  <div class="container">
      <jdoc:include type="modules" name="content-creators" />
  </div>
</section>
<?php
}
else {
  // you are out!
} ?>


</main>

<footer class="site-footer">
  <div class="container">
    <div class="menu-footer-menu-container">
                <jdoc:include type="modules" name="footermenu" />
    </div>

    <a href="#" class="footer-logo"></a>


  </div>
  <div class="slogan">
    <strong>ONE GREAT WORK NETWORK</strong><br />
    <em>Ending Slavery, One Mind At A Time.</em>
  </div>
</footer>

</div>
<script type="text/javascript" src="<?php echo $this->baseurl ?>
/templates/<?php echo $this->template ?>/js/scripts.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function() {
    const regex = new RegExp("^https?://(www.)?(?:onegreatworknetwork.com|localhost).*");
    jQuery("a").each(function() {
      if (/^http/.test(this.href) && !(regex.test(this.href))) {
          jQuery(this).attr("target", "_blank");
      }
    })
  });
</script>
</body>
</html>
