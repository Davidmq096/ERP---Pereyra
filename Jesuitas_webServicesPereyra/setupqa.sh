rm -rf "/var/www/html/inceptioQA/Jesuitas_webServices/src/AppBundle/Entity"
rm -rf "/var/www/html/inceptioQA/Jesuitas_webServices/src/AppBundle/Resources/config/doctrine"
rm -rf "/var/www/html/inceptioQA/Jesuitas_webServices/var/cache"
php bin/console doctrine:mapping:import --force AppBundle xml
php bin/console doctrine:generate:entities AppBundle --no-backup
php bin/console cache:clear --env=prod --no-debug
chmod -R 777 "/var/www/html/inceptioQA/Jesuitas_webServices"
