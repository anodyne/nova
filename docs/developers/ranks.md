# Ranks

## The New Format

Nova 3 uses a brand new format for ranks that gives game masters significantly more control over their ranks than they've ever had before. The single biggest change with ranks is that a lot of the ranks now consist of two separate images: a base and a pip. Doing this saves a significant amount of space (for example, the DS9 genre used to have 363 images, now, it only has 140) and allows us to ship a wider range of rank colors (for some genres) and more variety with pips (for some genres). In the end, this gives game masters the flexibility out-of-the-box of being able to set up new ranks with a few clicks rather than the old way of adding images and struggling through the process of manage ranks.

Nova 3 ranks are broken up in to 3 distinct components:

### Ranks

The ranks table in Nova 3 looks nothing like the ranks table in previous versions. Essentially, the ranks table does nothing more than store information that gets pulled from other tables. Each rank consists of an info ID, a set ID, a base image, and a pip image. All of these pieces are ultimately pulled together to show a rank image.

### Rank Info

In previous versions of Nova, the basic information about a rank (name, short name, order, etc.) was duplicated hundreds of times in the ranks table. If a game master wanted to change one of the rank names, they'd have to update it in several different places. This way of doing this was clumsy and prone to cause problems. Nova 3 stores rank information separately from the ranks and allows game masters to pick the rank information that's associated with any given rank, providing ultimate flexibility for GMs.

### Rank Sets

Ranks are grouped together into sets, providing an easy way to group ranks together in the dropdown menus. Sets are incredibly simple and include only a name, an order, and whether or not they're displayed. Game masters can change the name of a set to provide a clearer idea of what ranks are in place.

## Using the Old Format

Just because there's a new rank format doesn't mean we're ignoring the old way of doing things. It's still possible to use single images (as we do for some of the genres). If you're creating a new rank set and want to use the old format, you can do so pretty easily so long as you follow a few simple rules:

1. All rank images must be in the base folder without any sub-directory structure.
2. All rank images must be named in the format of `color-grade.extension`. The hyphen is __incredibly__ important. Make sure you use a hyphen (-) and not an underscore (\_).
3. The color must be spelled out completely and must match the colors set up by the default rank set.

## Mixing the Two Formats

There will be situations where you want use an old rank format inside of the new rank format. You can do so without much work, but there are specific rules that __must__ be followed otherwise it won't work.

1. Rank images must be in the `base` folder without any sub-directory structure.
2. Rank images must be named in the format of `color_grade.extension`. The underscore is __incredibly__ important. Make sure you use an underscore (\_) and not a hyphen (-).
3. Make sure you put the same images (with the same naming format) in all of your new format ranks.
4. If you have old format rank sets as well, make sure you put the same images (with the same naming format) in the old format rank directories as well. 