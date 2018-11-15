#!/bin/sh

APPPATH="/home/website/public_html"

cd "${APPPATH}/tests/codeception"

APPALIAS=`cat ${APPPATH}/.env | grep APP_ALIAS | cut -d'=' -f2 | cut -d',' -f1` 

echo "Alias: $APPALIAS"

./codecept run tests/acceptance/AirAromaCest.php --report -q --tap --json --fail-fast --env $APPALIAS $1 | sed -r "s/\x1B\[([0-9]{1,2}(;[0-9]{1,2})?)?[m|K]//g"
