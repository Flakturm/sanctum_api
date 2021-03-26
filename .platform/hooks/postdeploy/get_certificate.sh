#!/bin/sh

sudo certbot certonly -n -d api.sample.com --nginx --agree-tos --email admin@andy-web-dev.com

sudo systemctl restart nginx.service