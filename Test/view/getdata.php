<?php
    $data = file_get_contents("data.json");
    $readData = json_decode($data);
    foreach($readData as $myobject)
	 {
	 foreach($myobject as $key=>$value)
	{
		echo "your ".$key." is ".$value."<br>";
	} 
	}
?>