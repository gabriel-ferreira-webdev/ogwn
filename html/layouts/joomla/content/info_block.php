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
$showArticleBodyLine = 0;
$avatarURL = '';
$catAlias = '';
$articleId = '';
$assetId = '';

/*echo "<pre>";
var_dump($displayData);
echo "</pre>";*/

$blockPosition = $displayData['params']->get('info_block_position', 0);

if (!preg_match('/(about|all|all-content|creators|donate|featured|schedule)$/', $url)) {

  $showAvatar = 1;
	$showArticleBodyLine = 1;
	$articleId = $displayData['item']->id;
	if (property_exists($displayData['item'], "asset_id")):
		$assetId = $displayData['item']->asset_id;
	endif;
}

if ($showAvatar !== 0):
	if (!empty($assetId)):
		// ID of article in _content.id (63)
		// Asset ID of article in _content.asset_id (261)
		// where _content.created_by = _users.id (301)
		// where _users.id = _user_profiles.user_id
		// where _user_profiles.profile_key = profile.avatar
		// get _user_profiles.profile_value
		$sql = 'SELECT up.profile_value, ca.alias
		FROM jospn_content c
			INNER JOIN jospn_users u ON c.created_by = u.id
			INNER JOIN jospn_user_profiles up ON u.id = up.user_id,
			jospn_assets a
				INNER JOIN jospn_categories ca ON a.parent_id = ca.asset_id
		WHERE up.profile_key = ' . $db->quote("profile.avatar") . ' AND c.id = ' . $articleId . ' AND a.id = ' . $assetId;

		$db->setQuery($sql);

		$result = $db->loadObjectList();
		$avatarURL = stripslashes(str_replace('"', "", $result[0]->profile_value));
		$catAlias = str_replace('"', "", $result[0]->alias);
	endif;
endif;
?>
	<dl class="article-info muted">

		<?php
			if (!empty($assetId) && $showAvatar !== 0):
				$img = '<dd class="avatar-article-info"><a href="' . $catAlias . '"><img src="' . $avatarURL . '" /></a></dd>';
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
					if ($showAvatar !== 0):
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
			if ($showAvatar !== 0):
				echo '</div>';
			endif;
		?>
	</dl>
	<?php
		if ($showArticleBodyLine !== 0):
			echo '<div class="separator-line"></div>';
		endif;
	?>
