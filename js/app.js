angular.module('azApp', [ 'ngResource' ]);

function azHelpCenter( $scope, $http  ) {

	var el = document.getElementById('input');
	el.addEventListener('keypress', function(e){
		getZen(e);
	});

	function getZen(e) {
		if ( e.target.value.length > 3 ) {
			$http.get(azOpt.zdDomain + '/api/v2/help_center/articles/search.json?query=' + e.target.value)
			.then( function(response){
				$scope.answers = response.data.results;
				console.log($scope.answers);
			});
		}
	}

}

function helpCenter( $resource ) {
	console.log(azOpt.zdDomain);
	return $resource( azOpt.zdDomain + '/api/v2/help_center/articles/search.json?query=');
}


angular
	.module( 'azApp' )
	.controller( 'azHelpCenter', [ '$scope', '$http', azHelpCenter ]);

angular
	.module( 'azApp' )
	.factory( 'helpCenter', helpCenter );