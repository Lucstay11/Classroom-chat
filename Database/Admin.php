<?php
  class Admin{
        public function __construct(){
          $this->date =date("G:i");
          $this->action =isset($_POST['action'])?htmlspecialchars($_POST['action']):'';
          $this->data =isset($_POST['data'])?htmlspecialchars($_POST['data']):'';
          $this->data2 =isset($_POST['data2'])?htmlspecialchars($_POST['data2']):'';
        }

        function getInfo($data){
           require("connect.php");
           $result = $database->query("SELECT nom_groupe FROM `setting` WHERE id='0' ");
           $result = $result->fetch();
           return $result[$data];
        }

        function messageGroupe(){
          require("connect.php");
           switch($this->action){
              case "del_message_groupe":
                $database->query("UPDATE message_groupe SET contenu='Admin to delete the message for non-compliance with the rules',supprimer='1',img='' WHERE id='$this->data'");
                break;
              case "bannir":
                $database->query("UPDATE user SET banni='1' WHERE id='$this->data'");
                break;
              case "debannir":
                $database->query("UPDATE user SET banni='0' WHERE id='$this->data'");
                break;
              case "bannir_groupe":
                $database->query("UPDATE user SET banni_groupe='1',raison_banni='$this->data2' WHERE id='$this->data'");
                $database->query("INSERT INTO message_groupe (contenu,id_destinateur,date_mess,info,supprimer) 
                VALUES ('Admin banned from group','$this->data','changenamegroup','$namegroupe','$this->data') ");
                break;
              case "debannir_groupe":
                $database->query("UPDATE user SET banni_groupe='0',raison_banni='' WHERE id='$this->data'");
                break;
              case "restriction_groupe":
                $database->query("UPDATE user SET restreint_groupe='$this->data2' WHERE id='$this->data'");
                break;
           }
        }
        
        function addUser(){
          require("connect.php");
          $name=$this->data;
          $pass=$this->data2;
          if($name!=""&&$pass!=""){
          $database->query("INSERT INTO user (statut,nom,pass,etat,pp_img,ecris,last_co,banni,banni_groupe,raison_banni,restreint_groupe) VALUES ('user','$name','$pass','deconnecter','https://bootdey.com/img/Content/avatar/avatar2.png','off','',0,0,'',0)");
          }
        }

        function deleteUser(){
          require("connect.php");
          $id=$this->data;
          $database->query("DELETE FROM user WHERE id=$id");
          $database->query("DELETE FROM likes WHERE id_likeur=$id");
          $database->query("DELETE FROM message_groupe WHERE id_destinateur=$id");
        }
  }

  if(isset($_POST['action']) && ($_POST['action']=="del_message_groupe"||$_POST['action']=="bannir"||$_POST['action']=="debannir"
         ||$_POST['action']=="bannir_groupe"||$_POST['action']=="debannir_groupe"||$_POST['action']=="restriction_groupe")){
  (new Admin)->messageGroupe();
  }

  if(isset($_POST['action']) && $_POST['action']=="adduser"){
  (new Admin)->addUser();
  }

  if(isset($_POST['action']) && $_POST['action']=="deluser"){
  (new Admin)->deleteUser();
  }

  $Admin=new Admin();
?>