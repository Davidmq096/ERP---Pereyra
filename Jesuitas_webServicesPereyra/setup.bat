del /Q /S .\var\cache\
rmdir /Q /S .\var\cache\.
del /Q /S .\src\AppBundle\Entity\*.php
del /Q /S .\src\AppBundle\Resources\config\doctrine\*.xml
php bin/console doctrine:mapping:import --force AppBundle xml
php bin/console doctrine:generate:entities --no-backup AppBundle
php bin/console cache:clear --env=prod --no-debug
echo Done
pause