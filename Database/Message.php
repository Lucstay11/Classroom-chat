<?php
class Message{
      public function __construct() {
        $this->date =date("G:i");
        $this->data =isset($_POST['data'])?htmlspecialchars($_POST['data']):'';
        $this->file_upload =isset($_FILES['mess_file_upload'])?$_FILES['mess_file_upload']:'';
        $this->file_img =isset($_POST['mess_file'])?htmlspecialchars($_POST['mess_file']):'';
       }

      function voir(){ //Display the message
        require("connect.php");
        $list=[];
        $result = $database->query("SELECT id,contenu,id_destinateur,date_mess,nb_like,info,supprimer,img FROM message_groupe");
           while($row = $result->fetch()){
            array_push($list,[
                "id" => $row['id'],
                "contenu" => $row['contenu'],
                "id_destinateur" => $row['id_destinateur'],
                "date_mess" => $row['date_mess'],
                "nb_like" => $row['nb_like'],
                "info" => $row['info'],
                "img" => $row['img'],
                "supprimer" => $row['supprimer']
              ]);
          }
              return $list;       
      }

      function like($action,$data){
            require("connect.php");
            switch($action){
                case "like":
                  session_start();
                  $id=$_SESSION["id"];
                  $res=$database->query("SELECT id_message,id_likeur FROM likes WHERE id_message='$data' AND id_likeur='$id' ");
                  $res=$res->fetch();
                    if(empty($res['id_likeur'])){ //We check that the user has liked 1 time
                       $database->query("UPDATE message_groupe SET nb_like=nb_like+1 WHERE id='$data'");
                       $database->query("INSERT INTO likes (id_message, id_likeur) VALUES ('$data','$id')");
                       }
                 break;
                 case "dislike":
                  session_start();
                  $id=$_SESSION["id"];
                  $res=$database->query("SELECT id_message,id_likeur FROM likes WHERE id_message='$data' AND id_likeur='$id' ");
                  $res=$res->fetch();
                    if(!empty($res['id_likeur'])){ //We check that the user has disliked 1 time
                       $database->query("UPDATE message_groupe SET nb_like = CASE WHEN nb_like < 0 THEN 0 ELSE nb_like-1 END WHERE id='$data'");
                       $database->query("DELETE FROM likes WHERE id_message='$data' AND id_likeur='$id' ");
                    }
                 break;
                 case "verif":
                    $id=$_SESSION["id"];
                    $res=$database->query("SELECT id_message,id_likeur FROM likes WHERE id_message='$data' AND id_likeur='$id' ");
                    $res=$res->fetch();
                    if(empty($res['id_likeur'])){ return false;}else{ return true;}
                    break;
                 case "likeur":
                  $id=$_SESSION["id"];
                  $res=$database->query("SELECT id_likeur FROM likes WHERE id_message='$data'");
                  $res=$res->fetchAll();
                  return $res; 
                  break;
            }
      }
      function supprimer(){ //delete message from the chat
        require("connect.php");
        $id=$this->data;
        $database->query("UPDATE message_groupe SET contenu='The user to delete the message',supprimer='1',img='' WHERE id=$id");
        $res=$database->query("SELECT img FROM message_groupe WHERE id=$id");
        unlink($_SERVER['DOCUMENT_ROOT']."/".$res); //delete img from server

      }

      function envoyer(){ //send message
        session_start();
        require("connect.php");
        $id=$_SESSION["id"];
        $database->query("UPDATE user SET ecris='off' WHERE id='$id'");
        if(!empty($this->file_upload)){
           $ext = strtolower(pathinfo($_FILES['mess_file_upload']['name'], PATHINFO_EXTENSION));
           $name_file=rand(1,1000000000).".".$ext;
           $path="files/img/" . basename($name_file);
           if(move_uploaded_file($_FILES['mess_file_upload']['tmp_name'],$path)){
            $database->query("INSERT INTO message_groupe (contenu,id_destinateur,date_mess,img,nb_like,info,supprimer) 
             VALUES ('$this->data','$id','$this->date','Database/files/img/$name_file',0,'','')");
             }
          }else{
            $file_img=$this->file_img!=""?$this->file_img:'';
            $database->query("INSERT INTO message_groupe (contenu,id_destinateur,date_mess,img,nb_like,info,supprimer) 
            VALUES ('$this->data','$id','$this->date','$file_img',0,'','')");
          }
      }

      function ecris(){ //notify user when someone write!
        session_start();
        require("connect.php");
        $id=$_SESSION["id"];
         if($this->data=="on"){
           $database->query("UPDATE user SET ecris='on' WHERE id='$id'");
         }else{$database->query("UPDATE user SET ecris='off' WHERE id='$id'");} 
      }
      
      function groupname(){ // Change the group name
        session_start();
        require("connect.php");
        $id=$_SESSION["id"];
        $namegroupe=$database->query("SELECT nom_groupe FROM setting WHERE id='0'");
        $namegroupe=$namegroupe->fetch();
        $namegroupe=$namegroupe['nom_groupe'];
        $database->query("UPDATE setting SET nom_groupe='$this->data' WHERE id='0'");
        $database->query("INSERT INTO message_groupe (contenu,id_destinateur,date_mess,info,supprimer) 
        VALUES ('to change the name of the group','$id','changenamegroup','$namegroupe','$this->data') ");
      }
}


if(isset($_POST['action']) && $_POST['action']=="envoyer"){
    (new Message)->envoyer();
}
if(isset($_POST['action']) && ($_POST['action']=="like" || $_POST['action']=="dislike")){
    (new Message)->like($_POST['action'],$_POST['data']);
}
if(isset($_POST['action']) && $_POST['action']=="supprimer"){
    (new Message)->supprimer();
}
if(isset($_POST['action']) && $_POST['action']=="ecris"){
    (new Message)->ecris();
}
if(isset($_POST['action']) && $_POST['action']=="groupname"){
    (new Message)->groupname();
}

$Message=new Message();
?>