<?php

    
    #$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
    require 'db.php';
    $input_name = $_POST["uname"];

    $auth1 = $db->prepare("SELECT password, uid FROM user where username = ?");
    $auth1->bind_param("s", $input_name);
    $auth1->execute();
    $authen1 = $auth1->get_result();

    #$auth1 = "SELECT password, uid FROM user where username = ";
    #$auth1 .= "'".$input_name."'";
   	#$authen1 = $db->query($auth1);

   	if (!$authen1){
   		echo "Something wrong!!";
   		showerror();				# if query faild, show error message.
   	}



    $auth2 = $db->prepare("SELECT password, uid FROM user where email = ?");
    $auth2->bind_param("s", $input_name);
    $auth2->execute();
    $authen2 = $auth2->get_result();
    #$auth2 = "SELECT password, uid FROM user where email = ";
    #$auth2 .= "'".$input_name."'";
    #$authen2 = $db->query($auth2);

    if (!$authen2){
      echo "Something wrong!!";
      showerror();        # if query faild, show error message.
    }


	session_start();

    #check username
   	if(mysqli_num_rows($authen1)==1){
      while ($row = $authen1->fetch_assoc()){
        $password = $row['password'];
        $uid = $row['uid'];
      }

      if (md5($_POST["psw"]) == $password){
        #$_SESSION["username"] = $input_name;
        $_SESSION["uid"] = $uid;

        #################
        #set cookie
        #################

        setcookie("cookie_uid", $uid ,time()+600, "/");
        header("Location: mainpage.php");

      }

      else{
        $_SESSION["message"] = "Wrong username or passwrod! ";
        // Relocate to the logout page
        echo $_SESSION["message"];
        session_destroy();
        exit;
      }
   }

   #check email
   else if(mysqli_num_rows($authen2)==1){
      while ($row = $authen2->fetch_assoc()){
        $password = $row['password'];
        $uid = $row['uid'];
      }
      if (md5($_POST["psw"]) == $password){
        #$_SESSION["username"] = $input_name;
        $_SESSION["uid"] = $uid;

        #################
        #set cookie
        #################
        setcookie("cookie_uid", $uid ,time()+600, "/");

        header("Location: mainpage.php");

      }

      else{
        $_SESSION["message"] = "Wrong username or passwrod! ";
        // Relocate to the logout page
        echo $_SESSION["message"];
        session_destroy();
        exit;
      }

   }

	 else{					#if no such user, echo error
	 $_SESSION["message"] = "Wrong username or passwrod! ";
    	// Relocate to the logout page
  	 echo $_SESSION["message"];

  	 session_destroy();
  	 exit;
	}


