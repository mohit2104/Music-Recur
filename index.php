<?php 
	include('../config.php');
	$query = 'select * from data';
	$result = mysql_query( $query );
?>
<!DOCTYPE html>
<html>
	<head>
		<script src= "angular.js"></script>
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
		</style>
	</head>
	<body>
	<div id = 'player' style = 'position : absolute; height : 100px; width : 100%; left : 0%; top : 0%; background : rgba(200,200,200, 0.5); display : none'>
		<div style =' font-family : courier; font-size : 31px; font-weight : 800; text-align : center' id = 'play_data'>sonage name </div>
		<video id = 'song' controls = "" style = 'position : absolute; height : 28px; width : 99%; padding : 10px;'>
			<source src = "" type = "audio/mp3" id = 'src'>
		</video>
	</div>
	<div ng-app = 'myApp' ng-controller = 'namesCtrl' id = 'app' >
		<h1>
			Music Server 
		</h1>
		<p>
			<input id = 'input' type = 'text' ng-model = 'test' placeholder = 'Enter Song Name' />
		</p>
	  	<div ng-repeat = " x in names | filter : test | orderBy : 'name' ">
	   		<div class = 'each'>
	   			<div class = 'describe'>
	   				{{ (x.name | uppercase) + ' - ' + (x.movie | uppercase)  }} 
	   			</div>
	   			<button class = 'download' ng-click = "play_song(x.link, (x.name | uppercase) + ' - ' + (x.movie | uppercase))">
	   					Play
	   			</button>
	   			<br>
	  		</div>
		</div>
	</div>
	<script>
		angular.module('myApp', []).controller('namesCtrl', function($scope) {
    		$scope.names = [
    			<?php 
	    			while ( $row = mysql_fetch_assoc($result) ){
	    				echo "{ name : '".$row['name']."', movie : '".$row['movie']."', artist : '".$row['artist']."', link : '".$row['link']."', count : '".$row['count']."'},";
	    			}
	    		?>
    		];
		 $scope.play_song = function(a, b){
                        document.getElementById("player").style.display = 'block';
                        document.getElementById("play_data").innerHTML = b;
			document.getElementById('src').src = a;
			document.getElementById('song').load();
			document.getElementById('song').play();
                }

		});
	</script>
	</body>
</html>
