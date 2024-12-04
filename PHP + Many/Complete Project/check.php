<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PayPal Integration</title>
  <script src="https://www.paypal.com/sdk/js?client-id=AQ136heDRFOoF6v-6-NjxMEmr6FrH9KlfW9aRfJAEdqN1S9ssucLaGzCUIhoJKe5d1XpjHe62QOfdCLS&currency=USD"></script>
</head>
<body>

  <h1>Pay with PayPal</h1>
  
  <!-- PayPal Button Container -->
  <div id="paypal-button-container"></div>

  <script>
    paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '10.00'  // Set the amount here
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          alert('Transaction completed by ' + details.payer.name.given_name);
        });
      },
      onError: function(err) {
        console.error('PayPal Button Error:', err);
      }
    }).render('#paypal-button-container');
  </script>

</body>
</html>
