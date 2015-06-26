function statusChangeCallback(response) {
  console.log('statusChangeCallback');
  console.log(response);
  if (response.status === 'connected') {
    testAPI();
  } else if (response.status === 'not_authorized') {
    document.getElementById('status').innerHTML = '';
  } else {
    document.getElementById('status').innerHTML = '';
  }
}

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

window.fbAsyncInit = function() {
FB.init({
  appId      : '1609190332693075',
  xfbml      : true,
  version    : 'v2.3'
});
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
};

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function testAPI(){
  console.log('Welcome!  Fetching your information.... ');
  FB.api('/me', function(response) {
    console.log('Successful login for: ' + response.name);
    console.log(response);
    document.getElementById('status').innerHTML = '';
    $.ajax({
      url : "session_start.php",
      method : "GET",
      data : { id : response.id }
    });
    var scope = angular.element($("#app")).scope();
    scope.$apply(function(){
        scope.myname = response.name;
        scope.myid = response.id;
    });
  });
  console.log('Fetching friends information.... ');
  FB.api('/me/friends?limit=5000', function(response) {
	console.log(JSON.stringify(response));
  var scope = angular.element($("#app")).scope();
    scope.$apply(function(){
        scope.friends = response.data;
    });
  });
}
