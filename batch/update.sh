#!/bin/bash

old="master"
new="support-1.2"

git diff $old..$new --name-status > CHANGED_FILES

git log $old..$new --pretty=format:"* %s" > CHANGELOG

echo "Updates complete."