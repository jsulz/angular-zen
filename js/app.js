angular.module('azApp', [ 'ngResource' ]);

function azHelpCenter( $scope, helpCenter  ) {

	$scope.name = 'hi'

	helpCenter.query( function( res ){
		$scope.content = res;
		console.log(res);
	})

}

function helpCenter( $resource ) {
	return $resource( azOpt.zdDomain + '/api/v2/help_center/articles/search.json?query=awesome');
}


angular
	.module( 'azApp' )
	.controller( 'azHelpCenter', [ '$scope', 'helpCenter', azHelpCenter ]);

angular
	.module( 'azApp' )
	.factory( 'helpCenter', helpCenter );