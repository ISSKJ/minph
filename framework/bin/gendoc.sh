#!/bin/bash

srcDirectory=
outDirectory=

function _do_generate()
{
    for file in `find $srcDirectory -name "*.php"`
    do
        dirname=$(dirname $file)
        dirname="${dirname##*src/}"
        filename=$(basename $file)
        filename="${filename%.*}"
        mkdir -p $outDirectory/$dirname/
        tc.make_doc_class $file > $outDirectory/$dirname/$filename.md
    done
}

function _do_usage()
{
    echo "$0 -d [src directory] -o [out directory]"
}


while getopts ":d:o:" opt; do
    case $opt in
        d)
            srcDirectory=$OPTARG
            ;;
        o)
            outDirectory=$OPTARG
            ;;
        :)
            _do_usage
            ;;
    esac
done

if [ -z "$srcDirectory" ]; then
    _do_usage
    exit 0
fi
if [ -z "$outDirectory" ]; then
    _do_usage
    exit 0
fi

_do_generate
