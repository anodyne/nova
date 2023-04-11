<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}?>

<h1 class="page-head">Generate Customized Skin Colors</h1>

<p>The new versions of Pulsar and Titan that ship with Nova 2.7 include the ability to change the overall color scheme with only a handful of lines of CSS. You can generate the CSS code needed to change the different colors for those skins by using the form below. <strong>Please note:</strong> this will only apply to the new versions of Pulsar and Titan.</p>

<table class="table100">
  <tbody>
    <tr>
      <td class="col_50pct align_top">
        <?php echo form_open('site/skincolors');?>
          <p>
            <kbd>Color type to generate</kbd>
            <select name="color_type">
              <option value="primary">Primary</option>
              <option value="success">Success</option>
              <option value="warning">Warning</option>
              <option value="danger">Danger</option>
              <option value="info">Info</option>
            </select>
          </p>

          <p>
            <kbd>What color would you like to use?</kbd>
            <select name="color_scale" id="color_scale">
              <option value="custom">Custom color</option>
              <option value="Slate">Slate</option>
              <option value="Gray">Gray</option>
              <option value="Zinc">Zinc</option>
              <option value="Neutral">Neutral</option>
              <option value="Stone">Stone</option>
              <option value="Red">Red</option>
              <option value="Orange">Orange</option>
              <option value="Amber">Amber</option>
              <option value="Yellow">Yellow</option>
              <option value="Lime">Lime</option>
              <option value="Green">Green</option>
              <option value="Emerald">Emerald</option>
              <option value="Teal">Teal</option>
              <option value="Cyan">Cyan</option>
              <option value="Sky">Sky</option>
              <option value="Blue">Blue</option>
              <option value="Indigo">Indigo</option>
              <option value="Violet">Violet</option>
              <option value="Purple">Purple</option>
              <option value="Fuchsia">Fuchsia</option>
              <option value="Pink">Pink</option>
              <option value="Rose">Rose</option>
            </select>
          </p>

          <p class="custom">
            <kbd>Custom color</kbd>
            <?php echo form_input($inputs['custom']);?>
          </p>

          <?php echo form_button($buttons['generate']);?>
        <?php echo form_close();?>
      </td>
      <td class="col_50pct align_top">
        <?php if (isset($generatedStyles)): ?>
          <div class="info-full">
            <pre>--<?php echo $generatedType;?>-100: <?php echo $generatedStyles[100];?>;
--<?php echo $generatedType;?>-200: <?php echo $generatedStyles[200];?>;
--<?php echo $generatedType;?>-300: <?php echo $generatedStyles[300];?>;
--<?php echo $generatedType;?>-400: <?php echo $generatedStyles[400];?>;
--<?php echo $generatedType;?>-500: <?php echo $generatedStyles[500];?>;
--<?php echo $generatedType;?>-600: <?php echo $generatedStyles[600];?>;
--<?php echo $generatedType;?>-700: <?php echo $generatedStyles[700];?>;
--<?php echo $generatedType;?>-800: <?php echo $generatedStyles[800];?>;
--<?php echo $generatedType;?>-900: <?php echo $generatedStyles[900];?>;</pre>
          </div>

          <p class="top_1em">Copy the code above and replace the <?php echo $generatedType;?> colors in the skin's <code>dist/colors.css</code> file. Once you have saved it and uploaded it back to your server, you should see your changes reflected in the skin.</p>

          <div style="overflow:hidden;border-radius:0.375rem;">
            <?php foreach ($generatedStyles as $code => $rgb): ?>
              <div style="display:flex;align-items:center;margin-top:0.5rem;">
                <div style="width:3.5rem;"><?php echo $code;?></div>
                <div style="padding:0.75rem 1rem;width:100%;background-color:rgb(<?php echo $rgb;?>);overflow:hidden;border-radius:0.375rem;">&nbsp;</div>
              </div>
            <?php endforeach;?>
          </div>
        <?php endif; ?>
      </td>
    </tr>
  </tbody>
</table>
