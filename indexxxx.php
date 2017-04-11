<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body ng-app="stripe-app" ng-controller="main-ctrl">

	<div ng-controller="stripe-ctrl">
		<!-- stripe payment tool directive -->
		<button stripe-payment="config" ng-click="download(ev)">Mini Team</button>
	</div>	

	<script type="text/javascript" src="js/angular.min.js"></script>
	<script src="https://checkout.stripe.com/checkout.js"></script>
	<script src="js/stripe.payment.tool.js"></script>

	<script type="text/javascript">

		(function(stripe) {

			stripe.controller('main-ctrl', ['$scope', function ($scope) {
				console.log('main controller hits !!')
			}])

			stripe.controller('stripe-ctrl', ['$scope', '$http', 'paymentGateway', function ($scope, $http, paymentGateway) {

				$scope.config= {
					publishKey: 'pk_test_8FepS5OSLnghnaPfVED8Ixkx',
					title: 'Duoworld',
					description: "for connected business",
					logo: 'img/small-logo.png',
					label: 'New Card Duo',
					allowRememberMe: false
				};

				$scope.download = function(ev) {
					$scope.$broadcast('open-stripe-gateway', ev)
				}

				$scope.purchase = function(ev, app) {
					var stripegateway = paymentGateway.setup('stripe').configure(stripeConfig);
					stripegateway.open(ev, function(token, args) {
						console.log(token.id);
					});
				}

				var initiatePayment = function(ev, app) {
					if(cards.length) makePayment(app);
					else {
						var stripegateway = paymentGateway.setup('stripe').configure(stripeConfig);
						stripegateway.open(ev, function(token, args) {
							makePayment(app, token, args);
						});
					}		
				}
				
			}]);

		})(angular.module('stripe-app', ['stripe-payment-tools']));

	</script>
</body>
</html>