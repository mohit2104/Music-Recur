<?php 
	include('../config.php');
	$query = 'select * from data where `user_id` = 0';
	$result = mysql_query( $query );
?>
<!DOCTYPE html>
<html>
	<head>
		<script src= "angular.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

		<style>
			button{
				background : rgba( 0, 0, 0, 0.8);
				color : white;
				padding : 5px;
				border-radius : 20%;
			}
			a{
				color : white;
			}
			#app{
				position : absolute;
				top : 20%;
				width : 100%;
				text-align : center;
				font-family: courier;
			}
			#input{
				font-size : 25px;
				padding : 4px;
				width : 40%;
			}
			.each{
				position : relative;
				left : 30%;
				width : 40%;
				font-size : 20px;
				border-bottom : 1px solid rgba(0,0,0,0.1);
				padding : 10px;
			}
			.describe{
				float : left;
			}
			.download{
				float : right;
			}
			.control{
				padding : 5px;
				font-size : 20px;
				cursor : pointer;
				border-radius : 50%;
			}
			.control:hover{
				background : black;
				color : white;
			}
			.active{
				background : rgba(50, 100, 200, 0.6);
				color : white;
			}
			.count{
				font-size : 11px;
				padding : 3px;
				background : black;
				color : white;
				border-radius : 20%;
			}
			#friendList{
				position: absolute;
				left : 5px;
				top : 10%;
				background : rgba(230, 230, 230, 0.4);
				width : 20%;
				z-index: 10;
			}
			.friend{
				position : relative;
				font-size : 20px;
				border-bottom : 1px solid rgba(0,0,0,0.1);
				padding : 10px;
			}
		</style>
	</head>
	<body>
	<div ng-app = 'myApp' ng-controller = 'namesCtrl' id = 'app'>
		<div id = 'player' style = 'position : absolute; height : 100px; width : 100%; left : 0%; top : 0%; background : rgba(200,200,200, 0.5); display : none'>
			<div style =' font-family : courier; font-size : 31px; font-weight : 800; text-align : center' id = 'play_data'>sonage name </div>
			<video id = 'song' song controls = ""  style = 'position : absolute; height : 28px; width : 99%; padding : 10px;'>
				<source src = "" type = "audio/mp3" id = 'src'>
			</video>
		</div>
		<div id = 'friendList'>
			<div class = 'friend' ng-repeat = 'friend in friends' ng-click = 'getNewList(friend.id)'>
			{{ friend.name }}
			</div>
		</div>
		<div id = 'app'>
			<h1 style >
				Music Server 
				<span class = 'control fa fa-random' ng-click = 'setFlag(3)' ng-class = "{active : checkflag(3)}"></span>
				<span class = 'control fa fa-repeat' ng-click = 'setFlag(1)' ng-class = "{active : checkflag(1)}"></span>
				<span class = 'control fa fa-retweet' ng-click = 'setFlag(2)' ng-class = "{active : checkflag(2)}"></span> 
			</h1>
			<p>
				<input id = 'input' type = 'text' ng-model = 'test' placeholder = 'Enter Song Name' />
			</p>
		  	<div ng-repeat = " x in names | filter : test  ">
		   		<div class = 'each'>
		   			<div class = 'describe'>
		   				{{ (x.name | uppercase) + ' - ' + (x.movie | uppercase)  }} 
		   			</div>
					<div class = 'download' >
						<span class  = 'count'>{{   x.count  }}</span>
		   				<button  ng-click = "changeCurrent(x.id)">
		   					Play
		   				</button>
					</div>
		   			<br>
		  		</div>
			</div>
		</div>
	</div>
	<script>
	
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
    		$scope.names = [
    			<?php 
    				$id = 0;
	    			while ( $row = mysql_fetch_assoc($result) ){
	    				echo "{ oid : '".$row['id']."', id : '".$id."', name : '".$row['name']."', movie : '".$row['movie']."', artist : '".$row['artist']."', link : '".$row['link']."', count : '".$row['count']."'},";
	    				$id = $id + 1;
	    			}
	    		?>
    		];
    		$scope.friends = [];
    		$scope.length = <?php echo $id; ?>;
    		$scope.current = 0;
    		$scope.flag = 1;

		 	$scope.play_song = function(){
		 		console.log($scope.current);
		 		var b = ($scope.names[$scope.current].name )  + ' - ' + ($scope.names[$scope.current].movie );
				var a = $scope.names[$scope.current].link;
                document.getElementById("player").style.display = 'block';
                document.getElementById("play_data").innerHTML = b;
				document.getElementById('src').src = a;
				document.getElementById('song').load();
				document.getElementById('song').play();
				$scope.audit($scope.names[$scope.current].oid);
				$scope.names[$scope.current].count = parseInt($scope.names[$scope.current].count) + 1;
                }

            $scope.changeCurrent = function(a){
				$scope.current = a;
				$scope.play_song();
			}
			
			$scope.changeCurrentProgressive = function(){
				$scope.current = ( parseInt($scope.current) + 1 ) % parseInt($scope.length);
				$scope.play_song();
			}
			
			$scope.suffleChange = function(){
				while(1){
					var x = Math.floor((Math.random()*parseInt($scope.length)));
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
			$scope.getNewList = function(id){
				console.log("fetching new list");
				$.ajax({
					url : "fsl.php",
					method : "GET",
					data : { userId : id }
				}).done(function(response){
					console.log(response);
					$scope.names = JSON.parse(response);
					$scope.$apply();
				});				
			}
		});
	</script>
	<script src = '../analytics.js'></script>
	<script src = 'fblogin.js'></script>
	<fb:login-button scope="email, user_friends" onlogin="checkLoginState();">
	</fb:login-button>
	<div id="status">
	</div>
	</body>
</html>
