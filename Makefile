
BEHAT_BIN = ../bin/behat
PHPSPEC_BIN = bin/phpspec
SPEC_REPORT_DIR = 

help:
	@echo "Recommended Targets:"
	@echo "  make behat-active ............ Run Behat features from 'active' suite"
	@echo "  make behat-build ............. Run Behat features from 'build' suite and create Behat HTML report"
	@echo "  make spec-build .............  Run all PHPSpec files"
	@echo "  make spec-report ............. Run all PHPSpec files and create HTML and coverage reports"
	@echo "  make spec-run    ............. Run specified PHPSpec files (or dir) append spec='path/to/spec'"

	@echo "  make bdd-build ............... Run all Behat features and PHPSpec files"
	@echo "  make bdd-report .............. Run all Behat features and PHPSpec files and create Reports"

	@echo "  make www-start ............... Start test web server"
	@echo "  make scss-start .............. Start SCSS watcher"
	@echo "  make karma-start ............. Start Karma Test Runner"
	@echo "  make karma-run ............... Test JavaScript Specs"

separator:
	@echo "-------------------------------------------------------------------------------"

behat-active: separator
	@echo "Running Behat features from 'active' suite"
	@make separator 
	@cd test && $(BEHAT_BIN) --suite=active -f pretty && cd ../

behat-build: separator
	@echo "Running Behat features from 'build' suite and creating HTML and JSON reports"
	@make separator 
	@cd test && $(BEHAT_BIN) --suite=build -f pretty -f html -f cucumber_json && cd ../

spec-build: separator
	@echo "Running all PHPSpec files"
	@make separator 
	$(PHPSPEC_BIN) -c=test/phpspec/phpspec.yml run

spec-report: separator
	@echo "Running all PHPSpec files and creating HTML and coverage reports"
	@make separator 
	$(PHPSPEC_BIN) -c=test/phpspec/phpspec.yml run --format html > test/reports/php-specs/phpspec.html
	@make spec-build

spec-run: separator
	@echo "Running spec file $(spec)"
	@make separator 
	$(PHPSPEC_BIN) -c=test/phpspec/phpspec.yml run $(spec)
	
bdd-build:
	@make behat-build --ignore-errors
	@make spec-build --ignore-errors
	@make separator 
	
bdd-report:
	@make behat-build --ignore-errors
	@make spec-report --ignore-errors
	@make separator 

www-start:
	php -S localhost:8889 -t ./ test/router.php

scss-start:
	php vendor/bnowack/scss-watcher/scripts/watch.php --path=src

karma-start:
	@make separator 
	karma start karma.conf.js

karma-run:
	@make separator 
	karma run
