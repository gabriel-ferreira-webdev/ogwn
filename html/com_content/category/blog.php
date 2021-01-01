<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

JHtml::_('behavior.caption');

$db = Factory::getDbo();
$dispatcher = JEventDispatcher::getInstance();

$this->category->text = $this->category->description;
$dispatcher->trigger('onContentPrepare', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$this->category->description = $this->category->text;

$results = $dispatcher->trigger('onContentAfterTitle', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentBeforeDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentAfterDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayContent = trim(implode("\n", $results));

$db->setQuery(
	'SELECT DISTINCT(u.id), u.name FROM #__users u, #__user_profiles up, #__categories ca'
	. ' WHERE ca.title = u.name AND u.id = up.user_id AND ca.alias = ' . $db->quote($this->category->alias)
);

$result = $db->loadObjectList();
$userId = $result[0]->id;
$name = $result[0]->name;

/*$db->setQuery(
	'SELECT profile_key, profile_value FROM #__users u, #__user_profiles up, #__categories ca'
	. ' WHERE ca.title = u.name AND u.id = up.user_id AND ca.alias = ' . $db->quote($this->category->alias) . ' ORDER BY up.ordering ASC'
);

$result = $db->loadObjectList();*/

$profileLeft = '';
$miscProfileInfo = '';
$profileLinks = '<ul class="social-icons">';
$website = '';

/*JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
$customFields = FieldsHelper::getFields('com_users.user', JFactory::getUser($userId), true);*/

$userProfile = JUserHelper::getProfile($userId);

$res;
$j = 0;
foreach ($userProfile->profile as $k => $v):
	$res[$j] = ['name' => $k, 'value' => $v];
	$j++;
endforeach;

/*echo "<pre>";
// print_r($this->item->user_id);
print_r($res);
// print_r($fields);
echo "</pre>";*/

foreach ($res as $arr) :
	$text = htmlspecialchars($arr['value'], ENT_COMPAT, 'UTF-8');

	if ($text !== '') :
		$varName = $arr['name'];

		if (strpos($text, 'http') !== false) :
			$link = '';
			$v_social = strpos($varName, 'social-');

			if ($v_social !== false) :
				$link = '<span class="social-icon ' . $varName . '"></span>';
			elseif ($varName === 'website') :
				$website = '<div class="' . $varName . '"><a href="' . $text . '">' . $text . '</a></div>';
				continue;
			else :
				$link = JStringPunycode::urlToUTF8($text);
			endif;

			$profileLinks .= '<li><a href="' . $text . '">' . $link . '</a></li>';
		elseif (strpos($varName, 'avatar') !== false) :
			$profileLeft = '<div class="author-page-header-profile ' . $varName . '">
				<img class="avatar avatar-300 photo" src="' . $text . '" />
				<nav class="author-donate">
					<a href="donate">DONATE TO<br>' . $name . '</a>
				</nav>
			</div>';
		else :
			$miscProfileInfo .= '<div class="' . $varName . '">' . $text . '</div>';
		endif;
	endif;
endforeach;

$profileLinks .= '</ul>';
?>
<div class="author-profile" id="users-profile-custom">
	<div class="author-container">
		<?php echo $profileLeft ?>
		<div class="author-page-header-side">
			<h2 class="author-name"><?php echo $this->category->title ?></h2>
			<?php echo $miscProfileInfo ?>
			<?php echo $website ?>
			<?php echo $profileLinks ?>
			<div class="clr"></div>
		</div>
	</div>
</div>

<div class="blog<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		</div>
	<?php endif; ?>

	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
		<h2> <?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<span class="subheading-category"><?php echo $this->category->title; ?></span>
			<?php endif; ?>
		</h2>
	<?php endif; ?>
	<?php echo $afterDisplayTitle; ?>

	<?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
	<?php endif; ?>

	<?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div class="category-desc clearfix">
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
				<img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>"/>
			<?php endif; ?>
			<?php echo $beforeDisplayContent; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
			<?php endif; ?>
			<?php echo $afterDisplayContent; ?>
		</div>
	<?php endif; ?>

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<div class="items-leading clearfix">
			<?php foreach ($this->lead_items as &$item) : ?>
				<div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
					?>
				</div>
				<?php $leadingcount++; ?>
			<?php endforeach; ?>
		</div><!-- end items-leading -->
	<?php endif; ?>

	<?php
	$introcount = count($this->intro_items);
	$counter = 0;
	?>

	<?php if (!empty($this->intro_items)) : ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
			<?php $rowcount = ((int) $key % (int) $this->columns) + 1; ?>
			<?php if ($rowcount === 1) : ?>
				<?php $row = $counter / $this->columns; ?>
				<div class="items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?> row-fluid clearfix">
			<?php endif; ?>
			<div class="span<?php echo round(12 / $this->columns); ?>">
				<div class="item column-<?php echo $rowcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
					?>
				</div>
				<!-- end item -->
				<?php $counter++; ?>
			</div><!-- end span -->
			<?php if (($rowcount == $this->columns) or ($counter == $introcount)) : ?>
				</div><!-- end row -->
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if (!empty($this->link_items)) : ?>
		<div class="items-more">
			<?php echo $this->loadTemplate('links'); ?>
		</div>
	<?php endif; ?>

	<?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
		<div class="cat-children">
			<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3> <?php echo JText::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
			<?php endif; ?>
			<?php echo $this->loadTemplate('children'); ?> </div>
	<?php endif; ?>
	<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
			<?php endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?> </div>
	<?php endif; ?>
</div>