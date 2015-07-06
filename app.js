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
	}).controller('namesCtrl', function($scope, $window){

	$scope.names = [];
	$scope.friends = [];
	$scope.total = [];
	$scope.myid = 0;
	$scope.myname = 0;
	$scope.uploading = false;
	$scope.progressBar = false;
	$scope.progress = 0;
	$scope.load = false;
	$scope.length  = 0;
	$scope.current = 0;
	$scope.flag = 1;
	$scope.logged = false;
	$scope.activ = true;
	$scope.switch = 1;
	$scope.lname = "Mohit Goyal";
	$scope.song_name = 'none';
	$scope.play = false;
	$scope.analyzerMode = true;
	$scope.time = '0:0';
	$scope.track = 0;

	$window.addEventListener('keydown', function(e) {
	    if (e.keyCode == 32){
	    	if($scope.play == true){ 
	        	try{
		        	$window.audio.pause();
		        	$scope.play = false;
		        }
		        catch(err){
		        	console.log(err + " : event listener keydown pause");
		        }
	        }
	      	else{
	      		try{
		        	$window.audio.play();
		        	$scope.play = true;
		        }
		        catch(err){
		        	console.log(err + " : event listener keydown play");
		        }
	      	}
	    }
	}, false);

	$window.audio.addEventListener('timeupdate', function(e){
    	var currTime = audio.currentTime;
    	var prev = $scope.time;
    	$scope.time = parseInt(currTime / 60) + ':' + parseInt(currTime % 60);
    	if(prev != $scope.time)
    		$scope.track = $scope.track + 1;
    	if($scope.track >= 3){
    		$scope.analyzerMode = true;
    	}
    	$scope.$apply();
  	}, false);

	$window.addEventListener('mousemove', function(e){
		$scope.track = 0;
		$scope.analyzerMode = false;
		$scope.$apply();
	});
	$scope.play_repeat = function(){
		document.getElementById('song').play();
		//todo verify
		$scope.audit($scope.names[$scope.current].oid);
	}
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
			$scope.play_repeat();
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
		$scope.uploading = true;
		$scope.uploading_message = "uploading info to server";
		$scope.$apply();
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
			$scope.uploading = false;
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
		$scope.uploading = true;
		$scope.uploading_message = "Creating a 10 minute session for uploading";
        console.log("Uploading a song");
        $.ajax({
			url : "signature.php",
			method : "GET",
			data : { }
		}).done(function(response){
			console.log(response);
			var z = JSON.parse(response);
			$scope.uploadFile(z.pl, z.sig);
		});
	}
    
	$scope.key = '';	
    $scope.uploadFile = function(pl, sig) {
        var file = document.getElementById('file').files[0];
        var fd = new FormData();
        $scope.key = "songs/" + (new Date).getTime() + ".mp3";
        fd.append('key', $scope.key);
        fd.append('AWSAccessKeyId', 'AKIAI6GQEQXABZQAV7DA');
        fd.append('acl', 'public-read');
        fd.append('success_action_redirect', "http://www.goyalm.in/music/v2.php")
        fd.append('policy', pl);
        fd.append('signature', sig);
        fd.append('Content-Type', 'audio/mp3');
        fd.append('file', file);
        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener("progress", uploadProgress, false);
    /*  xhr.addEventListener("load", $scope.uploadComplete, false);
        xhr.addEventListener("error", $scope.uploadFailed, false);
        xhr.addEventListener("abort", $scope.uploadCanceled, false);
    */
        xhr.open('POST', 'https://musicrecur.s3.amazonaws.com/', true); 
        xhr.send(fd);
        $scope.progressBar = true;
        xhr.onreadystatechange = function(){
        	if( xhr.readyState == 4 ){
        		$scope.upsongdb();
        		$scope.progressBar = false;
        	}
        }
	}

	function uploadProgress(evt) {
        if (evt.lengthComputable) {
          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
          console.log(percentComplete);
          $scope.progress = percentComplete;
          $scope.uploading_message = percentComplete + " % uploaded";
          $scope.$apply();
        }
    }

	$scope.upsongdb = function(){
		$scope.uploading_message = "linking your account with the song.";
		$scope.$apply();
        console.log("Uploading to db");
        var nm = document.getElementById('nm').value;
        var mv = document.getElementById('mv').value;
        var at = document.getElementById('at').value;
        var loc = "https://s3-us-west-1.amazonaws.com/musicrecur/" + $scope.key;
        $.ajax({
			url : "up2.php",
			method : "POST",
			data : { 'name' : nm, 'movie' : mv, 'artist' : at, 'loc' : loc }
		}).done(function(response){
			response = response.trim();
			$scope.uploading = false;
			$scope.$apply();
			console.log("This is response : " + response + ".");
			if(response == 'success'){
				$uploading_message = '';
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
}).directive('analyzer', function(){
	return {
		restrict :'E',
		templateUrl : "analyzer.html"
	}
});

window.audio = document.getElementById("song");
window.audio.crossOrigin = "https://s3-us-west-1.amazonaws.com";
var currenTimeNode = document.querySelector('#current-time');



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

// draw canvas by analyzing the beats  

var context = new AudioContext();
var analyser = context.createAnalyser();

window.requestAnimFrame = (function(){
  return  window.requestAnimationFrame       ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame    ||
          function( callback ){
            window.setTimeout(callback, 1000 / 60);
          };
})();

  
function rafCallback(time) {
    requestAnimFrame(rafCallback);
    try{
	    var canvas = document.getElementById('fft');
		var ctx = canvas.getContext('2d');
	    var freqByteData = new Uint8Array(analyser.frequencyBinCount);
	    analyser.getByteFrequencyData(freqByteData); 
	    var CANVAS_WIDTH = parseInt(window.innerWidth);
	    var CANVAS_HEIGHT = parseInt(window.innerHeight);
	    canvas.height = CANVAS_HEIGHT;
	    canvas.width = CANVAS_WIDTH;
	    var SPACER_WIDTH = 25;
	    var BAR_WIDTH = 15;
	    var OFFSET = 100;
	    var CUTOFF = 23;
	    var numBars = Math.round(CANVAS_WIDTH / SPACER_WIDTH);
	    ctx.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
	    var min = 9999;
	    ctx.fillStyle = 'rgba(100, 50, 100, 0.3)';
	    for (var i = 0; i < numBars; ++i) {
	        if( min > freqByteData[  i + numBars] * 3)
	          	min = freqByteData[  i + numBars] * 3;
	    }
	  	ctx.beginPath();
	  	ctx.lineWidth = 1;
	  	ctx.strokeStyle = "rgb(255, 0, 0)";
	  	for (var i = 0; i < numBars; ++i) {
	    	var magnitude = freqByteData[ i + numBars] * 3 - min + 2;
	    	var yc = CANVAS_HEIGHT - (freqByteData[  i + numBars] * 3 + freqByteData[  i + 2 + numBars] * 3) / 2 + min - 2;
	      	var xc = ( i + 1) / 2 * SPACER_WIDTH;
	      	if(i > 0)
	;//      		ctx.quadraticCurveTo(i * SPACER_WIDTH, CANVAS_HEIGHT - magnitude, xc, yc);
	    	else
	 ;//     		ctx.moveTo(i * SPACER_WIDTH, CANVAS_HEIGHT - magnitude);
	        ctx.stroke();
	        ctx.fillRect(i * SPACER_WIDTH, 0, BAR_WIDTH, magnitude);
	  	}
	  	ctx.closePath();
	}
	catch(err){
		console.log(err);
	}

}

function onLoad(e) {
    var source = context.createMediaElementSource(audio);
    source.connect(analyser);
    analyser.connect(context.destination);
    rafCallback();
}

window.addEventListener('load', onLoad, false);

// voice recognizer


/*
recognizer.onresult = function(event){
	if(event.result.length > 0){
		var result = event.results[event.results.length - 1];
		var rval = result[0].transcript.toLowerCase();
		console.log(rval);
		if(rval == "play" || rval == "start" || rval == "begin"){
			window.audio.play();
		}
		else if(rval == 'pause' || rval == 'stop' || rval == 'end'){
			window.audio.pause();
		}
		else if(rval == 'repeat'){
			scp.$apply(function(){
				scp.flag = 1;
			});
		}
		else if(rval == 'suffle'){
			scp.$apply(function(){
				scp.flag = 3;
			});
		}
		else if(rval == 'linear'){
			scp.$apply(function(){
				scp.flag = 2;
			});
		}
	}
}
*/
var recognizer = new webkitSpeechRecognition();
recognizer.continuous = true;
recognizer.interimResults = true;
recognizer.lang = "en";
recognizer.onresult = function(event) {
    if (event.results.length > 0) {
        var result = event.results[event.results.length-1];
        if(result.isFinal) {
	   var scp = angular.element($("#mainc")).scope();
            var rval = result[0].transcript.toLowerCase().trim();
	    console.log(rval);
	    console.log(scp.logged);
	    if(rval == "play" || rval == "start" || rval == "begin"){
                        window.audio.play();
                }
                else if(rval == 'pause' || rval == 'stop' || rval == 'end'){
			console.log("stopping");
                        window.audio.pause();
                }
                else if(rval == 'repeat'){
                        scp.$apply(function(){
                                scp.flag = 1;
                        });
                }
                else if(rval == 'shuffle'){
			console.log("inside");
                        scp.$apply(function(){
                                scp.flag = 3;
                        });
                }
                else if(rval == 'linear'){
                        scp.$apply(function(){
                                scp.flag = 2;
                        });
                }

        }
    }  
};

function startRecord(){
	recognizer.start();
}

if(!webkitSpeechRecognition){
	document.getElementById("voice").display = "none";
}




