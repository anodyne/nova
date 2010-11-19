# Generating a list of changed files

This command will generate a list of files that have been modified between the two versions.

<code>git diff --name-status [commit of the new version] [commit of the old version] > CHANGED_FILES</code>

<code>git diff [old version branch]..[new version branch] --name-status > CHANGED_FILES</code>
<code>git diff support-1.1..master --name-status > CHANGED_FILES</code>

# Generating a changelog

This command will generate a changelog of the commits and all the changes that have been made.

<code>git log [old version branch]..[new version branch] --pretty=format:"* %s" > CHANGELOG</code>
<code>git log support-1.1..master --pretty=format:"* %s" > CHANGELOG</code>