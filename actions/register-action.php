<?php   
    include "../classes/User.php";

    #Create or instantiate an object
    $user = new User;

    #Call the store method
    $user->store($_POST);
    /**
     * Note: The $_POST holds the data coming from the form(first_name, last_name, username, password)
     */