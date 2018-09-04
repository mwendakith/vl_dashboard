
reCAPTCHA V2

This page explains how to display and customize the reCAPTCHA V2 widget on your webpage.

To display the widget, you can either:

Automatically render the widget or
Explicitly render the widget
See Configurations to learn how to customize your widget. For example, you may want to specify the language or theme for the widget.

See Verifying the user's response to check if the user successfully solved the CAPTCHA.

Automatically render the reCAPTCHA widget

The easiest method for rendering the reCAPTCHA widget on your page is to include the necessary JavaScript resource and a g-recaptcha tag. The g-recaptcha tag is a DIV element with class name 'g-recaptcha' and your site key in the data-sitekey attribute:

<html>
  <head>
    <title>reCAPTCHA demo: Simple page</title>
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <form action="?" method="POST">
    <div class="g-recaptcha" data-sitekey="6LcQyDkUAAAAAB6Qx3q3aT1768kpNQ7EGkok-pUj"></div>
      <br/>
      <input type="submit" value="Submit">
    </form>
  </body>
</html>