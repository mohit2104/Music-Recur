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
				min-height: 90%;
			}
			.friend{
				position : relative;
				font-size : 24px;
				margin : 10px;
				padding : 10px;
				background : rgba(0, 0, 0, 0.1);
				font-family: cursive;
				font-weight: 400;
				color : rgba(50, 100, 200, 0.7);
				text-align: center
			}
			#nav{
				position : absolute; 
				left : 0%;
				top : 0%;
				width : 100%;
				height: 50px;
				background : black;
				border-radius: 0px;
				margin : 0px;
			}
			#friend_search{
				position : relative;
				left : 0%;
				width : 90%;
				font-size: 20px;
				margin : 10px;
			}
			.fhead{
				background : black;
				color : rgba(200, 150, 50, 1);
				font-size : 25px;
				padding : 5px;
				font-family : arial;
				font-weight : 400;
				text-align: center;
				margin-bottom : 10px;
			}
			.alert{
				text-align: center;
				font-size : 22px;
				color : rgba(255, 0, 0, 0.5);
			}
			.upload{
				margin : 15px;
				color : white;
				font-size : 20px;
				cursor : pointer;
				text-decoration: none;
			}
			#load{
				position : absolute;
				width : 100%;
				height : 100%;
				left : 0%;
				top : 0%;
				background : rgba(0, 0, 0, 0.7);
				z-index : 10;
			}
			.loadi{
				position : absolute;
				left : 45%;
				top : 45%;
				font-size : 100px;
				color : white;
			}
			.upload:hover{
				color : lightblue;
			}
			#player{
				z-index : 9;
				position : fixed; 
				width : 100%; 
				left : 0%; 
				bottom : 0%; 
				background : black;
				display : none;
			}
			#play_data{
				color : white;
				font-family : courier; 
				font-size : 25px; 
				font-weight : 800; 
				text-align : center;
			}
			#song{
				height : 28px;
				width : 100%;
			}
		</style>
	</head>
	<body style = 'overflow-x : hidden'>
	<div ng-app = 'myApp' ng-controller = 'namesCtrl'>
		<div id = 'nav'>
			<fb:login-button ng-show = '!logged' scope="email, user_friends" onlogin="checkLoginState();" style = 'float : right; margin : 15px'>				
			</fb:login-button>
			<div class = 'upload' style = 'float : right;'>
				{{ lname }} <i class = 'fa fa-user'></i>
			</div>
			<div style = 'float : left'>
				<a href = 'upload.php' class = 'upload' style = 'float : left' ng-show = 'logged'>
					Upload <i class  ='fa fa-upload'></i>
				</a>
				<div class = 'upload link' style = 'float : left' ng-click = "getNewList('0', 'Default')">
					Home <i class  ='fa fa-home'></i>
				</div>
				<div class = 'upload' style = 'float : left' ng-show = 'logged'>
					Edit <i class  ='fa fa-edit'></i>
				</div>
				<div class = 'upload' style = 'float : left'>
					<div style = 'background : white'><input type = 'text' style = 'border : 0px; font-size : 20px; width : 600px; padding : 1px' placeholder = 'Search By Song Name'/><i class  ='fa fa-search' style = 'color : black'></i></div>
				</div>
			
			</div>
		</div>
		<div id = 'friendList' ng-show = 'logged'>
			<div class = 'fhead'>Friends</div>
			<div class = 'friend' ng-click = "getNewList(myid, myname)" ng-show = "logged">
				Me
			</div> 
			<div ng-show = '!friends.length' class  = 'alert'>
				Sorry, No friends Found :(
				<div class = 'friend' style = 'text-align : center'>Invite</div>
			</div>
			<div ng-show = 'friends.length'>
				<input type = 'text' id = 'friend_search' placeholder = "Search A Friend"/ ng-model = 'fsearch'>
				<div class = 'friend' ng-repeat = 'friend in friends | filter : fsearch' ng-click = 'getNewList(friend.id, friend.name)'>
				{{ friend.name }}
				</div>
			</div>
		</div>
		<div id = 'player'>
			<div id = 'play_data'>{{ song_name | uppercase }}</div>
			<audio id = 'song' song controls = "">
				<source src = "" type = "audio/mp3" id = 'src'>
			</audio>
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
			<h3 ng-show = '!names.length' class = 'alert'>Playlist Is Empty</h3>
		  	<div ng-repeat = " x in names | filter : test " ng-show = 'names.length'>
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
		<div id = 'load' ng-show = 'load'>
		<div class = 'loadi'>
			<i class ='fa fa-refresh fa-spin'></i>
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
    	//	$scope.friends = [];
    		$scope.myid = 0;
    		$scope.myname = 0;
    		$scope.load = false;
    		$scope.friends = [{"name" : "mohit", "id" : 0}, {"name" : "goyal", "id" : 1}];
    		$scope.length = <?php echo $id; ?>;
    		$scope.current = 0;
    		$scope.flag = 1;
    		$scope.logged = false;
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
		});
	</script>
	<script src = '../analytics.js'></script>
	<script src = 'fblogin.js'></script>
	<div id="status">
	</div>
	</body>
</html>
	