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

      // Information about HotCookie
      request += builder.createAlignmentElement({position: "center"});

      // Top Logo
      request += builder.createLogoElement({number: 1});

      // HotCookie
      request += builder.createTextElement({emphasis: true});
      request += builder.createTextElement({data: '\nHotCookie\n'});
      request += builder.createTextElement({emphasis: false});

      // Company Address
      request += builder.createTextElement({data: '407 Castro St\n'});
      request += builder.createTextElement({data: 'San Francisco, CA 94114\n\n'});


      // Packing Slip
      request += builder.createTextElement({emphasis: true});
      request += builder.createTextElement({data: 'Packing Slip\n'});
      request += builder.createTextElement({emphasis: false});

      // Shipping Full Name
      request += builder.createTextElement({data: '{{ $order["full_name"] }}\n'});

      // Shipping Company if exists
      request += builder.createTextElement({data: '{{ $order["company"] }}\n'});

      // Shipping Address 1
      request += builder.createTextElement({data: '{{ $order["address_1"] }}\n'});

      // Shipping Address 2 if exists
      request += builder.createTextElement({data: '{{ $order["address_2"] }}\n'});

      // Shipping City, State Zipcode
      request += builder.createTextElement({data: '{{ $order["location"] }}\n'});

      // Shipping Country
      request += builder.createTextElement({data: '{{ $order["country"] }}\n'});

      // Shipping Email if exists
      request += builder.createTextElement({data: '{{ $order["email"] }}\n'});

      // Shipping Phone Number
      request += builder.createTextElement({data: '{{ $order["phone"] }}\n'});

      // break
      request += builder.createTextElement({data: '\n'});

      // Order Number: <>
      request += builder.createTextElement({data: '{{ $order["order_number"] }}\n'});

      // Order Date: Month <day>, <year>
      request += builder.createTextElement({data: '{{ $order["order_date"] }}\n'});

      // Shipping Method: <>
      request += builder.createTextElement({data: '{{ $order["shipping_method"] }}\n'});

      // Delivery Time: Between <>
      request += builder.createTextElement({data: '{{ $order["delivery_time"] }}\n'});

      // break
      request += builder.createTextElement({data: '\n'});

      // method_title--quantity
      request += builder.createTextElement({data: 'Product\t\t\t\tQty\n'});

      @foreach($order["items"] as $item)
        request += builder.createTextElement({data: '{{ $item["method_title"] }}\t\t\t\t{{ $item["quantity"] }}\n'});
      @endforeach

      // CUT PAPER WE ARE DONE
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

      sendMessageAPI(url, request);

    </script>
  </body>
</html>
