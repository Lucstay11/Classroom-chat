<!DOCTYPE html>
<html lang="en">
<?php include("head.php");?>
<?php include("Database/User.php");
$listuser=$User->getInfo("listnom",'');
?>
<body class="vh-100" style="background-image:url(<?= $config['backgroundimage']?>);">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="https://img.freepik.com/vecteurs-premium/modele-conception-logo-chat-noir_373791-992.jpg"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                    <span class="h1 fw-bold mb-0"><?= $config['chat_name']?></span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h5>

                  <div class="form-outline mb-4">
                  <select class="form-control form-control-lg" id="user">
                    <?php foreach($listuser as $user){?>
                      <option value="<?= $user['nom']?>"><?= $user['nom']?></option>
                    <?php }?>
                    </select>
                    <label class="form-label" for="form2Example17">Pseudo</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" id="pass" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example27">Password</label>
                  </div> 
                    <p class="text-center text-danger" id="info"></p>
                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="button" onclick="login()">Log in</button>
                  </div>

              <div class="d-flex align-items-start">
               <?php $nb=0;?>
                <?php foreach($listuser as $user){?>
                    <?php if($user['etat']=="connecter" && $nb<5 ){?>
					  	      <div class="badge bg-success" style="border-radius:20px;font-size:0.6em;"><span style="opacity:0;">1</span></div>
						         <div class="d-flex align-items-start">
							        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="rounded-circle mr-1" style="box-shadow:0px 0px 8px black;height:40px;width:40px;">
								      <span style="font-size:0.7em;"><?= $user['nom']?></span>
						         </div>
                     <?php }?>
                     <?php $nb=$nb+1;?>
                <?php }?>
                 </div>






              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>

<script>
    function login(){
      if(user.value=="" || pass.value==""){info.textContent="empty field";}
        else{
        let data = new FormData();
        data.append("user",user.value);
        data.append("pass",pass.value);
        data.append("action","login");
         fetch("Database/User.php",{
            method:"POST",
            body:data,
         })
         .then((res)=>res.text())
         .then((result)=>{
          if(result=="0"){window.location.href = "chat.php";}
           else{
               info.textContent=result;
           }
         })
        }
      }
      addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
       login();
      }
     })
</script>