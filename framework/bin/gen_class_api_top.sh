#!/bin/bash

echo -e "# Class API\n"

for file in `find doc/Minph/ -name "*.md"`
do
    echo -e "* [$file](https://github.com/ISSKJ/minph/tree/master/framework/$file)\n"
done

echo ""
echo ""
