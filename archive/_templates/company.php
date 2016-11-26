<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
        <title><?=$company['title']?></title>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/uikit/1.2.0/css/uikit.gradient.min.css" rel="stylesheet" type="text/css">
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <div class="uk-container uk-container-center">
            <div class="uk-grid">
                <div id="navigation" class="uk-width-medium-1-4">
                    <h1 class="nav-header"><?=$company['title']?></h1>
                    <a class="nav-header" href="http://<?=$company['website']?>"><?=$company['website_name']?></a>
                    <ul class="uk-nav uk-nav-side">

                    <?php if (count($languages) > 1): ?>
                        <li class="language-select">
                            <a>
                                <?=tl('Language: ')?>
                                <select onchange="document.location = 'index.php?l=' + this.value;">
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

                    <?php if (count($company['awards']) > 0): ?>
                        <li><a href="#awards"><?=tl('Awards & Recognition')?></a></li>
                    <?php endif; ?>

                    <?php if (count($company['quotes']) > 0): ?>
                        <li><a href="#quotes"><?=tl('Selected Articles')?></a></li>
                    <?php endif; ?>

                    <?php if (count($company['additional_links']) > 0): ?>
                        <li><a href="#links"><?=tl('Additional Links')?></a></li>
                    <?php endif; ?>

                    <li><a href="#credits"><?=tl('Team')?></a></li>
					<li><a href="#contact"><?=tl('Contact')?></a></li>
                </ul>
            </div>

            <div id="content" class="uk-width-medium-3-4">
                <?php if (file_exists("images/header.png")): ?>
                    <img src="images/header.png" class="header">
                <?php endif; ?>

                <div class="uk-grid">
                    <div class="uk-width-medium-2-6">
                        <h2 id="factsheet"><?=tl('Factsheet')?></h2>

                        <p>
                            <strong><?=tl('Developer:')?></strong><br/>
                            <a href=""><?=$company['title']?></a><br/>
                            <?=tl('Based in %s', $company['location'])?>
                        </p>

                        <p>
                            <strong><?=tl('Founding date:')?></strong><br/>
                            <?=$company['founding_date']?>
                        </p>

                        <p>
                            <strong><?=tl('Website:')?></strong><br/>
                            <a href="http://<?=$company['website']?>"><?=$company['website_name']?></a>
                        </p>

                        <p>
                            <strong><?=tl('Press / Business Contact:')?></strong><br/>
                            <a href="mailto:<?=$company['contact']?>"><?=$company['contact']?></a>
                        </p>

                        <p>
                            <strong><?=tl('Social:')?></strong><br/>

                            <?php foreach($company['social'] as $social): ?>
                                <a href="http://<?=parseLink($social['url'])?>"><?=$social['name']?></a><br/>
                            <?php endforeach; ?>
                        </p>

                        <p>
                            <strong><?=tl('Releases:')?></strong><br />

                            <?php foreach ($company['releases'] as $release): ?>
                                <a href="<?=$release['url']?>"><?=$release['name']?></a><br/>
                            <?php endforeach; ?>
                        </p>

                        <p>
                            <?php if (count($company['address']) > 0): ?>
                                <strong><?=tl('Address:')?></strong></br/>
                                <?php foreach($address as $addressLine): ?>
                                    <?=$addressLine?><br/>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </p> 

                        <p>
                            <strong><?=tl('Phone:')?></strong><br/>
                            <?=$company['phone']?>
                        </p>
                    </div>

                    <div class="uk-width-medium-4-6">
                        <h2 id="description"><?=tl('Description')?></h2>
                        <p><?=$company['description']?></p>

                        <h2 id="history"><?=tl('History')?></h2>
                        <?php foreach ($company['history'] as $history): ?>
                            <strong><?=$history['header']?></strong>
                            <p><?=$history['text']?></p>
                        <?php endforeach; ?>

                        <h2 id="projects"><?=tl('Projects')?></h2>
                        <ul>
                            <?php foreach ($company['releases'] as $release): ?>
                                <li><a href="<?=$release['url']?>"><?=$release['name']?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <hr>

                <h2 id="trailers"><?=tl('Videos')?></h2>

                <?php if (count($company['trailers']) === 0): ?>
                    <p><?=tlHtml('There are currently no trailers available for %s. Check back later for more or <a href="#contact">contact us</a> for specific requests!', $company['title'])?></p>
                <?php else: ?>
                    <?php foreach ($company['trailers'] as $trailer): ?>
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

                <?php if ($company['images_archive_size'] !== 0): ?>
                    <a href="images/images.zip"><div class="uk-alert"><?=tl('download all screenshots & photos as .zip (%s)', $company['images_archive_size'])?></div></a>
                <?php endif; ?>

                <div class="uk-grid images">
                    <?php if (count($company['images']) > 0): ?>
                        <?php foreach ($company['images'] as $image): ?>
                            <div class="uk-width-medium-1-2">
                                <a href="images/<?=$image?>"><img src="images/<?=$image?>" alt="<?=$image?>" /></a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <p class="images-text"><?=tlHtml('There are far more images available for %s, but these are the ones we felt would be most useful to you. If you have specific requests, please do <a href="#contact">contact us</a>!', $company['title'])?></p>

                <hr>

                <h2 id="logo"><?=tl('Logo & Icon')?></h2>

                <?php if ($company['logo_archive_size'] !== 0): ?>
                    <a href="images/logo.zip"><div class="uk-alert"><?=tl('download logo files as .zip (%s)', $company['logo_archive_size'])?></div></a>
                <?php endif; ?>

                <div class="uk-grid images">
                    <?php if ($company['logo'] !== NULL): ?>
                        <div class="uk-width-medium-1-2"><a href="images/logo.png"><img src="images/logo.png" alt="logo" /></a></div>
                    <?php endif; ?>

                    <?php if ($company['icon'] !== NULL): ?>
                        <div class="uk-width-medium-1-2"><a href="images/icon.png"><img src="images/icon.png" alt="logo" /></a></div>
                    <?php endif; ?>
                </div>

                <?php if ($company['logo'] === NULL && $company['icon'] === NULL): ?>
                    <p><?=tlHtml('There are currently no logos or icons available for %s. Check back later for more or <a href="#contact">contact us</a> for specific requests!', $company['title'])?></p>
                <?php endif; ?>

                <hr>

                <?php if (count($company['awards']) > 0): ?>
                    <h2 id="awards"><?=tl('Awards & Recognition')?></h2>

                    <ul>
                        <?php foreach ($company['awards'] as $award): ?>
                            <li><?=$award['description']?> - <cite><?=$award['info']?></cite></li>
                        <?php endforeach; ?>
                    </ul>

                    <hr>
                <?php endif; ?>

                <?php if (count($company['quotes']) > 0): ?>
                    <h2 id="quotes"><?=tl('Selected Articles')?></h2>
                    
                    <ul>
                        <?php foreach ($company['quotes'] as $quote): ?>
                            <li>
                                <?=$quote['description']?><br/>
                                <cite>- <?=$quote['name']?>, <a href="<?=$quote['url']?>"><?=$quote['website']?></a></cite>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <hr>
                <?php endif; ?>

                <?php if (count($company['additional_links']) > 0): ?>
                    <h2 id="links"><?=tl('Additional Links')?></h2>

                    <?php foreach ($company['additional_links'] as $additionaLink): ?>
                        <p>
                            <strong><?=$additionaLink['title']?></strong><br/>
                            <?=$additionaLink['description']?> <a href="<?=$additionaLink['url']?>"><?=$additionaLink['urlName']?></a>.
                        </p>
                    <?php endforeach; ?>

                    <hr>
                <?php endif; ?>

                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <h2 id="credits"><?=tl('Team & Repeating Collaborators')?></h2>
                        
                        <?php foreach ($company['credits'] as $credit): ?>
                            <p>
                                <?php if ($credit['url'] === null): ?>
                                    <strong><?=$credit['name']?></strong><br/>
                                    <?=$credit['role']?>
                                <?php else: ?>
                                    <strong><?=$credit['name']?></strong><br/>
                                    <a href="<?=$credit['url']?>"><?=$credit['role']?></a>
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

            <p>
                <a href="http://dopresskit.com/">presskit()</a> by Rami Ismail (<a href="http://www.vlambeer.com/">Vlambeer</a>) - also thanks to <a href="sheet.php?p=credits">these fine folks</a>
            </p>
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
</script>';

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

</html>';