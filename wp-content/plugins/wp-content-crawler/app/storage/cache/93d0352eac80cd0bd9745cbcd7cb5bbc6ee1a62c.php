

<?php

use WPCCrawler\Services\UserPrefsService;

$prefs = (new UserPrefsService())->getUserPreferences($pageType ?? null, $siteId ?? null) ?? '{}';

?>

<div id="user-prefs" class="hidden" data-prefs='<?php echo $prefs; ?>'></div><?php /**PATH D:\Xampp\htdocs\Docker\docker-dental\wp_data\wp-content\plugins\wp-content-crawler\app\views/partials/user-preferences.blade.php ENDPATH**/ ?>