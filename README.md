This is a modified laravel index.php file that allows us to load Wordpress and route requests to either Wordpress or Laravel, depending on the requested url.

This is a rough and ready version to show the idea behind this integration.

Simply copy Wordpress into the Laravel public folder, then edit your front controller (index.php) to do something like this.

You could also drop the index.php file but that if this file changes for either Wordpress or Laravel in the future, you will mostly likely have issues.
