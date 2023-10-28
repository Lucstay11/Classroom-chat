<!DOCTYPE html>
<html lang="en">
<?php session_start();?>
<?php if($_SESSION['connect']==false){header("Location: index.php");exit();}?>
<?php 
include("head.php");
include_once("Database/User.php");
include_once("Database/Message.php");
$listuser=$User->getInfo("listnom",'all');
?>

<body class="bg-dark">
<section class="content" id="chatclasse" style="transition:all 1s;">
    <div class="container p-0">
		<div class="card" style="box-shadow: 0px 0px 6px black;border-radius:10px;">
			<div class="row g-0">
				<div class="col-12 col-lg-5 col-xl-3 border-right">
						<div class="d-flex align-items-center">
                            <div id="viewpp"><img id="viewppimg" src="<?= $User->getInfo("pp_img",'session')?>" class="rounded-circle mr-1" style="box-shadow:0px 0px 6px black;height:60px;width:60px;"></div>
								<p style="font-weight:800;"><?= $User->getInfo("nom",'session')?></p>
								<button  onclick="view('set-user');" data-toggle="collapse" href="#boxuserset" style="display:block;margin:0 auto;"><img height="30" src="https://www.pngitem.com/pimgs/m/226-2261456_user-setting-user-setting-icon-png-transparent-png.png"></button>
								<button onclick="action('exit')" style="display:block;margin:0 auto;"><img src="https://png.pngtree.com/png-vector/20190425/ourmid/pngtree-vector-logout-icon-png-image_991952.jpg" height="30"></button>
						</div>
                               <div id="boxuserset" style="display:none;">
                                  <br>
                                  <p class="text-center" style="font-weight:600;"><img height="20" style="border-radius:20px;" src="https://png.pngtree.com/png-vector/20190326/ourmid/pngtree-vector-clock-icon-png-image_865317.jpg">Last login</p>
                                  <p class="text-center" style="font-size:0.9em;"><?= $User->getInfo("last_co",'session')?></p>
								   <hr>
                                  <p class="text-center" style="font-weight:600;"><img height="20" src="https://png.pngtree.com/png-vector/20190508/ourmid/pngtree-gallery-vector-icon-png-image_1028015.jpg">Change your image profil</p>
								    <div class="box-setting-user" id="boxsetfile" style="display:block;">
									  <p class="text-center" style="font-weight:800;">Choose your avatar</p>
									       <div style="text-align:center;">
											<?php 
                                            $files = scandir("Database/files/avatar/");
                                            foreach($files as $file){
											if (!in_array($file, array(".", ".."))) {	
											?>
											<img onclick="viewppimg.src=this.src;addavatar.name='avatar';addavatar.value=this.name" name="<?=$file?>" src="Database/files/avatar/<?=$file?>" class="rounded-circle mr-1 ppimg" style="box-shadow:0px 0px 6px black;height:40px;width:40px;">
											 <?php }}?>
										 </div>
										 <span id="delppimg" onclick="change_pp('delete')" class="material-symbols-outlined" style="color:crimson;float:left;opacity:1;transition:all 1s;">do_not_disturb_on</span>
										 <hr>
										 
										 <p class="text-center" style="font-weight:800;">Import your image</p>
										 <label for="ppfile" style="display: block; margin: 0 auto; width: fit-content;">
							              <img src="https://image.freepik.com/vecteurs-libre/illustration-icone-galerie_53876-27002.jpg" height="80">
                                        </label>
								         <input id="ppfile" style="display:none;" type="file" accept="image/png, image/jpeg">
										     <p id="ppinfo" class="text-center"></p>

                                      <script>
                                         ppfile.addEventListener('change', (event) => {
                                         const file = event.target.files[0];
                                         if (file && file.type.startsWith('image/')) {
                                         const reader = new FileReader();
                                          reader.addEventListener('load', (event) => {
                                          viewppimg.src = event.target.result;
										  addavatar.name='import';
                                        });
                                         reader.readAsDataURL(file);
                                          }
                                        }); 
									  </script>
									<br>
								   <button id="addavatar" class="btn btn-secondary" name='avatar' style="display:block;margin:0 auto;box-shadow:0px 0px 6px black;" onclick="change_pp(this.name,this.value)">Change</button>
                                    <br>  
								  </div>
                                  <button class="d-block m-auto" data-toggle="collapse" data-target="#boxpassuser" href="#boxpassuser" style="font-weight:800;"><img height="20" src="https://icons-for-free.com/iconfiles/png/512/Lock-1320568043107965480.png">Change password</button>
                                   <div id="boxpassuser" class="collapse">
								  <input id="userpass1" type="password" class="form-control" style="display:block;margin:0 auto;" placeholder="New password">
								   <input id="userpass2" type="password" class="form-control" style="display:block;margin:0 auto;" placeholder="Confirm password">
                                    <br>
									<p id="passinfo" class="text-center text-danger"></p>
								   <button onclick="password()" class="btn btn-success" style="display:block;margin:0 auto;box-shadow:0px 0px 6px black;">Change</button>
                                   </div>
								   <?php if($User->getInfo("statut",'session')=="admin"){?>
									<br>
                                    <button class="d-block m-auto" data-toggle="collapse" data-target="#boxnewuser" href="#boxnewuser" style="font-weight:800;"><img height="20" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/New_user_icon-01.svg/1200px-New_user_icon-01.svg.png">Add new user</button>
                                   <div id="boxnewuser" class="collapse">
								  <input id="newusername" type="text" class="form-control" style="display:block;margin:0 auto;" placeholder="name">
								   <input id="newuserpass" type="password" class="form-control" style="display:block;margin:0 auto;" placeholder="pass">
                                    <br>
									<p id="newuserinfo" class="text-center text-danger"></p>
								   <button onclick="adduser()" class="btn btn-success" style="display:block;margin:0 auto;box-shadow:0px 0px 6px black;">Add user</button>
                                   </div>
									<?php }?>
								</div>
                   <hr>


            <div id="listuserstatus">
				<?php 
				$listetat=$User->getInfo("listnom",'all');
				usort($listetat, function($a, $b) {
					if ($a['etat'] == 'connecter' && $b['etat'] == 'deconnecter') {
						return -1;
					} elseif ($a['etat'] == 'deconnecter' && $b['etat'] == 'connecter') {
						return 1;
					} else {
						return 0;
					}
				});
				?>	
                <?php foreach($listetat as $user){?>
                  <?php if($user['nom']!=$User->getInfo("nom",'session')){?>
					<a class="list-group-item list-group-item-action border-0">
						<div class="badge <?php if($user['etat']=="connecter"){echo "bg-success";}else{echo "bg-secondary";}?> float-right" style="border-radius:20px;"><span style="opacity:0;">1</span></div>
						<div class="d-flex align-items-start">
							<img src=" <?= $user['pp_img']?>" class="rounded-circle mr-1" style="height:40px;width:40px;">
							<div class="flex-grow-1 ml-3">
								 <?= $user['nom']?>
								<div class="small"><span class="fas fa-circle chat-online"></span><?php if($user['etat']=="connecter"){echo "<p class='text-success'>Online</p>";}else{echo "Offline";echo "<br><p style='font-size:0.8em;'>Last login:<br>".$user['last_co']."</p>";}?></div>
							</div>
							<?php if($User->getInfo("statut",'session')=="admin"){?>
							<img src="https://www.svgrepo.com/show/131974/settings.svg" style="height:20px;" data-toggle="collapse" data-target="#boxadmin<?=$user['nom']?>" href="#boxadmin<?=$user['nom']?>">
                            <?php }?>
						</div>
					</a>
					         <?php if($User->getInfo("statut",'session')=="admin"){?>
	                            <div id="boxadmin<?=$user['nom']?>" class="collapse">
                                     <p class="text-center" style="font-weight:700;">Restrict from group<img class="rounded-circle mr-1" src="<?= $config['backgroundimage']?>" width="20" height="20"></p>
                                      <select class="btn btn-secondary" style="display:block;margin:0 auto;font-size: 12px;" oninput="admin('restriction_groupe',<?=$user['id']?>,this.value)">
									  <option value="aucun">None</option>
									  <option value="ralenti">Message slow motion</option>
									  <option value="spectateur">Spectator mode</option>
									  </select>
									 <p class="text-center" style="font-weight:700;">Ban from group<img class="rounded-circle mr-1" src="https://cdn-icons-png.flaticon.com/512/59/59805.png" width="20" height="20"></p>
                                      <input id="raisonban<?= $user['nom']?>" style="display:block;margin:0 auto;" type="text" placeholder="reason of ban"><br>
									 <button class="btn <?=$user['banni']=='0'?'btn-danger':'btn-success'?>" onclick="admin(`${this.value}_groupe`,<?=$user['id']?>,raisonban<?= $user['nom']?>.value);if(this.value=='bannir'){this.value='debannir';this.textContent='debannir'}else{this.value='bannir';this.textContent='bannir'}" value="<?=$user['banni']=='0'?'bannir':'debannir'?>" style="display:block;margin:0 auto;box-shadow:0px 0px 4px black;font-size: 12px;"><?=$user['banni_groupe']=='0'?'bannir':'debannir'?></button>
									 <p class="text-center" style="font-weight:700;">Ban from chat<img class="rounded-circle mr-1" src="https://cdn.pixabay.com/photo/2015/12/27/14/52/panel-1109861_960_720.png" width="20" height="20"></p>
									 <button class="btn <?=$user['banni']=='0'?'btn-danger':'btn-success'?>" onclick="admin(this.value,<?=$user['id']?>);if(this.value=='bannir'){this.value='debannir';this.textContent='debannir'}else{this.value='bannir';this.textContent='bannir'}" value="<?=$user['banni']=='0'?'bannir':'debannir'?>" style="display:block;margin:0 auto;box-shadow:0px 0px 4px black;font-size: 12px;"><?=$user['banni']=='0'?'bannir':'debannir'?></button>

									 <p class="text-center" style="font-weight:700;">Delete this user<img class="rounded-circle mr-1" src="https://cdn-icons-png.flaticon.com/512/216/216658.png" width="20" height="20"></p>
									 <button class="btn btn-danger" onclick="admin('deluser',<?=$user['id']?>,'')" style="display:block;margin:0 auto;box-shadow:0px 0px 4px black;font-size: 12px;">Delete</button>
								</div>
							<?php }?>
                    <?php }?>
                  <?php }?>
					<hr class="d-block d-lg-none mt-1 mb-0">
				</div>
			</div>



				<div class="col-12 col-lg-7 col-xl-9">
					<div class="py-2 px-4 d-none d-lg-block">
						<div class="d-flex align-items-center py-1">
						<div class="position-relative">
								<img src="<?= $config['backgroundimage']?>" class="rounded-circle mr-1" width="40" height="40">
							</div>
							<div class="flex-grow-1 pl-3">
								<strong id="groupname"><?=$Admin->getInfo('nom_groupe')?></strong>
								<input id="igroupname" onchange="changegroupname(igroupname.value)" style="display:none;" type="text">
								 <script>
									igroupname.value=groupname.textContent;
								 </script>
								<div class="text-muted small" id="statusgroup"><em style="font-size:1.4em;"><?php if($User->getInfo("connecter",'all')==0){echo "None online";}else{echo $User->getInfo("connecter",'all')." online";}?></em></div>
							</div>
							<div>
								<button onclick="view('group-name')"><img src="https://cdn-icons-png.flaticon.com/512/6325/6325975.png" height="30"></button>
								<button onclick="view('group-bg')"><img style="border-radius:20px;box-shadow:0px 0px 4px black;" src="https://i.pinimg.com/originals/6b/bf/84/6bbf84605c40f64fb2c20eacfff2e068.png" height="30"></button>
								
							</div>
						</div>
				</div>



<?php if($User->getInfo("banni_groupe",'session')=='0'){?>

					<div class="position-relative" style="height:50%;width:100%;overflow:auto;">
						<div class="chat-messages p-4">
                    <?php foreach($Message->voir() as $message){?>
                        <?php if($message['id_destinateur']!=$User->getInfo("id",'session') || $message['supprimer']!='1' && $message['date_mess']!="changenamegroup"){?>
						
							<div class="chat-message-<?php if($message['id_destinateur']==$User->getInfo("id",'session')){echo "right";}else{echo "left";}?> pb-4">
							<?php if($message['id_destinateur']==$User->getInfo("id",'session')){?>
     							<span data-id="<?= $message['id']?>" onclick="action('supprimer',this.dataset.id)" style="font-size:1em;color:grey;" class="material-symbols-outlined">delete</span>
                             <?php }?>
								<div>
									 <div style="position: relative;display: inline-block;">
									<img src='<?php if($message['id_destinateur']==$User->getInfo('id','session')){echo $User->getInfo('pp_img','session');}else{?> <?=$User->getInfo("pp_img",$message['id_destinateur'])?> <?php }?>' class="rounded-circle mr-1" style="box-shadow:0px 0px 8px black;height:40px;width:40px;">
							        </div>
									<div class="text-muted small text-nowrap mt-2"><?= $message['date_mess']?></div>
								</div>
								<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3" style="position: relative;display: inline-block;">
									<div class="font-weight-bold mb-1"><?php if($message['id_destinateur']==$User->getInfo("id",'session')){echo "You";}else{ if($User->getInfo("statut",$message['id_destinateur'])=="admin"){echo "<img src='https://www.pngitem.com/pimgs/m/247-2472278_admin-admin-icon-png-transparent-png.png' style='height:20px;'>";};echo $listuser[$message['id_destinateur']-1]['nom'];}?></div>
			                            <?php if(!$message['img']==""){?>
										<img src="<?=$message['img']?>" style="height:100px;width:100px;"><br>
										<?php }?>
                                        <?php if(!$message['supprimer']=='1'){?>
										      <?= $message['contenu']?>
										<?php }else{?>
											  <em style="font-weight:600;"><?= $message['contenu']?></em>
										<?php }?>
								</div>
								<?php 
									 if($message['nb_like']!=0 && !$Message->like('verif',$message['id'])){

									?>
								         <span style="font-size:1em;color:red;" class="material-symbols-outlined" onclick="like('like',<?= $message['id']?>)">favorite</span><span style="font-size:0.7em;"><?=$message['nb_like']?></span>
                                         <?php }else{?>      
                                               <?php if($Message->like('verif',$message['id'])){?>
    											<img height="40" src="https://media.toucharger.com/web/toucharger/upload/image_domain/7/5/75431/200x200-75431.gif" onclick="like('dislike',<?= $message['id']?>)"><span style="font-size:0.7em;"><?=$message['nb_like']?></span>
                                               <?php }else{?>
												<span style="font-size:1em;" class="material-symbols-outlined" onclick="like('like',<?= $message['id']?>)">favorite</span>
                                                <?php }?>
										 <?php }?>
										              <?php if($User->getInfo("statut",$message['id_destinateur'])!="admin" && $User->getInfo("statut",'session')=='admin'){?>
														<span data-id="<?= $message['id']?>" onclick="admin('del_message_groupe',this.dataset.id)" style="font-size:1em;color:grey;" class="material-symbols-outlined">delete</span>
													  <?php }?>
										</div>
							 <?php }?>

							 <div class="chat-message-<?php if($message['id_destinateur']==$User->getInfo("id",'session')){echo "right";}else{echo "left";}?>" style="display:flex;margin-top:-10px;width:10px;">
							  <?php foreach($Message->like('likeur',$message['id']) as $likeur){?>
							 <img src="<?=$User->getInfo("pp_img",$likeur[0])?>" class="rounded-circle mr-1" style="height:20px;width:20px;">
							 <img style="height:20px;" src="https://media.toucharger.com/web/toucharger/upload/image_domain/7/5/75431/200x200-75431.gif">
							  <?php }?>
							 </div>

							   <?php if($message['date_mess']=="changenamegroup"){?>
							      <p class="text-center"> <span class="text-primary"><?=$User->getInfo('nom',$message['id_destinateur'])?></span> <em class="text-secondary"><?= $message['contenu']?></em><span> <?= $message['info']?><em class="text-secondary"> en</em> <?= $message['supprimer']?></span></p>
							   <?php }?>
                      <?php }?>
						</div>
					</div>


                    <div id="listusersecris" style="display:flex;">
                    <?php foreach($User->getInfo("ecris",'all') as $user){?>
					<div class="">
								<img src="<?=$user['pp_img']?>" class="rounded-circle mr-1" style="height:20px;width:20px;">
							</div>
							<div class="flex-grow-1 pl-3">
								<strong style="font-size:0.7em;"><?=$user['nom']?></strong>
								<div class="text-muted small"><em>write<img height="25" src="https://www.dnb.co.uk/content/dam/english/image-library/Modernization/other/loading-dots.gif"></em></div>
							</div>
                    <?php }?>
				   </div>
                             
<?php if($User->getInfo("restreint_groupe",'session')!='spectateur'){?>   
					<div class="flex-grow-0 py-3 px-4 border-top">

                         <div id="boxpreloadsendimg" style="display:none;margin-bottom:20px;">
						 <img id="preloadsendimg" style="height:150px;width:150px;">
						 <span id="delppimg" onclick="boxpreloadsendimg.style.display='none';preloadsendimg.src='';filemessinput.value=''" class="material-symbols-outlined" style="color:crimson;float:left;">do_not_disturb_on</span>
					     </div>

						<div class="input-group" style="display:flex;align-items:center;">
							<img data-toggle="collapse" data-target="#boxsmiley" href="#boxsmiley" src="https://tibs.at/sites/default/files/styles/artikelbilder_colorbox_gross/public/2019-01/01_17.png" height="30">
						    <label for="filemessinput">
							  <img src="https://image.freepik.com/vecteurs-libre/illustration-icone-galerie_53876-27002.jpg" height="40">
                            </label>
                            <input id="filemessinput" type="file" style="display: none;" accept="image/png, image/jpeg image/gif">
							<input type="text" class="form-control" id="messagegroupe" placeholder="Enter your message" oninput="ecris();if(this.value==''){btnsendmess.style.opacity='0'}else{btnsendmess.style.opacity='1'};">
							<script>
                                         filemessinput.addEventListener('change', (event) => {
                                         const file = event.target.files[0];
                                         if (file && file.type.startsWith('image/')) {
                                         const reader = new FileReader();
                                          reader.addEventListener('load', (event) => {
										  boxpreloadsendimg.style.display="block";
										  preloadsendimg.src = event.target.result;
										  btnsendmess.style.opacity='1';
                                        });
                                         reader.readAsDataURL(file);
                                          }
                                        }); 
									  </script>
							<button id="btnsendmess" class="btn" style="opacity:0;transition:all 1s;" class="" onclick="envoyer(messagegroupe.value)"><img src="https://cdn-icons-png.flaticon.com/512/3106/3106856.png" height="25"></button>
						</div>
						<div id="boxsmiley" class="collapse">
						<img src="https://media.toucharger.com/web/toucharger/upload/image_domain/7/5/75431/200x200-75431.gif" style="height:40px;" onclick="boxpreloadsendimg.style.display='block';preloadsendimg.src=this.src;btnsendmess.style.opacity='1';">
						      <script>
								 fetch("https://api.github.com/emojis")
                                 .then(res => res.json())
                                 .then(icons => {
	                             let count = 0;
                                 for (const key in icons) {
		                         boxsmiley.innerHTML+=`<img src="${icons[key]}" style="height:40px;" onclick="boxpreloadsendimg.style.display='block';preloadsendimg.src=this.src;btnsendmess.style.opacity='1';">`;
		                         count++;
                                 if (count === 150) break;
                                 }})
							  </script>
						 </div>
					</div>
<?php }else{?>
	 <hr>
	<em style="text-align:center;">You are in spectator mode, you have restricted rights and you cannot send a message</em>
	<p class="text-center" style="font-weight:700;">The administrator has reduced your rights following a violation of the rules<img class="rounded-circle mr-1" src="https://cdn.pixabay.com/photo/2015/12/27/14/52/panel-1109861_960_720.png" width="20" height="20"></p>
	<p class="text-center" style="font-weight:700;">Wait to regain your rights</p>
<?php }?>				
					
<?php }else{?>
   <h4 class="text-center" style="color:crimson;margin-top:50px;">You were banned from the group by the administrator for the following reasons</h4>
       <em class="text-center">"<?=$User->getInfo("raison_banni",'session')?>"</em>
<?php }?>
				</div>
			</div>
		</div>
	</div>
</section>
 <script src="js/chat.js"></script>

</body>
</html>