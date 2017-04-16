username = "";

function login(){
	// proccess
	// api launch 
	var data = {};
	data.username = $("#username").val();
	data.passwd = $("#password").val();

	data['operation']='login';
	$.ajax({
	    url: 'api/api.php', // your api url
	    method: 'POST', // method is any HTTP method
	    data: data, // data as js object
	    success: function(response) {
			if (response['status'] == "OK"){
				showLogin(false);
				showVote(true);	
				username=$("#username").val();
				$('#user').html(username + "'s vote pref:");
				getVotes();
			}
		},
	    error: function (data){
	    	$('#error').html("Invalid Log In");
	    },
	    async: false
	});
}

function getVotes(){

	var data = {};
	data['operation']='getVotes';
	console.log(data);
	$.ajax({
	    url: 'api/api.php', // your api url
	    method: 'GET', // method is any HTTP method
	    data: data, // data as js object
	    success: function(response) {
			if (response['status'] == "OK"){
				$("#extend").html(response['extend']);
				$("#dontextend").html(response['dontextend']);
			}
		},
	    async: false
	});
}

function showLogin(value){
	if(value){
		$('#loginPage').show();
	}else {
		$('#loginPage').hide();
	}
}

function showVote(value){
	if(value){
		$('#votePage').show();
	}else {
		$('#votePage').hide();
	}
}