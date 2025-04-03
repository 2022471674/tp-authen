<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>
			WritePress - Clean Blog HTML template
		</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="manifest" href="site.webmanifest">
		<link rel="shortcut icon" type="image/x-icon" href="/static/assets/imgs/favicon.png">
		<!-- UltraNews CSS -->
		<link rel="stylesheet" href="/static/assets/css/style.css">
		<link rel="stylesheet" href="/static/assets/css/widgets.css">
		<link rel="stylesheet" href="/static/assets/css/color.css">
		<link rel="stylesheet" href="/static/assets/css/responsive.css">
		<style>
		#particles-js {
			transition: opacity 0.5s ease;
			background: linear-gradient(135deg,rgb(184, 198, 236) 0%,#55acee 100%);
			}
			@media (prefers-color-scheme: dark) {	
    	body {
        	background:rgb(231, 222, 222);
    	}
    	.screen {
        	background: linear-gradient(90deg, #2D3748, #4A5568);
        	box-shadow: 0px 0px 24px rgba(0,0,0,0.5);
    	}
		}
		#particles-js:hover {
    	opacity: 0.9;
		}
    	position: fixed;
    	width: 100%;
    	height: 100%;
    	top: 0;
    	left: 0;
			z-index: -1; /* 确保在其他内容下方 */
		</style>
	</head>
	<body class="single">
		<div class="scroll-progress">
		</div>
		
		<!-- Preloader Start -->
		<div id="preloader-active">
			<div class="preloader d-flex align-items-center justify-content-center primary-bg color-white">
				<div class="preloader-inner position-relative">
					<div class="text-center font-heading">
						<img src="/static/assets/imgs/logo-light.svg" alt="">
						<h1>
							WritePress
						</h1>
						<h6>
							Now loading...
						</h6>
					</div>
				</div>
			</div>
		</div>
		<!-- Preloader Start -->
		<div class="row no-gutters reading-mode-cover">
			<div class="col-1-5">
				<button class="exit-reading-mode mt-30 ml-30">
					<span class="long-arrow long-arrow-left">
					</span>
					<span class="text-uppercase back-text">
						Back
					</span>
				</button>
			</div>
			<div class="col-3-5">
				<div class="single-reading-mode">
				</div>
			</div>
		</div>
		<div class="single-body-wrap">
			<!--Offcanvas sidebar-->
			<aside id="sidebar-wrapper" class="custom-scrollbar offcanvas-sidebar position-right">
				<div class="row no-gutters">
					<div class="col-1-5">
					</div>
					<div class="col-4-5 position-relative secondary-bg pt-75">
						<div class="offcanvas-inner color-white">
							<div class="row font-heading font-large">
								<div class="col-lg-3 col-md-6 mb-50">
									<div class="widget-header widget-header-style-1 position-relative">
										<h4 class="widget-title mt-5 mb-30">
											Home
										</h4>
									</div>
									<ul class="mt-50">
										<li>
											<a href="index.html">
												Home default
											</a>
										</li>
										<li>
											<a href="home-2.html">
												Home page two
											</a>
										</li>
										<li>
											<a href="home-3.html">
												Home page three
											</a>
										</li>
									</ul>
								</div>
								<div class="col-lg-3 col-md-6 mb-50">
									<div class="widget-header widget-header-style-1 position-relative">
										<h4 class="widget-title mt-5 mb-30">
											Archive
										</h4>
									</div>
									<ul class="mt-50">
										<li>
											<a href="category.html">
												Default
											</a>
										</li>
										<li>
											<a href="category-list.html">
												List layout
											</a>
										</li>
										<li>
											<a href="category-grid.html">
												Grid layout
											</a>
										</li>
										<li>
											<a href="category-big.html">
												Big thumbnail
											</a>
										</li>
									</ul>
								</div>
								<div class="col-lg-3 col-md-6">
									<div class="widget-header widget-header-style-1 position-relative">
										<h4 class="widget-title mt-5 mb-30">
											Pages
										</h4>
									</div>
									<ul class="mt-50">
										<li>
											<a href="elements.html">
												Elements
											</a>
										</li>
										<li>
											<a href="about.html">
												About
											</a>
										</li>
										<li>
											<a href="contact.html">
												Contact
											</a>
										</li>
										<li>
											<a href="search.html">
												Search
											</a>
										</li>
										<li>
											<a href="author.html">
												Author
											</a>
										</li>
										<li>
											<a href="404.html">
												404
											</a>
										</li>
									</ul>
								</div>
								<div class="col-lg-3 col-md-6">
									<div class="widget-header widget-header-style-1 position-relative">
										<h4 class="widget-title mt-5 mb-30">
											Single
										</h4>
									</div>
									<ul class="mt-50">
										<li>
											<a href="single.html">
												Standard
											</a>
										</li>
										<li>
											<a href="single-video.html">
												Video
											</a>
										</li>
										<li>
											<a href="single-audio.html">
												Audio
											</a>
										</li>
										<li>
											<a href="single-gallery.html">
												Gallery
											</a>
										</li>
										<li>
											<a href="single-quote.html">
												Quote
											</a>
										</li>
										<li>
											<a href="single-image.html">
												Image
											</a>
										</li>
										<li>
											<a href="single-no-sidebar.html">
												No sidebar
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="row mt-50">
								<div class="col-lg-3 col-md-6">
									<div class="sidebar-widget widget-text">
										<div class="widget-header widget-header-style-1 position-relative">
											<h4 class="widget-title mt-5 mb-30">
												Contact
											</h4>
										</div>
										<div class="textwidget">
											<p>
												<strong>
													Address
												</strong>
												<br>
												123 Main Street
												<br>
												New York,NY 10001
											</p>
											<p>
												<strong>
													Hours
												</strong>
												<br>
												Monday—Friday:9:00AM–5:00PM
												<br>
												Saturday &amp;Sunday:11:00AM–3:00PM
											</p>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-6">
									<div class="sidebar-widget widget-twitter">
										<div class="widget-header widget-header-style-1 position-relative mb-30">
											<h5 class="widget-title mt-5 mb-30">
												Latest Tweets
											</h5>
										</div>
										<ul class="twitter-widget-inner mt-50">
											<li class="twitter-content">
												<span class="twitter-icon">
													<i class="ti-twitter-alt">
													</i>
												</span>
												<p>
													Buy Ultranews - HTML template on
													<a target="_blank" href="https://themeforest.net/item/ultranews-magazine-bootstrap-4-template/26563121"
													class="twitter-link">
														@ThemeForest
													</a>
													<span class="meta_date">
														Apr 9,2020
													</span>
												</p>
											</li>
											<li class="twitter-content">
												<span class="twitter-icon">
													<i class="ti-twitter-alt">
													</i>
												</span>
												<p>
													EmBe — All You Need to build a Magazine,News portal or Blog site
													<a target="_blank" href="https://themeforest.net/item/embe-flexible-magazine-wordpress-theme/24531103"
													class="twitter-link">
														@ThemeForest
													</a>
													<span class="meta_date">
														Jan 31,2020
													</span>
												</p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</aside>
			<!--Search form-->
			<aside id="search-wrapper" class="custom-scrollbar-2 offcanvas-search position-right">
				<div class="row no-gutters">
					<div class="col-1-5">
					</div>
					<div class="col-4-5 position-relative secondary-bg pt-120">
						<div class="offcanvas-inner color-white main-search-form transition-02s">
							<h2 class="font-x-large">
								Search
							</h2>
							<div class="pt-10 pb-50 main-search-form-cover">
								<div class="row mb-20">
									<div class="col-12">
										<form action="#" method="get" class="search-form position-relative">
											<label>
												<input type="text" class="search_field" placeholder="Enter keywords for search..."
												value="" name="s">
											</label>
											<div class="search-switch">
												<ul class="list-inline color-grey">
													<li class="list-inline-item">
														<i class="ti-book mr-5">
														</i>
														<a href="#" class="active">
															Articles
														</a>
													</li>
													<li class="list-inline-item">
														<i class="ti-user mr-5">
														</i>
														<a href="#">
															Authors
														</a>
													</li>
												</ul>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col-12 font-medium suggested-area">
										<p class="d-inline font-medium suggested">
											<strong>
												Suggested:
											</strong>
										</p>
										<ul class="list-inline d-inline-block">
											<li class="list-inline-item">
												<a href="#">
													Covid-19
												</a>
											</li>
											<li class="list-inline-item">
												<a href="#">
													Health
												</a>
											</li>
											<li class="list-inline-item">
												<a href="#">
													WFH
												</a>
											</li>
											<li class="list-inline-item">
												<a href="#">
													UltraNet
												</a>
											</li>
											<li class="list-inline-item">
												<a href="#">
													Hospital
												</a>
											</li>
											<li class="list-inline-item">
												<a href="#">
													Policies
												</a>
											</li>
											<li class="list-inline-item">
												<a href="#">
													Energy
												</a>
											</li>
											<li class="list-inline-item">
												<a href="#">
													Business
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</aside>
			<div id="particles-js" style="position: fixed; width: 100%; height: 100%; z-index: -1;"></div>

			<div class="main-wrap">
				<header class="main-header header-style primary-bg color-white header-style-2">
					<div class="header-sticky primary-bg">
						<div class="mobile_menu d-lg-none d-block font-heading">
							<div class="off-canvas-toggle-cover">
								<div class="off-canvas-toggle hidden d-inline-block">
									<span>
									</span>
								</div>
							</div>
							<div class="mobile-logo text-center d-inline-block d-lg-none mt-5">
								<a href="index.html" class="d-inline-block">
									<img src="/static/assets/imgs/logo-mobile.png" alt="">
								</a>
							</div>
							<button class="search-icon">
								<i class="fa fa-search">
								</i>
							</button>
						</div>
						<div class="row no-gutters d-none d-lg-flex">
							<div class="col-lg-4 pl-30">
								<ul class="header-social-network d-inline-block list-inline">
									<li class="list-inline-item">
										
									</li>
									<li class="list-inline-item">
										
							</div>
							<div class="col-lg-4 text-center">
								<div class="logo-text">
									<h1 class="color-white site-name">
										<a href="<?= url('main/login') ?>" class="d-inline-block mb-0 mt-15">
											WritePress
										</a>
									</h1>
								</div>
							</div>
							<div class="col-lg-4 position-relative text-right">
								<div class="main-nav text-center d-none d-lg-block text-uppercase">
									<nav>
										<ul id="navigation" class="main-menu float-lg-right">
											<li class="menu-item-has-children">
												<a href="index.html">
													Home
												</a>
												<ul class="sub-menu">
													<li>
														<a href="index.html">
															Home I
														</a>
													</li>
													<li>
														<a href="home-2.html">
															Home II
														</a>
													</li>
													<li>
														<a href="home-3.html">
															Home III
														</a>
													</li>
												</ul>
											</li>
											<li>
												<a href="about.html">
													About
												</a>
											</li>
											<li>
												<a href="contact.html">
													Contact
												</a>
											</li>
										</ul>
									</nav>
								</div>
								<!-- Search -->
								<div class="search-button d-none d-md-block color-white">
									<button class="search-icon">
										<i class="fa fa-search">
										</i>
									</button>
								</div>
								<div class="off-canvas-toggle-cover">
									<div class="off-canvas-toggle hidden d-inline-block">
										<span>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</header>
				<main class="position-relative row no-gutters">
					<div class="col-1-5 col-sm-6 left-sidbar sticky-sidebar primary-sidebar order-2 order-lg-1">
						<div class="sidebar-widget widget-latest-posts mb-50 mt-50">
							<div class="widget-header widget-header-style-1 position-relative mb-30  wow fadeInUp animated">
								<h5 class="widget-title mt-5 mb-30">
									Recent Posts
								</h5>
							</div>
							<div class="post-block-list post-module-6 mt-50 overflow-hidden">
								<div class="post-module-6-item d-flex  wow fadeInUp animated">
									<span class="item-count vertical-align">
										1.
									</span>
									<div class="alith_post_title_small">
										<h5>
											<a href="single.html">
												If You Only Read A Few Books In 2020,Read These
											</a>
										</h5>
										<div class="entry-meta meta-1 font-small color-grey">
											<span class="post-on">
												15 March
											</span>
											<span class="hit-count has-dot">
												22k Views
											</span>
										</div>
									</div>
								</div>
								<div class="post-module-6-item d-flex  wow fadeInUp animated">
									<span class="item-count vertical-align">
										2.
									</span>
									<div class="alith_post_title_small">
										<h5>
											<a href="single.html">
												Inslee announces contact tracing initiative
											</a>
										</h5>
										<div class="entry-meta meta-1 font-small color-grey">
											<span class="post-on">
												25 April
											</span>
											<span class="hit-count has-dot">
												26k Views
											</span>
										</div>
									</div>
								</div>
								<div class="post-module-6-item d-flex  wow fadeInUp animated">
									<span class="item-count vertical-align">
										3.
									</span>
									<div class="alith_post_title_small">
										<h5>
											<a href="single.html">
												Our Industry isn’t coming back like yours is
											</a>
										</h5>
										<div class="entry-meta meta-1 font-small color-grey">
											<span class="post-on">
												14 May
											</span>
											<span class="hit-count has-dot">
												12k Views
											</span>
										</div>
									</div>
								</div>
								<div class="post-module-6-item d-flex wow fadeInUp animated">
									<span class="item-count vertical-align">
										4.
									</span>
									<div class="alith_post_title_small">
										<h5>
											<a href="single.html">
												The Shy Person’s Guide to Winning Friends and Influencing People
											</a>
										</h5>
										<div class="entry-meta meta-1 font-small color-grey">
											<span class="post-on">
												16 May
											</span>
											<span class="hit-count has-dot">
												11k Views
											</span>
										</div>
									</div>
								</div>
								<div class="post-module-6-item d-flex wow fadeInUp animated">
									<span class="item-count vertical-align">
										5.
									</span>
									<div class="alith_post_title_small">
										<h5>
											<a href="single.html">
												Greek Islanders are to be Nominated for Peace Prize
											</a>
										</h5>
										<div class="entry-meta meta-1 font-small color-grey">
											<span class="post-on">
												02 June
											</span>
											<span class="hit-count has-dot">
												15.6k Views
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--Recent Posts-->
						
						<!--Categories-->
						<div class="sidebar-widget widget-latest-comments mb-50 wow fadeInUp animated">
							<div class="widget-header widget-header-style-1 position-relative mb-30">
								<h5 class="widget-title mt-5 mb-30">
									Comments
								</h5>
							</div>
							<div class="post-block-list post-module-6 mt-50">
								<div class="post-module-6-item d-flex wow fadeInUp animated">
									<span class="item-count vertical-align">
										<i class="ti-comment">
										</i>
									</span>
									<div class="alith_post_title_small">
										<p class="font-medium mb-10">
											<a href="single.html">
												A writer is someone for whom writing is more difficult than it is for
												other people.
											</a>
										</p>
										<div class="entry-meta meta-1 font-small color-grey">
											<span class="post-on">
												On 15 April
											</span>
											<span class="hit-count has-dot">
												by Johan
											</span>
										</div>
									</div>
								</div>
								<div class="post-module-6-item d-flex wow fadeInUp animated">
									<span class="item-count vertical-align">
										<i class="ti-comment">
										</i>
									</span>
									<div class="alith_post_title_small">
										<p class="font-medium mb-10">
											<a href="single.html">
												Anybody who has survived his childhood has enough information about life
												to last him the rest of his days.
											</a>
										</p>
										<div class="entry-meta meta-1 font-small color-grey">
											<span class="post-on">
												On 05 May
											</span>
											<span class="hit-count has-dot">
												by Emma
											</span>
										</div>
									</div>
								</div>
								<div class="post-module-6-item d-flex wow fadeInUp animated">
									<span class="item-count vertical-align">
										<i class="ti-comment">
										</i>
									</span>
									<div class="alith_post_title_small">
										<p class="font-medium mb-10">
											<a href="single.html">
												A writer is someone for whom writing is more difficult than it is for
												other people.
											</a>
										</p>
										<div class="entry-meta meta-1 font-small color-grey">
											<span class="post-on">
												On 15 May
											</span>
											<span class="hit-count has-dot">
												by Steven
											</span>
										</div>
									</div>
								</div>
								<div class="post-module-6-item d-flex wow fadeInUp animated">
									<span class="item-count vertical-align">
										<i class="ti-comment">
										</i>
									</span>
									<div class="alith_post_title_small">
										<p class="font-medium mb-10">
											<a href="single.html">
												Alexe more gulped much garrulous a yikes earthworm wiped because goodness
												bet mongoose that along accommodatingly tortoise indecisively admirable
												but shark
											</a>
										</p>
										<div class="entry-meta meta-1 font-small color-grey">
											<span class="post-on">
												On 17 May
											</span>
											<span class="hit-count has-dot">
												by Mark
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--Recent Comment-->
					</div>
					<!--Left sidebar-->
					<div class="col-3-5 main-content pb-50 order-1 order-lg-2">
						<div class="single-content">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="single-header">
										<div class="entry-meta meta-0 mb-10 text-uppercase font-heading">
											<a href="category.html">
												<span class="post-in">
													World
												</span>
											</a>
											<a href="category.html">
												<span class="post-in">
													Travel
												</span>
											</a>
										</div>
										<h2 class="post-title">
											How to Have a 5-Star Hotel Experience in Paris Without Booking a Room
										</h2>
										<div class="mt-15 mb-50">
											<div class="entry-meta meta-1 font-medium color-grey">
												<span>
													<span>
														Font size
													</span>
													<i class="fonts-size-zoom-in ti-zoom-in mr-10 ">
													</i>
													<i class="fonts-size-zoom-out ti-zoom-out">
													</i>
												</span>
												<div class="vline-space d-inline-block">
												</div>
												<a class="single-print">
													<span>
														<i class="ti-printer mr-5">
														</i>
														Print
													</span>
												</a>
												<div class="vline-space d-inline-block">
												</div>
												<a href="#">
													<span>
														<i class="ti-email mr-5">
														</i>
														Email
													</span>
												</a>
												<div class="vline-space d-inline-block">
												</div>
												<a class="reading-mode" href="#">
													<span>
														<i class="ti-eye mr-5">
														</i>
														Reading mode
													</span>
												</a>
											</div>
										</div>
									</div>
									<div class="single-excerpt post-exerpt">
										<p>
											Headed to Paris? Even if you happen to don’t have the
											<a class="red-tooltip" href="#" data-toggle="tooltip" data-placement="top"
											title="The formula for calculating upside extension levels above a given price range is: Trough + (Price Range× Extension Ratio)">
												price range
											</a>
											to e-book a room at one of many metropolis’s luxurious five-star accommodations,you
											may nonetheless dip your toe into Parisian glitz and glamour by splurging
											on considered one of these on-property experiences.
										</p>
										<p>
											Seated in one of many leather-based
											<a class="red-tooltip" href="#" data-toggle="tooltip" data-placement="top"
											title="The United Nations warns of new risks to children and a rise in mental illness. And governments are noting the unintended consequences of restrictions">
												banquettes
											</a>
											beneath the romantic stained-glass dome designed by Gustave Eiffel,it’s
											unattainable to not have a pinch-me-I’m-in-Paris second.
										</p>
									</div>
									<div class="entry-main-content">
										<h2>
											Design is future
										</h2>
										<hr class="wp-block-separator is-style-wide">
										<p>
											Uninhibited carnally hired played in whimpered dear gorilla koala depending
											and much yikes off far quetzal goodness and from for grimaced goodness
											unaccountably and meadowlark near unblushingly crucial scallop tightly
											neurotic hungrily some and dear furiously this apart.
										</p>
										<p>
											Spluttered narrowly yikes left moth in yikes bowed this that grizzly much
											hello on spoon-fed that alas rethought much decently richly and wow against
											the frequent fluidly at formidable acceptably flapped besides and much
											circa far over the bucolically hey precarious goldfinch mastodon goodness
											gnashed a jellyfish and one however because.
										</p>
										<figure class="wp-block-gallery columns-3">
											<ul class="blocks-gallery-grid">
												<li class="blocks-gallery-item">
													<a href="#">
														<img class="border-radius-5" src="/static/assets/imgs/thumb-1.jpg" alt="">
													</a>
												</li>
												<li class="blocks-gallery-item">
													<a href="#">
														<img class="border-radius-5" src="/static/assets/imgs/thumb-6.jpg" alt="">
													</a>
												</li>
												<li class="blocks-gallery-item">
													<a href="#">
														<img class="border-radius-5" src="/static/assets/imgs/thumb-5.jpg" alt="">
													</a>
												</li>
											</ul>
										</figure>
										<p>
											Laconic overheard dear woodchuck wow this outrageously taut beaver hey
											hello far meadowlark imitatively egregiously hugged that yikes minimally
											unanimous pouted flirtatiously as beaver beheld above forward energetic
											across this jeepers beneficently cockily less a the raucously that magic
											upheld far so the this where crud then below after jeez enchanting drunkenly
											more much wow callously irrespective limpet.
										</p>
										<hr class="wp-block-separator is-style-dots">
										<p>
											Scallop or far crud plain remarkably far by thus far iguana lewd precociously
											and and less rattlesnake contrary caustic wow this near alas and next and
											pled the yikes articulate about as less cackled dalmatian in much less
											well jeering for the thanks blindly sentimental whimpered less across objectively
											fanciful grimaced wildly some wow and rose jeepers outgrew lugubrious luridly
											irrationally attractively dachshund.
										</p>
										<blockquote class="wp-block-quote is-style-large">
											<p>
												The advance of technology is based on making it fit in so that you don't
												really even notice it, so it's part of everyday life.
											</p>
											<cite>
												B. Johnso
											</cite>
										</blockquote>
										<h2>
											Computer inside
										</h2>
										<hr class="wp-block-separator is-style-wide">
										<div class="wp-block-image">
											<figure class="alignleft is-resized">
												<img class="border-radius-5" src="/static/assets/imgs/thumb-7.jpg">
												<figcaption>
													And far contrary smoked some contrary among stealthy
												</figcaption>
											</figure>
										</div>
										<p>
											Less lion goodness that euphemistically robin expeditiously bluebird smugly
											scratched far while thus cackled sheepishly rigid after due one assenting
											regarding censorious while occasional or this more crane went more as this
											less much amid overhung anathematic because much held one exuberantly sheep
											goodness so where rat wry well concomitantly.
										</p>
										<h5>
											What's next?
										</h5>
										<p>
											Pouted flirtatiously as beaver beheld above forward energetic across this
											jeepers beneficently cockily less a the raucously that magic upheld far
											so the this where crud then below after jeez enchanting drunkenly more
											much wow callously irrespective limpet.
										</p>
										<hr class="wp-block-separator is-style-dots">
										<p>
											Other yet this hazardous oh the until brave close towards stupidly euphemistically
											firefly boa some more underneath circa yet on as wow above ripe or blubbered
											one cobra bore ouch and this held ably one hence
										</p>
										<h2>
											Conclusion
										</h2>
										<hr class="wp-block-separator is-style-wide">
										<p>
											Alexe more gulped much garrulous a yikes earthworm wiped because goodness
											bet mongoose that along accommodatingly tortoise indecisively admirable
											but shark dear some and unwillingly before far vindictive less much this
											on more less flexed far woolly from following glanced resolute unlike far
											this alongside against icily beyond flabby accidental.
										</p>
										<p class="text-center">
											<a href="#">
												<img class="d-inline" src="/static/assets/imgs/ads-4.jpg" alt="">
											</a>
										</p>
									</div>
									<div class="entry-bottom mt-50 mb-30">
										<div class="tags">
											<a href="category.html" rel="tag">
												couple
											</a>
											<a href="category.html" rel="tag">
												in love
											</a>
											<a href="category.html" rel="tag">
												romantice
											</a>
										</div>
									</div>				
									</div>
									<!--Comments-->
									<div class="comments-area">
										<h3 class="mb-30">
											03 Comments
										</h3>
										<div class="comment-list">
											<div class="single-comment justify-content-between d-flex">
												<div class="user justify-content-between d-flex">
													<div class="thumb">
														<img src="/static/assets/imgs/author.jpg" alt="">
													</div>
													<div class="desc">
														<p class="comment">
															Vestibulum euismod,leo eget varius gravida,eros enim interdum urna,non
															rutrum enim ante quis metus. Duis porta ornare nulla ut bibendum
														</p>
														<div class="d-flex justify-content-between">
															<div class="d-flex align-items-center">
																<h5>
																	<a href="#">
																		Robert
																	</a>
																</h5>
																<p class="date">
																	December 4,2020 at 3:12 pm
																</p>
															</div>
															<div class="reply-btn">
																<a href="#" class="btn-reply text-uppercase">
																	reply
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="comment-list">
											<div class="single-comment justify-content-between d-flex">
												<div class="user justify-content-between d-flex">
													<div class="thumb">
														<img src="/static/assets/imgs/author-2.png" alt="">
													</div>
													<div class="desc">
														<p class="comment">
															Sed ac lorem felis. Ut in odio lorem. Quisque magna dui,maximus ut commodo
															sed,vestibulum ac nibh. Aenean a tortor in sem tempus auctor
														</p>
														<div class="d-flex justify-content-between">
															<div class="d-flex align-items-center">
																<h5>
																	<a href="#">
																		Maria
																	</a>
																</h5>
																<p class="date">
																	December 4,2020 at 3:12 pm
																</p>
															</div>
															<div class="reply-btn">
																<a href="#" class="btn-reply text-uppercase">
																	reply
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="comment-list">
											<div class="single-comment justify-content-between d-flex">
												<div class="user justify-content-between d-flex">
													<div class="thumb">
														<img src="/static/assets/imgs/author.jpg" alt="">
													</div>
													<div class="desc">
														<p class="comment">
															Donec in ullamcorper quam. Aenean vel nibh eu magna gravida fermentum.
															Praesent eget nisi pulvinar,sollicitudin eros vitae,tristique odio.
														</p>
														<div class="d-flex justify-content-between">
															<div class="d-flex align-items-center">
																<h5>
																	<a href="#">
																		Robert
																	</a>
																</h5>
																<p class="date">
																	December 4,2020 at 3:12 pm
																</p>
															</div>
															<div class="reply-btn">
																<a href="#" class="btn-reply text-uppercase">
																	reply
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!--comment form-->
									<div class="comment-form">
										<h3 class="mb-30">
											Leave a Reply
										</h3>
										<form class="form-contact comment_form" action="#" id="commentForm">
											<div class="row">
												<div class="col-12">
													<div class="form-group">
														<textarea class="form-control w-100" name="comment" id="comment" cols="30"
														rows="9" placeholder="Write Comment">
														</textarea>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<input class="form-control" name="name" id="name" type="text" placeholder="Name">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<input class="form-control" name="email" id="email" type="email" placeholder="Email">
													</div>
												</div>
												<div class="col-12">
													<div class="form-group">
														<input class="form-control" name="website" id="website" type="text" placeholder="Website">
													</div>
												</div>
											</div>
											<div class="form-group">
												<button type="submit" class="button button-contactForm">
													Post Comment
												</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-1-5 col-sm-6  right-sidbar order-3 order-lg-3">
						<figure class="post-thumb d-flex mb-0">
							<img src="/static/assets/imgs/thumb-4.jpg" alt="">
						</figure>
						<div class="sidebar-widget widget_tagcloud mb-30">
							<ul class="single-meta-infor font-medium">
								<li>
									<strong>
										Posted on:
									</strong>
									25 April 2020
								</li>
								<li>
									<strong>
										Author:
									</strong>
									<a href="single.html">
										Robert Ryan
									</a>
								</li>
								<li>
									<strong>
										Category:
									</strong>
									<a href="category.html">
										World
									</a>
									,
									<a href="category.html">
										Travel
									</a>
								</li>
								<li>
									<strong>
										Time reading:
									</strong>
									10 mins
								</li>
								<li>
									<strong>
										Hits:
									</strong>
									159k views
								</li>
							</ul>
							<div class="divider-1 mt-30 mb-30">
							</div>
							<div class="single-social-share clearfix font-medium">
								<p class="text-uppercase">
									Share this
								</p>
								<ul class="d-inline-block list-inline">
									<li class="list-inline-item">
										<a class="social-icon facebook-icon text-xs-center color-white" target="_blank"
										href="#">
											<i class="ti-facebook">
											</i>
										</a>
									</li>
									<li class="list-inline-item">
										<a class="social-icon twitter-icon text-xs-center color-white" target="_blank"
										href="#">
											<i class="ti-twitter-alt">
											</i>
										</a>
									</li>
									<li class="list-inline-item">
										<a class="social-icon pinterest-icon text-xs-center color-white" target="_blank"
										href="#">
											<i class="ti-pinterest">
											</i>
										</a>
									</li>
									<li class="list-inline-item">
										<a class="social-icon instagram-icon text-xs-center color-white" target="_blank"
										href="#">
											<i class="ti-instagram">
											</i>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="sidebar-widget widget_tagcloud wow fadeInUp animated">
							<div class="widget-header widget-header-style-1 position-relative mb-30">
								<h5 class="widget-title mt-5 mb-30">
									Tags
								</h5>
							</div>
							<div class="tagcloud mt-50">
								<a class="tag-cloud-link" href="category.html">
									beautiful
								</a>
								<a class="tag-cloud-link" href="category.html">
									New York
								</a>
								<a class="tag-cloud-link" href="category.html">
									droll
								</a>
								<a class="tag-cloud-link" href="category.html">
									intimate
								</a>
								<a class="tag-cloud-link" href="category.html">
									loving
								</a>
								<a class="tag-cloud-link" href="category.html">
									travel
								</a>
								<a class="tag-cloud-link" href="category.html">
									fighting
								</a>
							</div>
						</div>
						<!--End Tagcloud-->
						
						<!--Related posts-->
					</div>
					<!--End right sidebar-->
				</main>
				<footer>
					<div class="bottom row no-gutters">
						<div class="col-1-5">
						</div>
						<div class="col-4-5">
							<div class="divider-1">
							</div>
							<div class="pl-lg-110">
								<div class="row no-gutters">
									<div class="col-lg-4 col-md-6">
										<div class="sidebar-widget widget-archive wow fadeInUp animated">
											<div class="widget-header widget-header-style-1 position-relative mb-30">
												<h5 class="widget-title mt-5 mb-30">
													Archives
												</h5>
											</div>
											<ul class="mt-50">
												<li>
													<a href="category.html">
														January 2020
													</a>
													&nbsp;(11)
												</li>
												<li>
													<a href="category.html">
														February 2020
													</a>
													&nbsp;(10)
												</li>
												<li>
													<a href="category.html">
														March 2020
													</a>
													&nbsp;(28)
												</li>
												<li>
													<a href="category.html">
														April 2020
													</a>
													&nbsp;(20)
												</li>
												<li>
													<a href="category.html">
														May 2020
													</a>
													&nbsp;(52)
												</li>
												<li>
													<a href="category.html">
														June 2020
													</a>
													&nbsp;(23)
												</li>
											</ul>
										</div>
									</div>
									<div class="col-lg-4 col-md-6">
										<div class="sidebar-widget widget-twitter wow fadeInUp animated">
											<div class="widget-header widget-header-style-1 position-relative mb-30">
												<h5 class="widget-title mt-5 mb-30">
													Latest Tweets
												</h5>
											</div>
											<ul class="twitter-widget-inner mt-50">
												<li class="twitter-content">
													<span class="twitter-icon">
														<i class="ti-twitter-alt">
														</i>
													</span>
													<p>
														Buy Ultranews - HTML template on
														<a target="_blank" href="https://themeforest.net/item/ultranews-magazine-bootstrap-4-template/26563121"
														class="twitter-link">
															@ThemeForest
														</a>
														<span class="meta_date">
															Apr 9,2020
														</span>
													</p>
												</li>
												<li class="twitter-content">
													<span class="twitter-icon">
														<i class="ti-twitter-alt">
														</i>
													</span>
													<p>
														EmBe — All You Need to build a WordPress Magazine,News portal or Blog
														site
														<a target="_blank" href="https://themeforest.net/item/embe-flexible-magazine-wordpress-theme/24531103"
														class="twitter-link">
															@ThemeForest
														</a>
														<span class="meta_date">
															Jan 31,2020
														</span>
													</p>
												</li>
												<li class="twitter-content">
													<span class="twitter-icon">
														<i class="ti-twitter-alt">
														</i>
													</span>
													<p>
														Hewo - Modern Newspaper HTML Template
														<a target="_blank" href="https://themeforest.net/item/hewo-modern-newspaper-html-template/22069158"
														class="twitter-link">
															@ThemeForest
														</a>
														<span class="meta_date">
															Jan 31,2020
														</span>
													</p>
												</li>
											</ul>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="sidebar-widget widget_contact wow fadeInUp animated">
											<div class="widget-header widget-header-style-1 position-relative mb-30">
												<h5 class="widget-title mt-5 mb-30">
													Instagram
												</h5>
											</div>
											<ul class="alith-instagram-grid-widget alith-clr alith-row alith-gap-10">
												<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
													<a class="" target="_blank" href="#">
														<img class="border-radius-5" title="" alt="" src="/static/assets/imgs/thumb-1.jpg">
													</a>
												</li>
												<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
													<a class="" target="_blank" href="#">
														<img class="border-radius-5" title="" alt="" src="/static/assets/imgs/thumb-2.jpg">
													</a>
												</li>
												<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
													<a class="" target="_blank" href="#">
														<img class="border-radius-5" title="" alt="" src="/static/assets/imgs/thumb-3.jpg">
													</a>
												</li>
												<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
													<a class="" target="_blank" href="#">
														<img class="border-radius-5" title="" alt="" src="/static/assets/imgs/thumb-4.jpg">
													</a>
												</li>
												<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
													<a class="" target="_blank" href="#">
														<img class="border-radius-5" title="" alt="" src="/static/assets/imgs/thumb-5.jpg">
													</a>
												</li>
												<li class="wow fadeInUp alith-col-nr alith-clr alith-col-3 animated">
													<a class="" target="_blank" href="#">
														<img class="border-radius-5" title="" alt="" src="/static/assets/imgs/thumb-6.jpg">
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div class="pl-md-50">
									<div class="row no-gutters">
										<div class="divider-1">
										</div>
										<!-- Footer Start -->
										<div class="footer-bottom-area">
											<div class="pt-30 pb-30">
												<div class="row no-gutters align-items-center justify-content-between wow fadeInUp animated">
													<div class="col-lg-6 col-md-12">
														<div class="footer-copy-right">
															<p class="font-medium">
																© 2020,WritePress | All rights reserved | Design by
																<a href="http://www.bootstraphtml.com" target="_blank">
																	AliThemes
																</a>
															</p>
														</div>
													</div>
													<div class="col-lg-6  col-md-12">
														<div class="footer-menu float-lg-right mt-lg-0 mt-3">
															<ul class="font-medium">
																<li>
																	<a href="#">
																		Terms of use
																	</a>
																</li>
																<li>
																	<a href="#">
																		Privacy Policy
																	</a>
																</li>
																<li>
																	<a href="#">
																		Contact
																	</a>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</footer>
			</div>
			<!-- Main Wrap End-->
		</div>
		<!-- Single Body Wrap End-->
		<!-- Vendor JS-->
		<script src="/static/assets/js/vendor/modernizr-3.5.0.min.js">
		</script>
		<script src="/static/assets/js/vendor/jquery-1.12.4.min.js">
		</script>
		<script src="/static/assets/js/vendor/popper.min.js">
		</script>
		<script src="/static/assets/js/vendor/bootstrap.min.js">
		</script>
		<script src="/static/assets/js/vendor/jquery.slicknav.js">
		</script>
		<script src="/static/assets/js/vendor/owl.carousel.min.js">
		</script>
		<script src="/static/assets/js/vendor/slick.min.js">
		</script>
		<script src="/static/assets/js/vendor/wow.min.js">
		</script>
		<script src="/static/assets/js/vendor/animated.headline.js">
		</script>
		<script src="/static/assets/js/vendor/jquery.magnific-popup.js">
		</script>
		<script src="/static/assets/js/vendor/jquery.ticker.js">
		</script>
		<script src="/static/assets/js/vendor/jquery.vticker-min.js">
		</script>
		<script src="/static/assets/js/vendor/jquery.scrollUp.min.js">
		</script>
		<script src="/static/assets/js/vendor/jquery.nice-select.min.js">
		</script>
		<script src="/static/assets/js/vendor/jquery.sticky.js">
		</script>
		<script src="/static/assets/js/vendor/perfect-scrollbar.js">
		</script>
		<script src="/static/assets/js/vendor/waypoints.min.js">
		</script>
		<script src="/static/assets/js/vendor/jquery.counterup.min.js">
		</script>
		<script src="/static/assets/js/vendor/jquery.theia.sticky.js">
		</script>
		<script src="/static/assets/js/vendor/printThis.js">
		</script>
		<!-- UltraNews JS -->
		<script src="/static/assets/js/main.js">
		</script>
		<script src="/node_modules/particles.js/particles.js">
		</script>

<script>
	let originalTitle = document.title;

	document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'hidden') {
        document.title = '"w(ﾟДﾟ)w 不要走！再看看嘛！';
    } else {
        document.title = originalTitle;
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    particlesJS('particles-js', {
        particles: {
            number: { 
                value: 80,  // 桌面端粒子数
                density: { enable: true, value_area: 800 }
            },
            color: { value: "#4a90e2" },  // 匹配主题蓝色
            shape: { type: "circle" },
            opacity: { value: 0.5 },
            size: { value: 3, random: true },
            line_linked: {
                enable: true,
                distance: 150,
                color: "#ffffff",
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 2,
                direction: "none",
                out_mode: "out"
            }
        },
        interactivity: {
            detect_on: "canvas",
            events: {
                onhover: { enable: true, mode: "grab" },  // 悬停抓取效果
                onclick: { enable: true, mode: "push" },   // 点击生成新粒子
                resize: true
            }
        },
        retina_detect: true
    });
    
    // 移动端优化
    if(window.innerWidth < 768) {
        window.pJSDom[0].pJS.particles.number.value = 40;
    }
});
</script>
	</body>

</html>