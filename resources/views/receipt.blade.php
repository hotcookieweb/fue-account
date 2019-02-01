<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title></title>
    <script type='text/javascript' src='/js/StarWebPrintBuilder.js'></script>
    <script type='text/javascript' src='/js/StarWebPrintTrader.js'></script>
  </head>
  <body>
    <script type="text/javascript">
      var builder = new StarWebPrintBuilder();

      var request = "";

      request += builder.createInitializationElement();

      request += builder.createTextElement({characterspace: 2});
      request += builder.createAlignmentElement({position: "right"});
      request += builder.createLogoElement({number: 1});
      
    </script>
  </body>
</html>
