<?php
/*------------------------------------------------------------------------
# mod_gegabyte_randomarticle - Gegabyte Random Article
# ------------------------------------------------------------------------
# author    Bilal Kabeer Butt
# copyright Copyright (C) 2013 GegaByte.org. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.gegabyte.org
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once JPATH_SITE . '/components/com_content/helpers/route.php';

$total = count($rows);
?>
<div class="blog-featured-fp-container">
<div class="feed-posts blog-featured-fp">


<?php
if ( $total >= 1 ) {

	for ($a=0;$a<=($total-1);$a++){
		$ArticleTitle = $rows[$a]['title'];
		$IntroText = $rows[$a]['introtext'];

 $userid = $rows[$a]["created_by"];
 $user = JFactory::getUser($userid);
 $userFields = FieldsHelper::getFields('com_users.user', $user, true);
 $username=$user->get('name');
 $userlink=$user->get('name');



$catid = $rows[$a]["catid"];
foreach ($userFields as $ccf) {

if ($ccf->name == "blog-url") {
 $catlink = $ccf->value;
}}
		$images = json_decode($rows[$a]["images"]);

?>
<div class="feed-post item">

<div class="feed-post-thumb">
	<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($rows[$a]["id"],$rows[$a]["catid"])); ?>" itemprop="url" class="feed-post-thumb-a" style="background-image: url(<?php echo $images->image_intro;?>);"></a>
</div>
<?php
		if ($title == 1 && $use_as_reviews == 0 ){
			echo '<h2 class="item-title" itemprop="headline"><a href="' . JRoute::_(ContentHelperRoute::getArticleRoute($rows[$a]["id"],$rows[$a]["catid"])) . '">' . $ArticleTitle . '</a></h2>';
		} ?>
<?php
			if ($limit_article != 0){
				if (is_numeric($article_length)){
					// echo substr($IntroText,0,$article_length);
				}else{
					// echo substr($IntroText,0,50);
				}
			}else{
				// echo $IntroText;
			}
		?>
		<?php if ($use_as_reviews == 1){?>
			<h5 style="position:relative; margin-top:10px; text-align:right;"><em>By <?php echo $ArticleTitle; ?></em></h5>
		<?php }
?>

<div class="article-info feed-post-info-random">
	<dd class="category-name">
	<a  href="<?php echo $catlink; ?>"><?php echo $username; ?></a></dd>
</div>

</dl>


</div>
<!-- end feed-post -->
<?php
	}
}else{?>
	<h3>No articles found!</h3>
<?php } ?>
</div>
</div>
