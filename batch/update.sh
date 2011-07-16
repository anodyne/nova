#!/bin/bash

old="1.2/master"
new="1.2/develop"

git diff $old..$new --name-status > CHANGED_FILES

git log $old..$new --pretty=format:"* %s" > CHANGELOG

echo "Updates complete."