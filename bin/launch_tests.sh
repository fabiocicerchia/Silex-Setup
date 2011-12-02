#!/bin/bash

CURRENT_PATH=`dirname $0`
phpunit --configuration "$CURRENT_PATH/../src/test_suite.xml"
