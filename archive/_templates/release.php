<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title><?=$release['title']?> - <?=$company['title']?></title>
		<link href="http://cdnjs.cloudflare.com/ajax/libs/uikit/1.2.0/css/uikit.gradient.min.css" rel="stylesheet" type="text/css">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div class="uk-container uk-container-center">
			<div class="uk-grid">
				<div id="navigation" class="uk-width-medium-1-4">
					<h1 class="nav-header"><?=$company['title']?></h1>

					<a class="nav-header" href="index.php?l=<?=$language?>"><?=tl('press kit')?></a>

					<ul class="uk-nav uk-nav-side">
                        <?php if (count($languages) > 1): ?>
                            <li class="language-select">
                                <a>
                                    <?=tl('Language: ')?>
                                    <select onchange="document.location = 'sheet.php?p=<?=htmlspecialchars($game)?>&l=' + this.value;">
                                        <?php foreach($languages as $tag => $name): ?>
                                            <option value="<?=$tag?>" <?php if ($tag == $language): ?>selected<?php endif; ?>><?= htmlspecialchars($name)?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </a>
                            </li>
                            <li class="uk-nav-divider"></li>
                        <?php endif; ?>
		
						<li><a href="#factsheet"><?=tl('Factsheet')?></a></li>
						<li><a href="#description"><?=tl('Description')?></a></li>
						<li><a href="#history"><?=tl('History')?></a></li>
						<li><a href="#projects"><?=tl('Projects')?></a></li>
						<li><a href="#trailers"><?=tl('Videos')?></a></li>
						<li><a href="#images"><?=tl('Images')?></a></li>
						<li><a href="#logo"><?=tl('Logo & Icon')?></a></li>
						
						<?php if (count($release['awards']) > 0): ?>
							<li><a href="#awards"><?=tl('Awards & Recognition')?></a></li>
						<?php endif; ?>

						<?php if (count($release['quotes']) > 0): ?>
							<li><a href="#quotes"><?=tl('Selected Articles')?></a></li>
						<?php endif; ?>

						<?php if ($release['press_can_request_copy']): ?>
							<li><a href="#preview"><?=tl('Request Press Copy')?></a></li>
						<?php endif; ?>

						<?php if ($release['allow_monetization'] >= 1): ?>
							<li><a href="#monetize"><?=tl('Monetization Permission')?></a></li>
						<?php endif; ?>

						<li><a href="#links"><?=tl('Additional Links')?></a></li>
						<li><a href="#about"><?=tl('About %s', $company['title'])?></a></li>
						<li><a href="#credits"><?=tl('Team')?></a></li>
						<li><a href="#contact"><?=tl('Contact')?></a></li>
					</ul>
				</div>

				<div id="content" class="uk-width-medium-3-4">
					<?php if (file_exists($game.'/images/header.png')): ?>
						<img src="<?=$game.'/images/header.png'?>" class="header">
					<?php endif; ?>

					<div class="uk-grid">
						<div class="uk-width-medium-2-6">
							<h2 id="factsheet"><?=tl('Factsheet')?></h2>

							<p>
								<strong><?=tl('Developer:')?></strong><br/>
								<a href="index.php?l=<?=$language?>"><?=$company['title']?></a><br/>
								<?=tl('Based in %s', $company['location'])?>
							</p>

							<p>
								<strong><?=tl('Release date:')?></strong><br/>
								<?=$release['release_date']?>
							</p>

							<p>
								<strong><?=tl('Platforms:')?></strong><br />

								<?php foreach($release['platforms'] as $platform): ?>
									<a href="<?=$platform['url']?>"><?=$platform['name']?></a><br/>
								<?php endforeach; ?>
							</p>

							<p>
								<strong><?=tl('Website:')?></strong><br/>
								<a href="<?=$release['websiteUrl']?>"><?=$release['websiteName']?></a>
							</p>

							<?php if (count($release['prices']) > 0): ?>
								<p>
									<strong><?=tl('Regular Price:')?></strong><br/>

									<table>
										<?php foreach($release['prices'] as $price): ?>
											<tr>
												<td><?=$price['currency']?></td>
												<td><?=$price['value']?></td>
											</tr>
										<?php endforeach; ?>
									</table>
								</p>
							<?php endif; ?>
						</div>

						<div class="uk-width-medium-4-6">
							<h2 id="description"><?=tl('Description')?></h2>

							<p><?=$release['description']?></p>

							<h2 id="history"><?=tl('History')?></h2>

							<?php foreach ($release['history'] as $history): ?>
								<strong><?=$history['header']?></strong>
								<p><?=$history['text']?></p>
							<?php endforeach; ?>

							<h2><?=tl('Features')?></h2>
							<ul>
								<?php foreach ($release['features'] as $feature): ?>
									<li><?=$feature?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>

					<hr>

					<h2 id="trailers"><?=tl('Videos')?></h2>

					<?php if (count($release['trailers']) === 0): ?>
                        <p><?=tlHtml('There are currently no trailers available for %s. Check back later for more or <a href="#contact">contact us</a> for specific requests!', $release['title'])?></p>
                    <?php else: ?>
                        <?php foreach ($release['trailers'] as $trailer): ?>
                            <p><strong><?=$trailer['name']?></strong>&nbsp;
                            <?=$trailer['urls']?>

                            <?php if ($trailer['embedded'] !== NULL): ?>
                                <div class="uk-responsive-width iframe-container">
                                    <?php if ($trailer['embedded']['platform'] === 'youtube'): ?>
                                        <iframe src="http://www.youtube.com/embed/<?=$trailer['embedded']['id']?>" frameborder="0" allowfullscreen></iframe>
                                    <?php endif; ?>

                                    <?php if ($trailer['embedded']['platform'] === 'vimeo'): ?>
    			                        <iframe src="http://player.vimeo.com/video/<?=$trailer['embedded']['id']?>" frameborder="0" allowfullscreen></iframe>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>

					<hr>

					<h2 id="images"><?=tl('Images')?></h2>

					<?php if ($release['images_archive_size'] !== 0): ?>
                        <a href="<?=$game?>/images/images.zip"><div class="uk-alert"><?=tl('download all screenshots & photos as .zip (%s)', $release['images_archive_size'])?></div></a>
                    <?php endif; ?>

                    <?php if (count($release['images']) > 0): ?>
                    	<div class="uk-grid images">
                            <?php foreach ($release['images'] as $image): ?>
                                <div class="uk-width-medium-1-2">
                                    <a href="<?=$game?>/images/<?=$image?>"><img src="<?=$game?>/images/<?=$image?>" alt="<?=$image?>" /></a>
                                </div>
                            <?php endforeach; ?>
                    	</div>
					<?php else: ?>
						<div class="uk-width-medium-1-1">
							<p class="images-text"><?=tlHtml('There are currently no screenshots available for %s. Check back later for more or <a href="#contact">contact us</a> for specific requests!', $release['title'])?></p>
						</div>
                    <?php endif; ?>

					<hr>

					<h2 id="logo"><?=tl('Logo & Icon')?></h2>

					<?php if ($release['logo_archive_size'] !== 0): ?>
                        <a href="<?=$game?>/images/logo.zip"><div class="uk-alert"><?=tl('download logo files as .zip (%s)', $release['logo_archive_size'])?></div></a>
                    <?php endif; ?>

					<div class="uk-grid images">
                        <?php if ($release['logo'] !== NULL): ?>
                            <div class="uk-width-medium-1-2"><a href="<?=$game?>/images/logo.png"><img src="<?=$game?>/images/logo.png" alt="logo" /></a></div>
                        <?php endif; ?>

                        <?php if ($release['icon'] !== NULL): ?>
                            <div class="uk-width-medium-1-2"><a href="<?=$game?>/images/icon.png"><img src="<?=$game?>/images/icon.png" alt="logo" /></a></div>
                        <?php endif; ?>
                    </div>

                    <?php if ($release['logo'] === NULL && $release['icon'] === NULL): ?>
                        <p><?=tlHtml('There are currently no logos or icons available for %s. Check back later for more or <a href="#contact">contact us</a> for specific requests!', $release['title'])?></p>
                    <?php endif; ?>

					<hr>

					<?php if (count($release['awards']) > 0): ?>
						<h2 id="awards"><?=tl('Awards & Recognition')?></h2>

						<ul>
							<?php foreach($release['awards'] as $award): ?>
								<li><?=$award['description']?><cite> <?=$award['info']?></cite></li>
							<?php endforeach; ?>
						</ul>

						<hr>
					<?php endif; ?>

                    <?php if (count($release['quotes']) > 0): ?>
						<h2><?=tl('Selected Articles')?></h2>

						<ul>
							<?php foreach ($release['quotes'] as $quote): ?>
								<li>
									<?=$quote['description']?><br/>
									<cite>- <?=$quote['name']?>, <a href="<?=$quote['url']?>"><?=$quote['website']?></a></cite>
								</li>
							<?php endforeach; ?>
						</ul>

						<hr>
					<?php endif; ?>

					<?php if ($press_request === TRUE): ?>
						<h2 id="preview"><?=tl('Request Press Copy')?></h2>

						<p><?=tl("Please fill in your e-mail address below to complete a distribute() request and we'll get back to you as soon as a press copy is available for you.")?><br/>

						<div id="mailform">
							<form id="pressrequest" class="uk-form" method="POST" action="<?=$url?>">
							<input type="email" id="email" name="email" placeholder="name@yourdomain.com" style="width:100%;"></input>
							<input type="hidden" id="key" name="key" value="<?=$key?>"></input><br/>
							<input type="submit" class="uk-button" id="submit-button" value="<?=tl('request a press copy')?>" style="width:100%;"></input>
							<p><?=tlHtml('Alternatively, you can always request a press copy by <a href="#contact">sending us a quick email</a>.')?></p>
						</div>

						<hr>
					<?php elseif (isset($press_request_fail) && $press_request_fail === true): ?>
						<h2 id="preview"><?=tl('Request Press Copy')?></h2>
						<p><?=$press_request_fail_msg?></p>

						<hr>
					<?php elseif (isset($press_request_outdated_warning) && $press_request_outdated_warning === true): ?>
						<h2 id="preview"><?=tl('Request Press Copy')?></h2>

						<p><?=tl("We are afraid this developer has not upgraded their presskit() to use distribute(). For security purposes, this form has been disabled.")?></p>
						<hr>
					<?php endif; ?>

					<?php if ($monetize >= 1): ?>
						<h2 id="monetize"><?=tl('Monetization Permission')?></h2>

						<?php if ($monetize === 1): ?>
							<p><?=tl('%s does currently not allow for the contents of %s to be published through video broadcasting services.', $company['title'], $release['title'])?></p>
						<?php elseif ($monetize === 2): ?>
							<p><?=tl('%s does allow the contents of this game to be published through video broadcasting services only with direct written permission from %s. Check at the bottom of this page for contact information.', $company['title'], $release['title'])?></p>
						<?php elseif ($monetize === 3): ?>
							<p><?=tl('%s allows for the contents of %s to be published through video broadcasting services for non-commercial purposes only. Monetization of any video created containing assets from %s is not allowed.', $company['title'], $release['title'], $release['title'])?></p>
						<?php elseif ($monetize === 4): ?>
							<p><?=tl('%s allows for the contents of %s to be published through video broadcasting services for any commercial or non-commercial purposes. Monetization of videos created containing assets from %s is legally & explicitly allowed by %s.', $company['title'], $release['title'], $release['title'], $company['title'])?> <?=tlHtml('This permission can be found in writing at <a href="%s">%s</a>.', 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])?></p>
						<?php endif; ?>

						<hr>
					<?php endif; ?>

					<?php if (count($release['additional_links']) > 0): ?>
                        <h2 id="links"><?=tl('Additional Links')?></h2>

                        <?php foreach ($release['additional_links'] as $additionaLink): ?>
                            <p>
                                <strong><?=$additionaLink['title']?></strong><br/>
                                <?=$additionaLink['description']?> <a href="<?=$additionaLink['url']?>"><?=$additionaLink['urlName']?></a>.
                            </p>
                        <?php endforeach; ?>

                        <hr>
                    <?php endif; ?>

					<h2 id="about"><?=tl('About %s', $company['title'])?></h2>

					<p>
						<strong><?=tl('Boilerplate')?></strong><br/>
						<?=$company['description']?>
					</p>

					<p>
						<strong><?=tl('More information')?></strong><br/>
						<?=tlHtml('More information on %s, our logo & relevant media are available <a href="%s">here</a>.', $company['title'], 'index.php'. $languageQuery)?>
					</p>

					<hr>

					<div class="uk-grid">
						<div class="uk-width-medium-1-2">
							<h2 id="credits"><?=tl('%s Credits', $release['title'])?></h2>

							<?php foreach($release['credits'] as $credit): ?>
								<p>
									<strong><?=$credit['person']?></strong><br/>

									<?php if ($credit['url'] !== NULL): ?>
										<a href="<?=$credit['url']?>"><?=$credit['role']?></a>
									<?php else: ?>
										<?=$credit['role']?>
									<?php endif; ?>
								</p>
							<?php endforeach; ?>
						</div>

						<div class="uk-width-medium-1-2">
							<h2 id="contact"><?=tl('Contact')?></h2>

							<?php foreach($company['contacts'] as $contact): ?>
		                        <p>
	    	                        <?php if ($contact['url'] !== null): ?>
	        	                        <strong><?=$contact['name']?></strong><br/>
	            	                    <a href="<?=$contact['url']?>"><?=$contact['urlName']?></a>
	                	            <?php endif; ?>

	                    	        <?php if ($contact['email'] !== null): ?>
	                        	        <strong><?=$contact['name']?></strong><br/>
	                            	    <a href="mailto:<?=$contact['email']?>"><?=$contact['email']?></a>
	                            	<?php endif; ?>
	                        	</p>
	                    	<?php endforeach; ?>
						</div>
					</div>

					<hr>

					<p><a href="http://dopresskit.com/">presskit()</a> by Rami Ismail (<a href="http://www.vlambeer.com/">Vlambeer</a>) - also thanks to <a href="sheet.php?p=credits">these fine folks</a></p>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.0.4/jquery.imagesloaded.js"></script>		
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/masonry/3.1.2/masonry.pkgd.min.js"></script>
		<script type="text/javascript">
			$( document ).ready(function() {
				var container = $('.images');

				container.imagesLoaded( function() {
					container.masonry({
						itemSelector: '.uk-width-medium-1-2',
					});
				});
			});
		</script>

		<?php if ($company['google_analytics'] !== null): ?>
    		<script type="text/javascript">
        		var _gaq = _gaq || [];
        		_gaq.push(['_setAccount', '<?=$company['google_analytics']?>');
        		_gaq.push(['_trackPageview']);

		        (function() {
            		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        		})();
    		</script>
		<?php endif; ?>
	</body>
</html>