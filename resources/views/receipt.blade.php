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

      request += builder.createTextElement({characterspace: 2, codepage: 'utf8'});

      // Information about HotCookie
      request += builder.createAlignmentElement({position: "center"});

      // Top Logo - pre-download into printer with star setup utility windows only
      request += builder.createLogoElement({number: 1});

      // Packing Slip
      request += builder.createTextElement({emphasis: true});
      request += builder.createTextElement({data: '\nPacking Slip\n'});
      request += builder.createTextElement({emphasis: false});

      // Shipping Full Name
      request += builder.createTextElement({data: '{{ $order["shipping"]["first_name"]  }} {{ $order["shipping"]["last_name"] }}\n'});

      // Shipping Company if exists
      @if(isset($order["company"]))
        request += builder.createTextElement({data: '{{ $order["company"] }}\n'});
      @endif

      // Shipping Address 1
      request += builder.createTextElement({data: '{{ $order["shipping"]["address_1"] }}\n'});

      // Shipping Address 2 if exists
      @if(isset($order["shipping"]["address_2"]))
        request += builder.createTextElement({data: '{{ $order["shipping"]["address_2"] }}\n'});
      @endif

      // Shipping City, State Zipcode, Country
      request += builder.createTextElement({data: '{{ $order["shipping"]["city"] }}, {{ $order["shipping"]["state"] }} {{ $order["shipping"]["postcode"] }} {{ $order["shipping"]["country"] }}\n\n'});


      // Contact Info
      request += builder.createTextElement({emphasis: true});
      request += builder.createTextElement({data: 'Contact Info\n'});
      request += builder.createTextElement({emphasis: false});
      // Shipping Email if exists
      request += builder.createTextElement({data: '{{ $order["billing"]["email"] }}\n'});
      // Shipping Phone Number
      request += builder.createTextElement({data: '{{ $order["billing"]["phone"] }}\n'});

      // break
      request += builder.createTextElement({data: '\n'});

      // Order Number: <>
      request += builder.createTextElement({emphasis: true});
      request += builder.createTextElement({data: 'Order Number: {{ $order_number }}\n'});
      request += builder.createTextElement({emphasis: false});

      @php
      $order_date = date("F j, Y", strtotime($order["date_created"]));
      @endphp

      // Order Date: Month <day>, <year>
      request += builder.createTextElement({data: '{{ $order_date }}\n'});

      // Shipping Method:
      request += builder.createTextElement({data: '{{ $order["shipping_lines"][0]["method_title"] }}\n'});

      @foreach ($order['meta_data'] as $md)
        @if ($md["key"] == "ready_date")
          // Delivery Date: Between <>
          request += builder.createTextElement({data: '{{ $md["value"] }}\n'});
        @endif
        @if ($md["key"] == "ready_time")
          // Delivery Time: Between <>
          request += builder.createTextElement({data: '{{ $md["value"] }}\n'});
        @endif
      @endforeach

      // break
      request += builder.createTextElement({data: '\n'});

      request += builder.createAlignmentElement({position: "left"});

      // method_title--quantity
      request += builder.createTextElement({emphasis: true});
      request += builder.createTextElement({data: '#    Product\n'});
      request += builder.createTextElement({emphasis: false});
      request += builder.createRuledLineElement();

      @foreach($order["line_items"] as $item)
        request += builder.createTextElement({data: '{{ $item["quantity"] }}    {{ $item["name"] }}\n'});
        @foreach ($item["meta_data"] as $md)
          @php
          $key = str_replace("pa_", "", $md["key"]); // meta data passed as slugs, not names
          @endphp
          request += builder.createTextElement({font: 'font_b'});
          request += builder.createTextElement({data: ' {{ $key }}: {{ $md["value"] }}\n'});
          request += builder.createTextElement({font: 'font_a'});
        @endforeach
      @endforeach
      request += builder.createRuledLineElement({thickness:'double_thin'});

      @if ($order['customer_note'])
        request += builder.createTextElement({emphasis: true});
        request += builder.createTextElement({data: '\nCustomer Note:\n'});
        request += builder.createTextElement({emphasis: false});
        request += builder.createTextElement({font: 'font_b'});
        request += builder.createTextElement({data: '{{ $order['customer_note']}}\n\n'});
        request += builder.createTextElement({font: 'font_a'});
        request += builder.createRuledLineElement({thickness:'double_thin'});
      @endif

      // HotCookie slogan - pre-downloaded into printer with setup utility
      request += builder.createTextElement({data: '\n'});
      request += builder.createLogoElement({number: 2});

      // FEED and CUT PAPER WE ARE DONE
  //    request += builder.createFeedElement(2);
      request += builder.createCutPaperElement({feed:true});

      var url = "{{ $url }}";

      function sendMessageApi(url, request) {
          var trader = new StarWebPrintTrader({url:url});

          trader.onReceive = function (response) {
              hideNowPrinting();

              var msg = '- onReceive -\n\n';

              msg += 'TraderSuccess : [ ' + response.traderSuccess + ' ]\n';

      //      msg += 'TraderCode : [ ' + response.traderCode + ' ]\n';

              msg += 'TraderStatus : [ ' + response.traderStatus + ',\n';

              if (trader.isCoverOpen            ({traderStatus:response.traderStatus})) {msg += '\tCoverOpen,\n';}
              if (trader.isOffLine              ({traderStatus:response.traderStatus})) {msg += '\tOffLine,\n';}
              if (trader.isCompulsionSwitchClose({traderStatus:response.traderStatus})) {msg += '\tCompulsionSwitchClose,\n';}
              if (trader.isEtbCommandExecute    ({traderStatus:response.traderStatus})) {msg += '\tEtbCommandExecute,\n';}
              if (trader.isHighTemperatureStop  ({traderStatus:response.traderStatus})) {msg += '\tHighTemperatureStop,\n';}
              if (trader.isNonRecoverableError  ({traderStatus:response.traderStatus})) {msg += '\tNonRecoverableError,\n';}
              if (trader.isAutoCutterError      ({traderStatus:response.traderStatus})) {msg += '\tAutoCutterError,\n';}
              if (trader.isBlackMarkError       ({traderStatus:response.traderStatus})) {msg += '\tBlackMarkError,\n';}
              if (trader.isPaperEnd             ({traderStatus:response.traderStatus})) {msg += '\tPaperEnd,\n';}
              if (trader.isPaperNearEnd         ({traderStatus:response.traderStatus})) {msg += '\tPaperNearEnd,\n';}

              msg += '\tEtbCounter = ' + trader.extractionEtbCounter({traderStatus:response.traderStatus}).toString() + ' ]\n';

      //      msg += 'Status : [ ' + response.status + ' ]\n';
      //
      //      msg += 'ResponseText : [ ' + response.responseText + ' ]\n';

              console.log(msg);
          }

          trader.onError = function(response) {
              var msg = '- onError -\n\n';

              msg += '\tStatus:' + response.status + '\n';

              msg += '\tResponseText:' + response.responseText;

              console.log(msg);
          }

          trader.sendMessage({request: request});
      }

      sendMessageApi(url, request);

      setTimeout(function() {
        window.location.href = "/";
      }, 5000)

    </script>
  </body>
</html>
