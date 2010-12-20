#!/bin/bash

old="support-1.2"
new="1.x"

git diff $old..$new --name-status > CHANGED_FILES

git log $old..$new --pretty=format:"* %s" > CHANGELOG

echo "Updates complete."