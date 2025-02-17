#!/bin/sh

USERNAME=$(whoami)
USERID=$(id -u)
USERGROUP=$(id -gn)
USERGROUPID=$(id -g)

ENVIRONMENT_FILE=".env"

sed -i \
    -e "s/USER_NAME=.*/USER_NAME='$USERNAME'/" \
    -e "s/USER_ID=.*/USER_ID='$USERID'/" \
    -e "s/GROUP_NAME=.*/GROUP_NAME='$USERGROUP'/" \
    -e "s/GROUP_ID=.*/GROUP_ID='$USERGROUPID'/" \
    "$ENVIRONMENT_FILE"

echo "Variables replaced successfully in $ENVIRONMENT_FILE"
