<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

$db = Factory::getDbo();

$url = JUri::current();
$showAvatar = 0;
$avatar = '';
$showArticleBodyLine = 0;

if (!preg_match('/(about|all|all-content|creators|donate|featured|schedule)$/', $url)) {
  $showAvatar = 1;
	$showArticleBodyLine = 1;
}

$blockPosition = $displayData['params']->get('info_block_position', 0);

if ($showAvatar !== 0):
	$articleId = $displayData['item']->id;

	$db->setQuery(
		'SELECT up.profile_value
		FROM #__content c, #__users u, #__user_profiles up
		WHERE c.created_by = u.id AND u.id = up.user_id AND up.profile_key = ' . $db->quote("profile.avatar") . ' AND c.id = ' . $articleId
	);

	$result = $db->loadObjectList();
	$avatar = str_replace('"', "", $result[0]->profile_value);
endif;

/*echo "<pre>";
print_r($this);
echo "</pre>";*/
?>
	<dl class="article-info muted">

		<?php
			if ($showAvatar === 1):
				$img = '<dd class="avatar-article-info"><img src="' . $avatar . '" /></dd>';
				echo $img;
				echo '<div class="article-info-text">';
			endif;
		?>

		<?php if ($displayData['position'] === 'above' && ($blockPosition == 0 || $blockPosition == 2)
				|| $displayData['position'] === 'below' && ($blockPosition == 1)
				) : ?>

			<dt class="article-info-term">
				<?php if ($displayData['params']->get('info_block_show_title', 1)) : ?>
					<?php echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?>
				<?php endif; ?>
			</dt>

			<?php if ($displayData['params']->get('show_author') && !empty($displayData['item']->author )) : ?>
				<?php echo $this->sublayout('author', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
				<?php echo $this->sublayout('parent_category', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_category')) : ?>
				<?php echo $this->sublayout('category', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_associations')) : ?>
				<?php echo $this->sublayout('associations', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_publish_date')) : ?>
				<?php
					$date = $this->sublayout('publish_date', $displayData);
					if ($showAvatar === 1):
						echo str_replace('•', "", $date);
					else:
						echo $date;
					endif;
				?>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ($displayData['position'] === 'above' && ($blockPosition == 0)
				|| $displayData['position'] === 'below' && ($blockPosition == 1 || $blockPosition == 2)
				) : ?>
			<?php if ($displayData['params']->get('show_create_date')) : ?>
				<?php echo $this->sublayout('create_date', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_modify_date')) : ?>
				<?php echo $this->sublayout('modify_date', $displayData); ?>
			<?php endif; ?>

			<?php if ($displayData['params']->get('show_hits')) : ?>
				<?php echo $this->sublayout('hits', $displayData); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php
			if ($showAvatar === 1):
				echo '</div>';
			endif;
		?>
	</dl>
	<?php
		if ($showArticleBodyLine !== 0):
			echo '<div class="separator-line"></div>';
		endif;
	?>
