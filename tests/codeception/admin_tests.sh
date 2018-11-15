#!/bin/sh

APPPATH="/home/website/public_html"

cd "${APPPATH}/tests/codeception"

APPALIAS=`cat ${APPPATH}/.env | grep APP_ALIAS | cut -d'=' -f2 | cut -d',' -f1` 

echo "Alias: $APPALIAS"

./codecept run tests/acceptance/AirAromaAdminCest.php -q --report --json --env $APPALIAS 
