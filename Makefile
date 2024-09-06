init:
	./vendor/bin/sail up -d
	./vendor/bin/sail artisan migrate
	./vendor/bin/sail bash

down:
	./vendor/bin/sail down

bash:
	./vendor/bin/sail bash

sail-info:
	./vendor/bin/sail


