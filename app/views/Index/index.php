     <div>
     	<h2>Log In</h2>
     	<form id="login_form" name="login_form" method="POST">
	        <input type="text" name="user_name" id="user_name" placeholder="Username" /><br>
	        <input type="password" name="password" id="password" placeholder="Password" /><br>
	        <input type="submit" name="login_btn" id="login_btn" value="Login" />
      	</form>
     </div>
     <script>
        $(function(){
          //$('#login_form').on('submit', function(e) {
          $('#login_btn').on('click', function() {
            if(!($("#login_form").validate())){
              return true;
            }else{
              var user = $('form[name=login_form] input[name=user_name]')[0].value;
              var pass = $('form[name=login_form] input[name=password]')[0].value;
              var url_user = "<?php echo URL;?>User/userLogin";
              var url_page = "<?php echo URL;?>Page/page";

              //Prevent to login without data in form
              if (user == "" || pass == "") {

              }else{
                   $.ajax({
                        type: 'POST',
                        url: url_user,
                        data: {user_name: user, password: pass},
                        success: function(response){
                                alert(response);
                                 if (response == 1) {
                                   document.location = url_page;
                                 }else{
                                   alert("Wrong user or password");
                                 }
                               }
                   });
                   return false;
                    //$.get(url_page);
              }
            }

          });

        });
     </script>

     
     