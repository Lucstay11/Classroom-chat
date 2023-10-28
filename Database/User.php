<?php
include("config.php");
include("Admin.php");
class User{
   public function __construct() {
     $this->date =date("D M j G:i:s");
   }
    function getInfo($data,$data2){
        require("connect.php");
        if($data=="listnom"){
        $list=[];
        $result = $database->query("SELECT id,nom,etat,last_co,pp_img,banni,banni_groupe,raison_banni,restreint_groupe FROM user ");
           while($row = $result->fetch()){
            array_push($list,[
                "id" => $row['id'],
                "nom" => $row['nom'],
                "etat" => $row['etat'],
                "last_co" => $row['last_co'],
                "pp_img" => $row['pp_img'],
                "banni" => $row['banni'],
                "banni_groupe" => $row['banni_groupe'],
                "raison_banni" => $row['raison_banni'],
                "restreint_groupe" => $row['restreint_groupe']
              ]);
          }
              return $list;
        }elseif($data=="connecter"){   
          $id=$_SESSION["id"];
          $res = $database->query("SELECT COUNT(*) as count FROM user WHERE etat='connecter' AND id!='$id'");
          $res = $res->fetch();
          return $res['count'];
        }elseif($data=="ecris"){
            $list=[];  
            $id=$_SESSION["id"]; 
            $res = $database->query("SELECT nom,pp_img FROM user WHERE ecris='on' AND id!='$id'");
            while($row = $res->fetch()){
              array_push($list,[
                "nom" => $row['nom'],
                "pp_img" => $row['pp_img'],
              ]);
          }
              return $list;  
        }else{
        $id=$data2=='session'?$_SESSION["id"]:$data2;
        $result = $database->query("SELECT $data FROM `user` WHERE id='$id' ");
        $result = $result->fetch();
             return $result[$data];
        }
      }
    
      function connect(){
        session_start();
        require("connect.php");
        $DATE=date("D M j G:i:s");
        $_SESSION["connect"] = false;
        $nom=$_POST['user'];
        $pass=$_POST['pass'];
        $user = $database->query("SELECT id,nom,pass,banni FROM `user` WHERE nom='$nom' ");
        $user = $user->fetch();
            if($user){
               if(!$user['banni']=='1'){ //Check if user is banned from chat
                if($user['nom']==$nom && $user['pass']==$pass){
                $_SESSION["connect"] = true;
                $_SESSION["id"] = $user['id'];
                $id=$_SESSION["id"];
                $database->query("UPDATE user SET etat='connecter' WHERE id='$id'");
                $database->query("UPDATE user SET last_co='$this->date' WHERE id='$id'");
                echo 0;
                }
                 else{echo "incorrect password";}

                }else{echo "You have been banned from chat";}
                }else{
                echo "User doesn't exist!";
            }
      }

      function deconnect(){
        session_start();
        require("connect.php");
        $id=$_SESSION["id"];
        $database->query("UPDATE user SET etat='deconnecter' WHERE id='$id'");
        $database->query("UPDATE user SET ecris='off' WHERE id='$id'");
        $_SESSION["connect"] = false;
        session_destroy();
      }

      function password($data){
        session_start();
        require("connect.php");
        $id=$_SESSION["id"];
        $database->query("UPDATE user SET pass='$data' WHERE id='$id'");
      }
 
      function change_pp($img){
        session_start();
        require("connect.php");
        $id=$_SESSION["id"];
        if(isset($_FILES['pp_file'])){
          //$res=$database->query("SELECT pp_img FROM user WHERE id_likeur='$id' ");
          //$res=$res->fetch(); //Delete the older pp file 
          $name_file=rand(1,1000000000);
          $path="files/avatar_upload/" . basename($name_file);
          if(move_uploaded_file($_FILES['pp_file']['tmp_name'],$path)){
            $database->query("UPDATE user SET pp_img='Database/files/avatar_upload/$name_file' WHERE id='$id'");
           }else{echo "Upload error check the size of your image";}
        }else{
          $database->query("UPDATE user SET pp_img='Database/files/avatar/$img' WHERE id='$id'");
        }
      }
}

 
if(isset($_POST['action']) && $_POST['action']=="login"){
(new User)->connect();
}
if(isset($_POST['action']) && $_POST['action']=="exit"){
(new User)->deconnect();
}
if(isset($_POST['action']) && isset($_POST['data']) && $_POST['action']=="password"){
(new User)->password(htmlspecialchars($_POST['data']));
}
if(isset($_POST['action']) && $_POST['action']=="change_pp"){
(new User)->change_pp($_POST['data']);
}

$User=new User();
?>
