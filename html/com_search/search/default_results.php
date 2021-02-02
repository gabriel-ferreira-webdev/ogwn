<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$db = JFactory::getDbo();
$article = JTable::getInstance('Content', 'JTable');
?>
<div class="feed-posts search-results<?php echo $this->pageclass_sfx; ?>">
<?php foreach ($this->results as $result) : ?>
<div class="feed-post">


<?php /* get images
------------------------*/
// set default image
$defimg = Juri::root().'images/noimage.png';
$img = $defimg;

		// Joomla content
		if( strstr($result->href, 'com_content') )
		{
			preg_match_all('#\d+#', $result->href, $val);
			$id = (int)$val[0][0];
			$article->load($id);
			$images	= json_decode($article->get('images'));

			if( !empty($images->image_intro) ) {
				$img = $images->image_intro;
			}else{
				$img = $defimg;
			}
		}else
 ?>
		<?php if( !empty($img) ) { ?>
			<div class="imgcontainer">
				<a class="feed-post-thumb-a" href="<?php echo JRoute::_($result->href); ?>" style="background-image:url(<?php echo $img ?>)">

					<!-- <?php echo '<img src="'.$img.'" />'; ?> -->
				</a>
			</div>
		<?php } ?>
	<h5 class="result-title item-title">
		<!-- <?php echo $this->pagination->limitstart + $result->count . '. '; ?> -->
		<?php if ($result->href) : ?>
			<a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) : ?> target="_blank"<?php endif; ?>>
				<?php // $result->title should not be escaped in this case, as it may ?>
				<?php // contain span HTML tags wrapping the searched terms, if present ?>
				<?php // in the title. ?>
				<?php echo $result->title; ?>
			</a>
		<?php else : ?>
			<?php // see above comment: do not escape $result->title ?>
			<?php echo $result->title; ?>
		<?php endif; ?>
	</h5>
	<?php if ($result->section) : ?>
		<dd class="result-category">
			<span class="small<?php echo $this->pageclass_sfx; ?>">
				(<?php echo $this->escape($result->section); ?>)
			</span>
		</dd>
	<?php endif; ?>
	<!-- <dd class="result-text">
		<?php echo $result->text; ?>
	</dd> -->
	<?php if ($this->params->get('show_date')) : ?>
		<dd class="result-created<?php echo $this->pageclass_sfx; ?>">
			<?php echo JText::sprintf('JGLOBAL_CREATED_DATE_ON', $result->created); ?>
		</dd>
	<?php endif; ?>
	</div>
<?php endforeach; ?>
</div>
<div class="pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
