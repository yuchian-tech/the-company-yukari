<?php

    include "Database.php";

    /**
     * All the logic of our app will hear / This serves as the brain of our application
     */

    class User extends Database{
       /**
        * Method to insert/store the first_name, last_name, username , and password into the database table
        */
        public function store($request){
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];
            $password = $request['password'];

            # Hash the password for security
            $password = password_hash($password, PASSWORD_DEFAULT);

            # Query string
            $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`) VALUES('$first_name', '$last_name', '$username', '$password')";

            # Execute the query
            if ($this->conn->query($sql)) {
                header('location: ../views'); //redirect to login page if registration is successful
                exit;
            }else{
                die("Error in creating the user." . $this->conn->error);
            }
        }

        public function login($request){
            $username = $request['username'];
            $password = $request['password'];

            $sql = "SELECT * FROM users WHERE username = '$username'";

            $result = $this->conn->query($sql);

            # Check if username exists
            if ($result->num_rows == 1) {
                # check if password is correct
                $user = $result->fetch_assoc();
                //$user = ['id' => 1, 'username' => 'mary.watson', 'password' => '$77&^%_**7)=' ... ]

                # compare the password if it is the same in the database
                if (password_verify($password, $user['password'])) {
                    # initialize session variables
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['first_name'] . " " . $user['last_name'];

                    header('location: ../views/dashboard.php');
                    exit;
                }else {
                    die('Password is incorrect.');
                }
            }else {
                die('Username not found.');
            }
        }

        /**
         * Logout method
         */
        public function logout(){
            session_start();
            session_unset();
            session_destroy();

            header('location: ../views'); //redirect to login page
            exit;
        }
        /**
         * Get all the users
         */
        public function getAllUsers(){
            
            $sql = "SELECT id, first_name, last_name, username, photo FROM users";
            if ($result = $this->conn->query($sql)) {
                return $result;
            }else{
                die("Error retrieving all users. " . $this->conn->error);
            }

        }
        /**
         *  Get all the users
         */
        public function getUser($id){ // the $id is the ID of the currently logged-in user
            
            $sql = "SELECT * FROM users WHERE id = $id";

            if ($result = $this->conn->query($sql)) {
                return $result->fetch_assoc();
            }else {
                die("Error in retrieving user." . $this->conn->error);
            }
         }

        /**
          * Method use to update use details
          */
          public function update($request, $files){
            session_start();
            $id = $_SESSION['id'];  //current id-user
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];

            $photo = $files['photo']['name'];  //$files[name-of-the-field][name-of-the-uploaded-file]
            $tmp_photo = $files['photo']['tmp_name'];  //$files[name-of-the-field][temporary-storage]

            $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id= $id";

            if ($this->conn->query($sql)) {
                $_SESSION['username'] = $username;
                $_SESSION['full_name'] = "$first_name $last_name";

                # If there is an uploaded photo, save it to the db and save the file to the image folder
                if ($photo) { // check if the user uploaded a photo
                    $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";
                    $destination = "../assets/images/$photo";

                    # Save the image name to the database
                    if ($this->conn->query($sql)) {
                        //Save the file to the image folder
                        if (move_uploaded_file($tmp_photo, $destination)) {
                            header('location: ../views/dashboard.php');
                            exit;
                        }else{
                            die("Error in moving the photo");
                        }
                    }else {
                        die("Error in uploading the photo" . $this->conn->error);
                    }
                }
                header('location: ../views/dashboard.php');
                exit;
            }else {
                die("Error updating the user. " . $this->conn->error);
            }
          }

          /**
           * Method to delete account
           */
          public function delete(){
            session_start();
            $id = $_SESSION['id'];

            $sql = "DELETE FROM users WHERE id = $id";

            if ($this->conn->query($sql)){
                $this->logout();
            } else {
                die('Error deleting your account:' . $this->conn->error);
            }
          }
    }