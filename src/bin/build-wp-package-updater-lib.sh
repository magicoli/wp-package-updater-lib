#!/bin/bash

ignore="vendor/*,node_modules/*,build/plugin-update-checker,build/wp-package-updater,sources/,*.asset.php,*/*/*.asset.php,*.map,includes/fullcalendar/fullcalendar.*"

version=$(git describe --tags | sed "s/^v//")

changes=$(git update-index --refresh)
if [ "$changes" ]
then
  echo "updates $changes"
else
  echo "no updates"
fi

echo "# version $version"
sed -i -E -e "s/(define[[:blank:]]*\(.*_VERSION',[[:blank:]]*').* *\);/\\1$version');/" \
-e "s/^([[:blank:]\*;]*Version[[:blank:]]*:[[:blank:]]*).*/\\1$version'/" \
build/package-updater.php
# sed -i -E -e "s/(define[[:blank:]]*\(.*_VERSION',[[:blank:]]*').* *\);/\\1$currentversion'$time);/" build/package-updater.php

commitsubject=$(git log -1 --pretty=%B)
commitversion=$(git log -1 --pretty=%B | grep -E "^v([0-9]+\.)+[0-9]+" | cut -d " " -f 1 | sed "s/^v//")
PGM=$(basename $0)
minphp=$(minphp 2>/dev/null)
[ "$minphp" =  "" ] && minphp=$(grep "Requires PHP:" readme.txt | sed "s/.*PHP: *//")
[ "$minphp" =  "" ] && read -p "Test minimum PHP: " minphp
php=$(minphp -x || which php)
[ $php ] || exit $?

trap 'previous_command=$this_command; this_command=$BASH_COMMAND' DEBUG
trap 'ret=$?; [ $ret -ne 0 ] && echo "$PGM: $previous_command failed (error $ret)" && exit $ret || echo "$PGM: success"' EXIT

echo "# check compatibility with minimum PHP version required $minphp"
phpcs -p . --standard=PHPCompatibility --ignore=$ignore,*js,*css --runtime-set testVersion ${minphp}- \
&& echo "# $minphp composer update" \
&& $php /usr/local/bin/composer update \
&& echo "# normalize code" \
&& { phpcbf --standard=WordPress --ignore=$ignore ./ || phpcbf --standard=WordPress --ignore=$ignore ./ ; }

if [ "$commitversion" != "" -a "$commitversion" != "$version" ]
then
  read -p "Ammend commit and tag $commitversion? [y/N] " resp
  if [ "$resp" = "yes" -o "$resp" = "y" -o "$resp" = "Y" ]
  then
    sed -i -E -e "s/(define[[:blank:]]*\(.*_VERSION',[[:blank:]]*').* *\);/\\1$commitversion');/" \
    -e "s/^([[:blank:]\*;]*Version[[:blank:]]*:[[:blank:]]*).*/\\1$commitversion'/" \
    build/package-updater.php
    git add -A
    git commit --amend -m "$commitsubject"
    echo tagging $commitversion >&2
    git tag v$commitversion -m "$(git log -1 --pretty=%B)"
  fi
fi
