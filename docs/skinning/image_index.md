# The Image Index

In Nova 3, the image index is simply an array of the images used throughout the system. Nova stores the master list inside the Nova core, but also looks for a copy of that list in each skin it loads.

So why would we create this index?

Skin developers now have the freedom to not only change the images they're using, but to also change the names of the images. If you want to override the `feed.png` image in Nova, but don't want to rename your image, you can simply add an array item to your skin's image index to point to an image called `rss-16x16.jpg`. Boom! Nova uses your JPG image even though the core says to look for a completely different file name.