#!/bin/bash

echo -e "# Class API\n"
echo -e "[Class API (https://github.com/ISSKJ/minph/tree/master/framework/doc/en/CLASS_API.md)](https://github.com/ISSKJ/minph/tree/master/framework/doc/en/CLASS_API.md)\n"

for file in `find doc/Minph/ -name "*.md"`
do
    echo -e "* [$file](https://github.com/ISSKJ/minph/tree/master/framework/$file)\n"
done

echo ""
echo ""
