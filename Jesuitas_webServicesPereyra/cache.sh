#!/bin/sh
unameOut="$(uname -s)"
case "${unameOut}" in
    Linux*)     machine=Linux;;
    Darwin*)    machine=Mac;;
    CYGWIN*)    machine=Cygwin;;
    MINGW*)     machine=MinGw;;
    *)          machine="UNKNOWN:${unameOut}"
esac
echo ${machine}
if [ "$(uname)" == "Darwin" ]; then
    # Do something under Mac OS X platform    
    root_dir=$PWD;    
elif [ "$(expr substr $(uname -s) 1 5)" == "Linux" ]; then
    # Do something under GNU/Linux platform
    root_dir=$PWD;
elif [ "$(expr substr $(uname -s) 1 10)" == "MINGW32_NT" ]; then
    # Do something under 32 bits Windows NT platform
    root_dir=$chdir;
elif [ "$(expr substr $(uname -s) 1 10)" == "MINGW64_NT" ]; then
    # Do something under 64 bits Windows NT platform
    root_dir=$chdir;
fi
rm -rf $root_dir+"/var/cache"
php bin/console cache:clear --env=prod --no-debug
if [ "$(uname)" == "Darwin" ]; then
    chmod -R 777 "$root_dir" 
elif [ "$(expr substr $(uname -s) 1 5)" == "Linux" ]; then
    chmod -R 777 "$root_dir"
fi
echo "Todo chido!"
exit