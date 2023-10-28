function action(action,data){
    let log= new FormData();
    log.append("action",action);
    log.append("data",data);
    log.append('pp_file', ppfile.files[0]);
    if(boxpreloadsendimg.style.display=="block"){
    log.append('mess_file', preloadsendimg.src);
    }
    log.append('mess_file_upload', filemessinput.files[0]);
    name_file=action=="exit"||action=="password"||action=="change_pp"?"User":"Message";
    fetch(`Database/${name_file}.php`,{
        method:"POST",
        body: log,
       })
      .then((response) => response.text())
      .then((res) => {
              switch(action){
                case "exit":           
                  window.location.href = "index.php";
                break;
                case "envoyer":
                  messagegroupe.value="";
                  preloadsendimg.src="";
                  filemessinput.value="";
                  boxpreloadsendimg.style.display="none";
									btnsendmess.style.opacity='0';
                break;
                case "password":
                  passinfo.textContent="Mot de passe changer!";
                break;
                case "change_pp":
                  ppinfo.textContent=res;
                break;
              }
          })
  }
  function admin(action,data,data2){
    let log= new FormData();
    log.append("action",action);
    log.append("data",data);
    log.append("data2",data2);
    fetch(`Database/Admin.php`,{
        method:"POST",
        body: log,
       })
      .then((response) => response.text())
      .then((res) =>{})
  }

function view(action){
  switch(action){
    case "chat-bot":
    if(chatbot.style.display=="none"){
        chatbot.style.display="block";
        chatclasse.style.height="0px";
      }else{
        chatbot.style.display="none";
        chatclasse.style.height="800px";
        chatclasse.style.display="block";
      }
        break;
    case "set-user":
      if(boxuserset.style.display=="none"){
         boxuserset.style.display="block";
      }else{
         boxuserset.style.display="none";
      }
        break;
    case "group-name":
      if(groupname.style.display=="block"){
         groupname.style.display="none";
         igroupname.style.display="block";
      }else{
         groupname.style.display="block";
         igroupname.style.display="none";
      }
        break;
  }
}

function envoyer(data){if(messagegroupe.value!=="" || preloadsendimg.src!==""){action("envoyer",data);}}
function ecris(){if(messagegroupe.value!==""){action("ecris","on");}else{action("ecris","off");}}
function password(){
  setTimeout(()=>{passinfo.textContent="";userpass1.value="";userpass2.value=""},1500);
  if(userpass1.value == userpass2.value && userpass1.value!=="" && userpass2.value!==""){action("password",userpass2.value);}else{passinfo.textContent="Mot de passe non identique!";}
}
function changegroupname(data){if(igroupname.value!==""){action("groupname",data);view('group-name');}}
function like(act,data){action(act,data);}
function change_pp(data,avatar){
      switch(data){
        case "import":
         action('change_pp','');
        break;
        case "avatar":
          if(avatar!==""){
            action('change_pp',avatar);
           }
        break;
        case "delete":
          $("#viewpp").load(window.location.href + " #viewpp" );
        break;
   }
}
function adduser(){
 if(newusername.value!=""||newuserpass.value!=""){
  admin("adduser",newusername.value,newuserpass.value)
  newusername.value="";newuserpass.value=""
}
 else{newuserinfo.textContent="fill in all fields"}
}
function deleteuser(){
  admin("deluser",newusername.value,"")
}


setInterval(() => {
$(".chat-messages").load(window.location.href + " .chat-messages" );
$("#listuserstatus").load(window.location.href + " #listuserstatus" );
$("#listusersecris").load(window.location.href + " #listusersecris" );
$("#statusgroup").load(window.location.href + " #statusgroup" );
}, 500);

addEventListener('keypress', function (e) {
  if (e.key === 'Enter') {
    envoyer(messagegroupe.value);
  }
})

  function scrollTopChatGroup(){
  var objDiv = document.querySelector(".chat-messages");
  objDiv.scrollTop = objDiv.scrollHeight;
  }
  scrollTopChatGroup();
