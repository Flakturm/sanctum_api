#!/bin/sh

sudo chmod -R 777 storage/
sudo chmod -R 777 bootstrap/cache/
sudo -u webapp php artisan storage:link