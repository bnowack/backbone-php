
BEHAT_BIN = ../bin/behat
PHPSPEC_BIN = ../bin/phpspec
SPEC_REPORT_DIR = 

help:
	@echo "Recommended Targets:"
	@echo "  make behat-active ............ Run Behat features from 'active' suite"
	@echo "  make behat-build ............. Run Behat features from 'build' suite and create Behat HTML report"
	@echo "  make spec-build .............  Run all PHPSpec files"
	@echo "  make spec-report ............. Run all PHPSpec files and create HTML and coverage reports"

	@echo "  make bdd-build ............... Run all Behat features and PHPSpec files"
	@echo "  make bdd-report .............. Run all Behat features and PHPSpec files and create Reports"

	@echo "  make www-start ............... Start test web server"

separator:
	@echo "-----------------------------------------------------------------------"

behat-active: separator
	@echo "Running Behat features from 'active' suite"
	@make separator 
	@cd test && $(BEHAT_BIN) --suite=active -f pretty && cd ../

behat-build: separator
	@echo "Running Behat features from 'build' suite and creating HTML report"
	@make separator 
	@cd test && $(BEHAT_BIN) --suite=build -f pretty -f html && cd ../

spec-build: separator
	@echo "Running all PHPSpec files"
	@make separator 
	@cd test && $(PHPSPEC_BIN) run && cd ../

spec-report: separator
	@echo "Running all PHPSpec files and creating HTML and coverage reports"
	@make separator 
	@cd test && $(PHPSPEC_BIN) run --format html > reports/phpspec/phpspec.html && cd ../
	@make spec-build
	
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