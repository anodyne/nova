Oil utility

The Oil utility is a special package command can be used in several ways to facilitate quick development, help with testing your application and for running Tasks.

Package

Packages can be installed and downloaded manually but with the help of the package command it can work much quicker. It does this by looking for packages within a list of sources defined in fuel/core/package.php and like any other config file can be edited there or copied to the fuel/app/config folder.

Oil is smart, so it will check to see if you have Git installed on your computer before it does anything with the package command. If you do have Git installed Oil will install a package as a Git repository instead of directly downloading the files, meaning updates, new releases and tracking custom changes to packages could not be easier.

Install

$ php oil package install test-package
Downloading package: git://github.com/philsturgeon/fuel-test-package.git
remote: Counting objects: 13, done.
remote: Compressing objects: 100% (11/11), done.
remote: Total 13 (delta 3), reused 0 (delta 0)
Receiving objects: 100% (13/13), 10.85 KiB, done.
Resolving deltas: 100% (3/3), done.

Cloning into /Users/phil/Sites/fuel/fuel/packages/test-package...
If Git is not installed, or the --direct flag is provided then a ZIP file of the package will be downloaded and unzipped to fuel/packages/packagename.

$ php oil package install test-package --direct
Downloading package: http://github.com/philsturgeon/fuel-test-package/zipball/master
	DOCROOT/fuel/packages/test-package/LICENSE.txt
	DOCROOT/fuel/packages/test-package/README
	DOCROOT/fuel/packages/test-package/classes/association.php
	DOCROOT/fuel/packages/test-package/classes/belongsto.php
	DOCROOT/fuel/packages/test-package/classes/exception.php
	DOCROOT/fuel/packages/test-package/classes/hasmany.php
	DOCROOT/fuel/packages/test-package/classes/hasone.php
	DOCROOT/fuel/packages/test-package/classes/model.php
Un-install

$ php oil package uninstall test-package
Uninstalling package "test-package"
Note: Unlike install there is no difference here if Git is installed, it will delete all the same.

Update

Coming soon...