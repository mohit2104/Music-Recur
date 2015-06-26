angular.module('myApp', []).
	directive('song', function() {
		console.log("working");
			return {
			restrict : 'A',
				link : function(scope, element, attrs){
					element.bind('ended', function(){
						scope.changeSong();
					});
					
				}
			}
	}).controller('namesCtrl', function($scope) {
	$scope.names = [];
//	$scope.friends = [];
	$scope.myid = 0;
	$scope.myname = 0;
	$scope.load = false;
	$scope.friends = [{"name" : "mohit", "id" : 0}, {"name" : "goyal", "id" : 1}];
	$scope.length  = 0;
	$scope.current = 0;
	$scope.flag = 1;
	$scope.logged = true;
	$scope.lname = "Mohit Goyal";
	$scope.song_name = 'none';
 	$scope.play_song = function(){
 		console.log($scope.current);
 		var b = ($scope.names[$scope.current].name )  + ' - ' + ($scope.names[$scope.current].movie );
		var a = $scope.names[$scope.current].link;
		$scope.song_name = b;
        document.getElementById("player").style.display = 'block';
		document.getElementById('src').src = a;
		document.getElementById('song').load();
		document.getElementById('song').play();
		$scope.audit($scope.names[$scope.current].oid);
		$scope.names[$scope.current].count = parseInt($scope.names[$scope.current].count) + 1;
		$scope.$apply();
        }

    $scope.changeCurrent = function(a){
		$scope.current = a;
		$scope.play_song();
	}
	
	$scope.changeCurrentProgressive = function(){
		$scope.current = ( parseInt($scope.current) + 1 ) % parseInt($scope.names.length);
		$scope.play_song();
	}
	
	$scope.suffleChange = function(){
		while(1){
			var x = Math.floor((Math.random()*parseInt($scope.names.length)));
			if( x != parseInt($scope.current)){
				$scope.current = x;
				break;
			}
		}
		$scope.play_song();
	}
	$scope.changeSong = function(){
		if($scope.flag == 1){
			$scope.play_song();
		}
		else if($scope.flag == 2){
			$scope.changeCurrentProgressive();
		}
		else{
			$scope.suffleChange();
		}
	}
	$scope.setFlag = function(a){
		$scope.flag = a;
	}
	$scope.checkflag = function(a){
		if($scope.flag == a)
			return true;
		else
			return false;
	}
	$scope.audit = function(a){
		var iden;
		if(localStorage.getItem('identity')){
			iden = localStorage.getItem('identity');
		}
		else{
			iden = Math.floor(Math.random() * 100000000 );
			localStorage.setItem('identity', iden);
		}
		console.log(iden); 
		$.ajax({
			url : "audit.php",
			method : "GET",
			data : { id : a, identity : iden }
		});
	}
	$scope.getNewList = function(id, name){
		$scope.load = true;
		console.log("fetching new list");
		$.ajax({
			url : "fsl.php",
			method : "GET",
			data : { userId : id }
		}).done(function(response){
			console.log(response);
			$scope.names = JSON.parse(response);
			$scope.lname = name;
			$scope.load = false;
			$scope.$apply();
		});				
	}
	$scope.getNewList(0, "Mohit Goyal");
});