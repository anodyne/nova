# Titan skin

The updated Titan skin comes with a few nifty features that make customizing it to fit your game significantly easier.

## Changing the header logo

If you want to change the logo used in the header of the skin or at the top of the login page, you can upload an image named `logo` into the `dist/images` folder. The skin will find that image and use it instead of the Nova logo. Supported file formats for replacing the header logo are PNG, SVG, or JPG.

## Changing the skin colors

Sometimes you don't need to make wholesale changes to a skin and just want to update the colors. The skin leverages CSS variables to make it simple to change the different colors used throughout the skin.

### Automate generating a new color palette

Nova 2.7.5 includes a page that will allow you to generate a color palette from a list of pre-defined colors or by using a custom hex color. You can access the page at the `site/skincolors`. You have the ability to generate colors for primary, success, danger, warning, and info colors from the page.

Once you have selected a color or entered a custom color and generated the colors, you can copy/paste the CSS variables into the skin's `dist/css/colors.css` file.

### Manually generating a new color palette

While automating the process can be handy, sometimes it won't give you the results you're looking. You can manually generate your color palette and do the process manually.

There are a lot of websites that allow you to create color palettes. We recommend using [UIColors.app](https://uicolors.app/create) since it's simple to use and will output colors in a way that is compatible with Tailwind CSS.

Enter the color you want to use as the base for your color palette and it will create the full color scale for you. You're welcome to edit the colors to your liking. When you're done, you'll need to export the colors and copy the output (which should look like the below block of code) into a separate text document:

```
'royal-blue': {
    '50': '#f0f4fe',
    '100': '#dde6fc',
    '200': '#c3d4fa',
    '300': '#99b9f7',
    '400': '#6995f1',
    '500': '#406ceb',
    '600': '#3051e0',
    '700': '#273fce',
    '800': '#2634a7',
    '900': '#243184',
},
```

You can delete the `900` record as we will not use that one.

### Convert the colors to RGB

Once you have a color palette, you'll need to [convert](https://www.rapidtables.com/convert/color/index.html) the hex colors to RGB values. This is done so that we can use background opacity on the colors properly. Your skin will not display correctly if you skip this step!

- Copy the `50` hex value
- Paste into the converter
- Convert to RGB
- Take the 3 values and put them next to the hex value, separated by commas, for easy copying later

```
'royal-blue': {
    '50': '#f0f4fe', 240, 244, 254
    ...
},
```

### Update the CSS variables

Open `dist/css/colors.css`. In there, you'll see a complete list of the CSS color variables. For Pulsar, we use a primary color and then colors for different states (success, danger, warning, and info). Do not change the name of the CSS variable as that will break the skin.

To finish the process, simply go down the list and replace the values with the comma-separate RGB values. For example, you'll take the RGB value for the `50` item and paste it into the `100` value. After you've done the first value, it should look something like this:

```
:root {
    --primary-100: 240, 244, 254;
    ...
}
```

Continue working through the variables (being careful to pay attention to which colors you're updating) and update all 9 shades of the color palette. Save the document and make sure it's uploaded to the server. Refresh your site and you should see the new colors. You can do this for any or all of the available color variables to customize the look of your site.
