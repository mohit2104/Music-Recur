<!DOCTYPE html>
<html>
	<head>
		<meta property="og:title" content="Music Recur" />
		<meta property="og:url" content="goyal.in/music" />
		<meta property="og:description" content="An exciting jounrey to let you know about my music, lets me know yours ;)" />
		<meta property="og:image" content="http://self-inspiration.com/bundles/selfinspiration/article_pictures/71.jpg" />
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
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
					<div class = 'upload' style = 'float : left' ng-show = 'logged' ng-click = 'setSwitch(2)'>
						Upload <i class  ='fa fa-upload'></i>
					</div>
					<div class = 'upload' style = 'float : left' ng-click = "getNewList('0', 'Default'); setSwitch(1)">
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
					<div class="fb-share-button" data-href="http://www.goyalm.in/music" data-layout="link"></div>
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
			<selector id = 'app' ng-show = 'switch == 1'>
			</selector>
			<upload id = 'upl' ng-show = 'switch == 2'>
			</upload>
			<div id = 'load' ng-show = 'load'>
				<div class = 'loadi'>
					<i class ='fa fa-refresh fa-spin'></i>
				</div>
			</div>
			<div id = 'ok' style = 'display : none'>
				<div class = 'loadi'>
					<i class ='fa fa-check' style = 'color : green'></i><br>
					Operation Successfull
				</div>
			</div>
			<div id = 'bad' style = 'display : none'>
				<div class = 'loadi'>
					<i class ='fa fa-close' style = 'color : red'></i><br>
					Operation Failed
				</div>
			</div>
		</div>
		<script src= "angular.js"></script>
		<script src = 'app.js'></script>
		<script src = 'fblogin.js'></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src = '../analytics.js'></script>
		<div id="status"></div>
		</body>
</html>
	