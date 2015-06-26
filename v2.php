<!DOCTYPE html>
<html>
	<head>
		<link rel = 'stylesheet' href = 'style.css'>
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
					<div class = 'upload' style = 'float : left' ng-click = "getNewList('0', 'Default')">
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
				<div class = 'fhead'>
					Friends
				</div>
				<div class = 'friend' ng-click = "getNewList(myid, myname)" ng-show = "logged">
					Me
				</div> 
				<div ng-show = '!friends.length' class  = 'alert'>
					Sorry, No friends Found :(
					<div class = 'friend' style = 'text-align : center'>Invite</div>
				</div>
				<div ng-show = 'friends.length'>
					<input type = 'text' id = 'friend_search' placeholder = "Search A Friend" ng-model = 'fsearch'>
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
				<h1>
					Music Server
					<span class = 'control-container'> 
					<span class = 'control fa fa-random' ng-click = 'setFlag(3)' ng-class = "{active : checkflag(3)}"></span>
					<span class = 'control fa fa-repeat' ng-click = 'setFlag(1)' ng-class = "{active : checkflag(1)}"></span>
					<span class = 'control fa fa-retweet' ng-click = 'setFlag(2)' ng-class = "{active : checkflag(2)}"></span> 
					</span>
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
		<script src= "angular.js"></script>
		<script src = 'app.js'></script>
		<script src = 'fblogin.js'></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<script src = '../analytics.js'></script>
		<div id="status"></div>
		</body>
</html>
	