@echo off


if "%1"=="init" (
	vendor\bin\phpunit --generate-configuration 
) else if "%1"=="version" (
	vendor\bin\phpunit --version
) else if "%1"=="coverage" (
	echo coverage
	vendor\bin\phpunit --coverage-html=public\coverage --configuration phpunit.xml --color=always 
) else if "%1"=="-v" (
	echo verbos
	vendor\bin\phpunit --configuration phpunit.xml --color=always --verbose 
) else (
	vendor\bin\phpunit --configuration phpunit.xml --color=always 
)

echo.
