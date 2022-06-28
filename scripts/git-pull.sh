#!/bin/bash

EXPECTED_ARGS=1
E_BADARGS=65

if [ $# -ne $EXPECTED_ARGS ]
then
echo "Usage: $0 branch"
  exit $E_BADARGS
fi

git reset --hard
git clean -f -d
git pull origin $1

