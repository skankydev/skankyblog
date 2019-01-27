@echo off

if "%1"=="init" (
	vendor\bin\phpunit --generate-configuration 
) else if "%1"=="version" (
	vendor\bin\phpunit --version
) else if "%1"=="coverage" (
	vendor\bin\phpunit --coverage-html=public\coverage --configuration phpunit.xml --color=always 
) else if "%1"=="-v" (
	vendor\bin\phpunit --configuration phpunit.xml --color=always --verbose 
) else if "%1"=="-fs" (
	echo file: %2.php
	vendor\bin\phpunit  tests\SkankyTest\TestCase\%2 --color=always --verbose 
) else (
	vendor\bin\phpunit --configuration phpunit.xml --color=always 
)

echo.
