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
	$scope.friends = [];
	$scope.total = [];
	$scope.myid = 0;
	$scope.myname = 0;
	$scope.load = false;
//	$scope.friends = [{"name" : "mohit", "id" : 0}, {"name" : "goyal", "id" : 1}];
	$scope.length  = 0;
	$scope.current = 0;
	$scope.flag = 1;
	$scope.logged = false;
	$scope.activ = true;
	$scope.switch = 1;
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
    $scope.setSwitch = function(a){
		$scope.switch = a;
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
	$scope.setActiv = function(a){
		if($scope.activ && a ==  2){
			$scope.activ = !$scope.activ;
		}
		else if(!$scope.activ && a == 1){
			$scope.activ = !$scope.activ;
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
	$scope.getAll = function(){
		$scope.load = true;
		console.log("fetching everything");
		$.ajax({
			url : "fsl.php",
			method : "GET",
			data : { userId : -1 }
		}).done(function(response){
			console.log(response);
			$scope.total = JSON.parse(response);
			$scope.load = false;
			$scope.$apply();
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
	$scope.addToList = function(a){
		$scope.load = true;
		console.log("uploading");
		var x = $scope.total[a].name;
		var y = $scope.total[a].artist;
		var z = $scope.total[a].movie;
		var za = $scope.total[a].link;
		$.ajax({
			url : "up1.php",
			method : "POST",
			data : { name : x, artist : y, movie : z, path : za }
		}).done(function(response){
			response = response.trim();
			$scope.load = false;
			$scope.$apply();
			console.log("This is response : " + response + ".");
			if(response == 'success'){
				ok_case_show();
			}
			else{
				bad_case_show();
			}
		});
	}

	$scope.upsong = function(){
		$scope.load = true;
        console.log("Uploading a song");
        var fd = new FormData(document.getElementById("upf"));
        $.ajax({
          url: "up2.php",
          type: "POST",
          data: fd,
          enctype: 'multipart/form-data',
          processData: false,
          contentType: false
		}).done(function( response ){
			response = response.trim();
			$scope.load = false;
			$scope.$apply();
			console.log("This is response : " + response + ".");
			if(response == 'success'){
				ok_case_show();
			}
			else{
				bad_case_show();
			}
        });
    }

	$scope.getNewList(0, "Mohit Goyal");
}).directive('upload', function(){
	return {
		restrict :'E',
		templateUrl : "upload.html"
	}
}).directive('selector', function(){
	return {
		restrict :'E',
		templateUrl : "selector.html"
	}
});

function up_change(){
	var value = document.getElementById("file").value.split(/[\/\\]/).pop();
	document.getElementById("selectSong").innerHTML = value;
}


function ok_case_show(){
	document.getElementById("ok").style.opacity = '1';
    document.getElementById("ok").style.display = 'block';
    ok_case_hide();
};

function ok_case_hide(){
    $('#ok').animate({opacity : 0}, 3000, function(){followup("ok")});
};


function bad_case_show(){
	document.getElementById("bad").style.opacity = '1';
    document.getElementById("bad").style.display = 'block';
	bad_case_hide();
};

function bad_case_hide(){
    $('#bad').animate({opacity : 0}, 3000, function(){followup("bad")});
};

function followup(a){
	document.getElementById(a).style.display = 'none';
}


