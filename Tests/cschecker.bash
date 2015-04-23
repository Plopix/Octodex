#!/bin/bash

PHP="env php"

if [ -z "$1" ]; then
    SRC="src/"
else
    SRC="$1"
fi

echo "******** Mess Detector ********"
$PHP ./vendor/bin/phpmd $SRC text cleancode,codesize,controversial,design,naming,unusedcode

echo "******** Copy/Paste Detector ********"
$PHP ./vendor/bin/phpcpd $SRC

echo "******** CodeSniffer ********"
$PHP ./vendor/bin/phpcs $SRC --standard=./vendor/novactive/phpcs-novastandards/src/NovaPSR2/ruleset.xml

echo "Done."

exit 0;