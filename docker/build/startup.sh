#!/usr/bin/env sh

if [ -f /__initialized ]; then
    echo "Container initialized";
    echo "To force init script to run again, rm -rf /_initialized and restart the container.";
else

    # We don't require ssh key on docker container, as we don't access private repositories
    # If tou need to pull or clone private repos, the container's ssh key can be
    # copied to the /var/www volume or displayed on the screen for convenience

    # Show ssh key
#    mkdir /var/www/.ssh/
#    cp /root/.ssh/id_rsa.pub /var/www/docker/docker-rsa.pub
#    cp /root/.ssh/id_rsa /var/www/.ssh/id_rsa
#    cp /root/.ssh/id_rsa.pub /var/www/.ssh/id_rsa.pub

#    echo "To allow composer to install dependencies from private repositories, \
#please add the following \
#RSA Key to your BitBucket account in Profile > BitBucket Settings > SSH Keys;"
#
#    echo "--------------- RSA Key ------------------------------"
#    cat /root/.ssh/id_rsa.pub
#    echo "--------------- RSA Key ------------------------------"
#
#    sleep 10

    CTIME=`date +"%F %T"`
    echo  "$CTIME" >> /__initialized

fi

# Composer install dependencies
cd /var/www/ && composer install

if [ ! -f /var/www/.env ]; then
# TODO on production we should use different .env source instead of file
    cp /var/www/.env.example /var/www/.env
    php artisan cache:clear
    php artisan key:generate

    # TODO install voyager and create voyager user
    #php artisan voyager:install
    #php artisan voyager:admin admin@localhost.com --create
fi

# Run migrations
php artisan migrate

# Start services
/usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf


