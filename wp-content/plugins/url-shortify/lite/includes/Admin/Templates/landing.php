<?php

$features = array(
	array(
		'title' => 'Easy Configuration',
		'desc' => 'Easily set up your Link Redirects (301, 302, and 307) and all your Link options'
	),

	array(
		'title' => 'Create Short Links',
		'desc' => 'Create short links that your visitors will easily be able to memorize and that you can fit into Tweets, Facebook posts, and more'
	),

	array(
		'title' => 'Faster Than Any External Shortener',
		'desc' => 'External shorteners can be slow when redirecting your visitors. That damages customer satisfaction and slows down your site. Our plugin is the fastest way to link!'
	),

	array(
		'title' => 'Editable Destination URL',
		'desc' => 'Update destination URL of branded links anytime.'
	),

	array(
		'title' => 'Search Links',
		'desc' => 'Change settings to make your short links just the way you want them. Make sure your links reflect your brand and stick in the memory!'
	),

	array(
		'title' => 'Fully Customizable',
		'desc' => 'Find a specific branded link using an inbuilt search tool.'
	),

	array(
		'title' => 'Hide Affiliate Links',
		'desc' => 'URL Shortify is a great way to hide affiliate links. This is a perfect way to ensure that people don’t bypass your links and cost you money!'
	),

	array(
		'title' => 'Parameters Forwarding',
		'desc' => 'Automatically forward parameters to the destination URL by appending them to branded links.'
	),

	array(
		'title' => 'Link Prefix',
		'desc' => 'Using link prefix you can set the prefix for all links. Once you set the link prefix, prefix will be added to short links generated after that.'
	),

	array(
		'title' => 'Link Analytics. Track Each And Every User Who Click A Link',
		'desc' => 'Full analytics for individual links and link groups, including geo 🇺🇸 🇬🇧 🇦🇺 🇫🇷 🇮🇳 🇩🇪 and device information, referrers, browser, IP etc... Visualize popular click metrics from audiences like top countries, devices, frequent times, and more..',
        'is_pro' => true,
	),

	array(
		'title' => 'One Click Share',
		'desc' => 'Copy your shortened URL right from the dashboard and share it instantly.',
        'is_pro' => true,
	),

	array(
		'title' => 'Cloak Links',
		'desc' => 'Link cloaking is the process of disguising the affiliate link URL provided by an affiliate program to obfuscate the affiliate ID and make the link shorter. This protects your affiliate commissions by making the affiliate ID less visible. At the same time, it makes the link more visually appealing to visitors.',
		'is_pro' => true,
	),

	array(
		'title' => 'Customize Slug Character Count',
		'desc' => 'By default URL slug is of 4 characters. With URL Shortify PRO, you can customize it according to your need',
		'is_pro' => true,
	),

	array(
		'title' => 'Expired Short Links',
		'desc' => 'Decide when a link will be automatically turned off by the system.',
		'is_pro' => true,
	),

	array(
		'title' => 'Password Protected Links',
		'desc' => 'You can also protect your short links with the password with this PRO ONLY feature',
		'is_pro' => true,
	),

	array(
		'title' => 'QR Codes Of Short Links',
		'desc' => 'Generate QR codes for your branded links',
		'is_pro' => true,
    ),

    array(
		'title' => 'Exclude IP Addresses',
		'desc' => 'Stop tracking clicks that come from specific IP addresses. Add those IP addresses into Excluded IP addresses list.',
		'is_pro' => true,
    ),

    array(
        'title' => 'Bookmarklet',
        'desc' => 'No need to come to URL Shortify dashboard or Chrome or Firefox extension to generate short link. Using Bookmarklet, one can create short link in a single click for any webpage they are visiting.',
        'is_pro' => true,
	),

    array(
        'title' => 'Custom Domains',
        'desc' => 'Access short links from multiple custom domains along with your main site.',
        'is_pro' => true,
	),

    array(
        'title' => 'Access Control',
        'desc' => 'Manage roles who can create & manage branded short links, groups and manage settings.',
        'is_pro' => true,
	),

    array(
        'title' => 'Anonymise Clicks Data',
        'desc' => 'Anonymise all click data will anonymise all personal click data like IP address, User-Agents, Referrers, Country, OS, Device, and more without impacting clicks count.',
        'is_pro' => true,
	),

    array(
        'title' => 'Convert Your Site Into URL Shortener Service',
        'desc' => 'Enable public-facing URL Shortener form using which anyone can generate short URL.',
        'is_pro' => true,
	),

    array(
        'title' => 'UTM Builder & UTM Presets',
        'desc' => 'Add UTM parameters to destination URLs to get branded link metrics in Google Analytics. Save preset templates for UTM parameters and save time when creating branded links.',
        'is_pro' => true,
	),
);

?>

<div class="wrap">
	<!-- Feature Section -->
	<div class="bg-white">
		<div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-16 lg:px-8">
			<div class="max-w-3xl mx-auto text-center">
				<h2 class="text-4xl font-extrabold leading-10 tracking-tight text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
					Welcome to
					<br class="xl:hidden"/>
					<span class="text-indigo-600">URL Shortify</span>
				</h2>
				<p class="mt-4 text-lg text-gray-500">Simple, Powerful and Easy URL Shortener Plugin For WordPress. Convert your long, ugly links into clean, memorable, shareable links</p>
			</div>

			<dl class="mt-12 space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 lg:grid-cols-4 lg:gap-x-8">
				<?php foreach ($features as $feature) { ?>
					<div class="relative">
						<dt>

							<svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
								<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
							</svg>
							<p class="ml-9 text-lg leading-6 font-medium text-gray-900"><?php echo $feature['title']; ?>
                            </p>
						</dt>
						<dd class="mt-2 ml-9 text-base text-gray-500"><?php echo $feature['desc']; ?></dd>
					</div>
				<?php } ?>
			</dl>

        </div>
	</div>


    <!-- Pricing Section -->
    <?php

    if ( \Kaizen_Coders\Url_Shortify\Helper::can_show_promotion() ) {
	    include_once 'pricing.php';
    }

    ?>


</div>
