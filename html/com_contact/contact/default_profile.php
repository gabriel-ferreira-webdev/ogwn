<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

if (JPluginHelper::isEnabled('user', 'profile')) :
	$fields = $this->item->profile->getFieldset('profile'); ?>

	<?php
	/*echo "<pre>";
	// print_r($this->item->user_id);
	print_r($this->item);
	// print_r($fields);
	echo "</pre>";*/

	$name = $this->item->name;

	$db = Factory::getDbo();

	$db->setQuery(
		'SELECT co.id, co.title, co.alias, co.catid, co.images, ca.alias AS path  FROM #__content co, #__categories ca'
			. ' WHERE co.catid = ca.id AND co.created_by = ' . (int) $this->item->user_id . ' ORDER BY co.id DESC'
	);

	$result = $db->loadObjectList();

	$userPosts = '<div class="author-feed-posts feed-posts">';
	foreach ($result as $row) {
		$imageDB = json_decode($row->images);
		$image = $imageDB->image_intro;

		/*$url = JUri::base();
		$url .= $row->catid . '-' . $row->path . '/' . $row->id . '-' . $row->alias;*/
		// $url .= $row->id . '-' . $row->alias;
		// $url .= $row->path . '/' . $row->id . '-' . $row->alias;

		$url = JRoute::_(ContentHelperRoute::getArticleRoute($row->id, $row->catid));

		$userPosts .= '
			<div class="feed-post">
				<div class="item-image">
					<img src="' . $image . '" />
				</div>
				<div class="item-title">
					<a href="' .  $url . '">' . $row->title . '</a>
				</div>
			</div>';
	}
	$userPosts .= '</div>';

	$profileLeft = '';
	$miscProfileInfo = '';
	$profileLinks = '<ul class="social-icons">';
	$website = '';

	foreach ($fields as $profile) :
		if ($profile->value) :
			$profile->text = htmlspecialchars($profile->value, ENT_COMPAT, 'UTF-8');

			switch ($profile->type) :
				case 'Url':
					$link = '';
					$v_social = strpos($profile->class, 'social-');

					if ($v_social !== false) :
						$link = '<span title="' . $profile->description . '" class="social-icon ' . $profile->class . '"></span>';
					elseif ($profile->id === 'profile_website') :
						$website = '<div class="float-right ' . $profile->id . '"><a href="' . $profile->text . '">' . $profile->text . '</a></div>';
						break;
					else :
						$link = JStringPunycode::urlToUTF8($profile->text);
					endif;

					$profileLinks .= '<li><a href="' . $profile->text . '">' . $link . '</a></li>';

					break;
				default:
					if (strpos($profile->name, 'avatar') !== false) :
						$profileLeft = '<div class="author-page-header-profile ' . $profile->id . '">
							<img class="avatar avatar-300 photo" src="' . $profile->text . '" />
							<nav class="author-donate">
								<a href="donate">DONATE TO<br>' . $name . '</a>
							</nav>
						</div>';
					else :
						$miscProfileInfo .= '<div class="' . $profile->id . '">' . $profile->text . '</div>';
					endif;
					break;
			endswitch;
		endif;
	endforeach;

	$profileLinks .= '</ul>';
	?>

	<div class="contact-profile" id="users-profile-custom">
		<div class="author-container">
			<?php echo $profileLeft ?>
			<div class="author-page-header-side">
				<h2 class="author-name"><?php echo $name ?></h2>
				<?php echo $miscProfileInfo ?>
				<?php echo $website ?>
				<?php echo $profileLinks ?>
				<div class="clr"></div>
			</div>
		</div>
	</div>
	<?php echo $userPosts ?>
<?php endif; ?>
