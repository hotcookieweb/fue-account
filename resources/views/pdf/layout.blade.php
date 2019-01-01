<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <style>
      @page {
        size: 80mm auto portrait;
      }

      .header {
        margin: auto;
        padding: 40px;
      }

      .logo {
        width: 100px;
        height: 100px;
        max-width: 100px;
        max-height: 100px;
      }
    </style>

    @yield('content')
  </body>
</html>
