<?php
    session_start();

    $fname="";
    $lname ="";
    $language = array();
    
    $catagory = "";

if(isset($_POST["Submit"])){
    $error = 0;
    echo"<br><br><h2>Registration Confirmation</h2>";
    $fname = $_POST["fname"];
    if(empty($fname)){
        echo"Enter a valid first name.<br>";
        $error = 1;
    }
    else{
        echo"Your first name is ".$fname."<br>";
        $_SESSION["fname"] = $_POST["fname"];
    }
    
    $lname = $_POST["lname"];
    if(empty($lname)){
        echo"Enter a valid last name.<br>";
        $error = 1;
    }
    else{
        echo"Your last name is ".$lname."<br>";
        $_SESSION["lname"] = $_POST["lname"];
    }

    $age = $_POST["age"];
    if(empty($age)){
        echo"Enter valid age.<br>";
        $error = 1;
    }
    else{
        echo"Your age is ".$age."<br>";
    }

    $password = $_POST["pwd"];
    if(empty($password) || strlen($password)<7){
        echo("Password must be more than 7 charecter.<br>");
        $error = 1;
    }

    if(!isset($_POST["language"]))
    {
        echo"please select a radio button.<br>";
        $error = 1;
    }
    else{
        if(isset($_POST["language"]) && $_POST["language"] == "r1")
        {
            echo"you have selected junior programmer.<br>";
            $catagory = "Junior Programmer";
        }
        if(isset($_POST["language"]) && $_POST["language"] == "r2")
        {
            echo"you have selected senior programmer.<br>";
            $catagory = "Senior Programmer";
        }
        if(isset($_POST["language"]) && $_POST["language"] == "r3")
        {
            echo"you have selected project director.<br>";
            $catagory = "Project Manager";
        }
    }

    if( !isset($_POST["language4"]) && !isset($_POST["language5"]) && !isset($_POST["language6"])){
        echo"please select a checkbok.<br>";
        $error = 1;
    }
    else{

        if(isset($_POST["language4"])){
            echo"you have selected Java.<br>";
            $language[] = "Java";
        }
        if(isset($_POST["language5"])){
            echo"you have selected C++.<br>";
            $language[] = "C++";
        }
        if(isset($_POST["language6"])){
            echo"you have selected PHP.<br>";
            $language[] = "PHP";
        }
    }
    $email = $_POST["email"];
    if(empty($email) || !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$email)){
        echo"Invalid mail.<br>";
        $error = 1;
    }
    else{
        $flag = 0;
        $data = file_get_contents("data.json");
        $readData = json_decode($data);

        foreach($readData as $myobject)
	    {
	        foreach($myobject as $key=>$value)
    	    {
		        if($key == "email" && $value == $_POST["email"])
                $flag = 1;
	        } 
    	}
        if($flag == 1){
            echo "Email already exists.<br>";
            $error = 1;
        }
    }

    $name = "../files/".$_FILES["myfile"]["name"];
    if(pathinfo(move_uploaded_file($_FILES["myfile"]["tmp_name"],"../files/".$_FILES["myfile"]["name"]))) {
       
        echo"File Uploaded, Size: ".(filesize($name)/1000000)." MB.<br>";
    }
    else{
        echo"error File.<br>";
        $error = 1;
    }
    echo $error;
    if($error == 1 ){
        $len = count($language);
        if($len == 1){
            $formdata = array( 
                'email'=>$_POST["email"],
                'password'=> $_POST["pwd"],
                'firstName'=> $_POST["fname"],
                'lastName'=> $_POST["lname"],
                'age' => $_POST["age"],
                'language'=> $language[0]
             );
        }
        else if($len == 2){
            $formdata = array( 
                'email'=>$_POST["email"],
                'password'=> $_POST["pwd"],
                'firstName'=> $_POST["fname"],
                'lastName'=> $_POST["lname"],
                'age' => $_POST["age"],
                'language'=> $language[0].",".$language[1]
             );
        }
        else if($len == 3){
            $formdata = array( 
                'email'=>$_POST["email"],
                'password'=> $_POST["pwd"],
                'firstName'=> $_POST["fname"],
                'lastName'=> $_POST["lname"],
                'age' => $_POST["age"],
                'language'=> $language[0].",".$language[1].",".$language[2]
             );
        }
        
         $existingdata = file_get_contents('data.json');
         $tempJSONdata = json_decode($existingdata);
         $tempJSONdata[] =$formdata;
         //Convert updated array to JSON
         $jsondata = json_encode($tempJSONdata, JSON_PRETTY_PRINT);
         
         //write json data into data.json file
         if(file_put_contents("data.json", $jsondata)) {
              echo "Data successfully saved <br>";
              header("location:../view/test2.php");
          }
         else 
              echo "no data saved";
  
    }
    else{
        echo "error in json writing";
        $error = 0;
    }


}

?>