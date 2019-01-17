install:
	composer install
	npm install
	gulp

serve:
	php -S 127.0.0.1:8000 -t public

asset-watch:
	gulp
	gulp watch

import:
	bin/console app:feed:import
