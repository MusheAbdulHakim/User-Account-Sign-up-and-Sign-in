<?php
require __DIR__ . '/config.php';
/*
* Tutorial: PHP Login Registration system
*
* Page: Application library
* */

class AppLib
{

  /*
   * Register New User
   *
   * @param $name, $email, $username, $password
   *
   * */
  public function Register($full_name,$username, $email,  $password)
  {
      try {
          $db = DataBase();
          $sql = "INSERT INTO users(FullName, UserName, Email, Password) VALUES (:fname,:uname,:email,:pass)";
          $query = $db->prepare($sql);
          $query->bindParam("fname", $full_name, PDO::PARAM_STR);
          $query->bindParam("uname", $username, PDO::PARAM_STR);
          $query->bindParam("email", $email, PDO::PARAM_STR);
          $enc_password = password_hash($password,PASSWORD_DEFAULT);
          $query->bindParam("pass", $enc_password, PDO::PARAM_STR);
          $query->execute();
          $lastinserid = $db->lastInsertId();
          if ($lastinserid>0) {
          	echo "<script>alert('Your account have successfully registered')</script>";
          }
      } catch (PDOException $e) {
          exit($e->getMessage());
      }
  }


  /*
       * Login
       *
       * @param $username, $password
       * 
       * */

       /*
    * Login
    *
    * @param $username, $password
    * 
    * */    public function Login($username, $password)
   {
       try {
           $db = DataBase();
           $sql ="SELECT UserName,Password FROM users WHERE (UserName=:usname)";
           $query= $db -> prepare($sql);
           $query-> bindParam(':usname', $username, PDO::PARAM_STR);
           $query-> execute();
           $results=$query->fetchAll(PDO::FETCH_OBJ);
           if($query->rowCount() > 0)
           {
             foreach ($results as $row) {
               $hashpass=$row->Password;
             }
             //verifying Password
             if(password_verify($password, $hashpass)) {
                 echo "<script>alert('You Login successfully')</script>";
               } else {
                 echo "<script>alert('You entered wrong password')</script>";

               }
           }
           //if username or email not found in database
           else{
              echo "<script>alert('User not registered with us')</script>";
           }
       } catch (PDOException $e) {
           exit($e->getMessage());
       }
   }
    
   

}

?>

