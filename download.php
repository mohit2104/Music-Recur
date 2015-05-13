<?php 
	mysql_connect('localhost', 'root', 'root');
	mysql_select_db('music');
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
	   			<button class = 'download'>
	   				<a href = '{{ x.link }}' download >
	   					Download 
	   				</a> 
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
		});
	</script>
	</body>
</html>
