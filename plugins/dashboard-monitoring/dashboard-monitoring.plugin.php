<?php
/*
@name dash_monitoring
@author Valentin CARRUESCO <idleman@idleman.fr>
@link http://blog.idleman.fr
@licence CC by nc sa
@version 1.0.0
@description Ajoute des widgets de monitoring du raspberry pi
*/



function dash_monitoring_plugin_menu(&$widgets){

		$widgets[] = array(
		    'uid'      => 'dash_monitoring_clock',
		    'icon'     => 'fa fa-calendar-o',
		    'label'    => 'Horloge',
		    'background' => '#394264', 
		    'color' => '#fffffff',
		    'unique' => true,
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=clock',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=clock',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=clock',
		);

		$widgets[] = array(
		    'uid'      => 'dash_monitoring_ram',
		    'icon'     => 'fa fa-bar-chart-o',
		    'label'    => 'RAM',
		    'background' => '#50597B', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=ram',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=ram',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=ram',
		);

		$widgets[] = array(
		    'uid'      => 'dash_monitoring_vocal',
		    'icon'     => 'fa fa-comments-o',
		    'label'    => 'Commandes vocales',
		    'background' => '#014B96', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=vocal',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=vocal',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=vocal',
		);

		$widgets[] = array(
		    'uid'      => 'dash_monitoring_logs',
		    'icon'     => 'fa fa-dedent',
		    'label'    => 'Logs',
		    'background' => '#0FC7E3', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=logs'
		);

		$widgets[] = array(
			'uid'      => 'dash_monitoring_system',
		    'icon'     => 'fa fa-tachometer',
		    'label'    => 'Système',
		    'background' => '#84C400', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=system',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=system',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=system',
		);

		$widgets[] = array(
			'uid'      => 'dash_monitoring_network',
		    'icon'     => 'fa fa-exchange',
		    'label'    => 'Réseau',
		    'background' => '#006AFF', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=network',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=network',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=network',
		);

		$widgets[] = array(
			'uid'      => 'dash_monitoring_hdd',
		    'icon'     => 'fa fa-hdd-o',
		    'label'    => 'HDD',
		    'background' => '#FF2E12', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=hdd',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=hdd',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=hdd',
		);

		$widgets[] = array(
			'uid'      => 'dash_monitoring_disk',
		    'icon'     => 'fa fa-download',
		    'label'    => 'Disques',
		    'background' => '#C1004F', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=disk',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=disk',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=disk',
		);

		$widgets[] = array(
			'uid'      => 'dash_monitoring_users',
		    'icon'     => 'fa fa-users',
		    'label'    => 'Utilisateurs',
		    'background' => '#E51400', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=users',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=users',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=users',
		);

		$widgets[] = array(
			'uid'      => 'dash_monitoring_services',
		    'icon'     => 'fa fa-users',
		    'label'    => 'Services',
		    'background' => '#632F00', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=services',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=services',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=services',
		);

		$widgets[] = array(
			'uid'      => 'dash_monitoring_gpio',
		    'icon'     => 'fa fa-dot-circle-o',
		    'label'    => 'GPIO',
		    'background' => '#373737', 
		    'color' => '#fffffff',
		    'onLoad'   => 'action.php?action=dash_monitoring_plugin_load&bloc=gpio',
		    'onMove'   => 'action.php?action=dash_monitoring_plugin_move&bloc=gpio',
		    'onDelete' => 'action.php?action=dash_monitoring_plugin_delete&bloc=gpio',
		);

		
}



function dash_monitoring_plugin_actions(){
	global $myUser,$_,$conf;

	switch($_['action']){

		case 'dash_monitoring_plugin_load':
			if($myUser==false) exit('Vous devez vous connecter pour cette action.');
			header('Content-type: application/json');

			$response = array();

			switch($_['bloc']){
				case 'ram':
					$response['title'] = 'RAM';

					$hdds = Monitoring::ram();
					$response['content'] = '
						<div style="width: 100%">
							<canvas id="RAM_PIE"></canvas>
							<br/><br/>
							<ul class="graphic_pane">
								<li class="pane_orange">
									<h1>RAM UTILISEE</h1>
									<h2>'.$hdds['percentage'].'%</h2>
								</li><li class="pane_cyan">
									<h1>RAM LIBRE</h1>
									<h2>'.$hdds['free'].' Mo</h2>
								</li><li class="pane_red">
									<h1>RAM TOTALE</h1>
									<h2>'.$hdds['total'].' Mo</h2>
								</li>
							</ul>
						</div>

						<script>

							$("#RAM_PIE:visible").chart({
								type : "doughnut",
								label : ["RAM UTILISEE","RAM LIBRE"],
								backgroundColor : ["'.($hdds['percentage']>80? '#E64C65' : '#FCB150' ).'","#4FC4F6"],
								segmentShowStroke:false,
								data : ['.$hdds['percentage'].','.(100-$hdds['percentage']).']
							});
							
						</script>';
				break;
				case 'clock':
					$response['title'] = 'Horloge';

					
					$response['content'] = '
					
					
						<style>
							.clockContainer{
								background-color:#394264;
								font-family:\'Open Sans Light\';
								width:100%;
								height:100%;
								box-sizing:border-box;
								text-align:center;
								padding:20px;
							}
							.clock {	
								height: 200px;
								width: 200px;
								margin:auto;
								position:relative;
								background-color:#394264;
							}

							.progress > svg {
								height: 100%;
								display: block;
							}
							
							.progressbar-text{
								position:absolute;
								left:0px;
								top:60px;
								width:100%;
								text-align:center;
								font-weight:200;
								color:#ffffff!important;
							}
							.progressbar-text .dayName,.progressbar-text .dayDate{
								font-size:20px;
								color:#cecece;
								margin: 10px 0;
								
							}
							.progressbar-text .dayName{
								font-weight:bold;
								color:#ffffff;
								margin-top: 20px ;
							}
						</style>
						<div class="clockContainer">
						 <div class="clock" id="clock"></div>
						 </div>

						<script>

							var circle;
							$(document).ready(function(){
								
								
								 circle = new ProgressBar.Circle(\'#clock\', {
									color: \'#50C8FB\',
									duration: 3000,
									easing: \'easeInOut\',
									text: {
										style : { fontSize : \'38px\'},
										value : \'00:00:00\'
									}
									
								});
								
								refresh_clock();
								setInterval(function(){
									refresh_clock();
								},1000);
								
								
							});
							
							function refresh_clock(){
								var d = new Date();
								var hour = d.getHours(); 
								var minut = ("00" + d.getMinutes()).slice(-2) ; 
								var second = ("00" + d.getSeconds()).slice(-2) ; 
								var year = d.getFullYear() ; 
								var month = ("00" + (d.getMonth()+1)).slice(-2) ; 
								var day = ("00" + d.getDate()).slice(-2) ; 
								var days = ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];
						
								var dayName = days[d.getDay()];
								circle.setText(hour+\':\'+minut+\':\'+second+\'<div class="dayName">\'+dayName+\'</div><div class="dayDate">\'+day+\'/\'+month+\'/\'+year+\'</div>\');
								circle.set(second/60);
							}
							
						</script>';
				break;
				case 'system':
					$response['title'] = 'Système';
					
					if(PHP_OS!='WINNT'){
						$heat = Monitoring::heat();
						$cpu = Monitoring::cpu();
					}
			
					$response['content'] = '<ul class="yana-list">
				    	<li><strong>Distribution :</strong> '.Monitoring::distribution().'</li>
				    	<li><strong>Kernel :</strong> '.Monitoring::kernel().'</li>
				    	<li><strong>HostName :</strong> '.Monitoring::hostname().'</li>
				    	<li><strong>Température :</strong>  <span class="label '.$heat["label"].'">'.$heat["degrees"].'°C</span></li>
				    	<li><strong>Temps de marche :</strong> '.Monitoring::uptime().'</li>
				    	<li><strong>CPU :</strong>  <span class="label label-info">'.$cpu['current_frequency'].' Mhz</span> (Max '.$cpu['maximum_frequency'].'  Mhz/ Min '.$cpu['minimum_frequency'].'  Mhz)</li>
				    	<li><strong>Charge :</strong>  <span class="label label-info">'.$cpu['loads'].' </span>  | '.$cpu['loads5'].'  5min | '.$cpu['loads15'].'  15min</li>
				    </ul>';
				break;
				case 'vocal':

					if($myUser->getId()=='') exit('{"error":"invalid or missing token"}');
					if(!$myUser->can('vocal','r')) exit('{"error":"insufficient permissions for this account"}');
					
					$protocol = 'http'.(isset($_SERVER['HTTPS'])?"s":"");

					list($host,$port) = explode(':',$_SERVER['HTTP_HOST']);
					$actionUrl = $protocol.'://'.$host.':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
					$actionUrl = substr($actionUrl,0,strpos($actionUrl , '?'));
					
					Plugin::callHook("vocal_command", array(&$response,$actionUrl));

					
					$response['title'] = count($response['commands']).' Commandes vocales';
					$response['content'] = '<ul class="yana-list">';
					if(isset($response['commands'])){
						foreach($response['commands'] as $command){
							$response['content'] .= '<li title="Sensibilité : '.$command['confidence'].'" onclick="window.open(\''.$command['url'].'\')">'.$command['command'].'</li>';
						}
					}

					$response['content'] .= '</ul>';
				break;
				case 'logs':
					if($myUser->getId()=='') exit('{"error":"invalid or missing token"}');
					
					
					$response['title'] = 'Logs';
					$logs = dirname(__FILE__).'/../../'.LOG_FILE ;
					$response['content'] = '<div style="overflow:auto;max-height:200px;"><ul class="yana-list" style="margin:0px;">';
					if(file_exists($logs)){
						$lines = file($logs);
						$nb_lines = count($lines)-1; // -1 pour ne pas avoir la ligne avec uniquement la virgule
						
						for($i=$nb_lines; $i>0; $i--){
							$response['content'] .= '<li style="font-size:8px;'.($i%2==0?'background-color:#F4F4F4;':'').'">'.$line.'</li>';
						}
					}else{
						$response['content'] .= '<li>Aucun logs</li>';
					}
				
					$response['content'] .= '</ul></div>';
				break;
				case 'network':
					$response['title'] = 'Réseau';
					$ethernet = array();
					$lan = '';
					$wan = '';
					$http = '';
					$connections = '';

					if(PHP_OS!='WINNT'){
						$ethernet = Monitoring::ethernet();
						$lan = Monitoring::internalIp();
						$wan = Monitoring::externalIp();
						$http = Monitoring::webServer();
						$connections = Monitoring::connections();
					}
			
					$response['content'] = '<ul class="yana-list">
					    	<li><strong>IP LAN :</strong> <code>'.$lan.'</code></li>
					    	<li><strong>IP WAN :</strong> <code>'.$wan.'</code></li>
					    	<li><strong>Serveur HTTP :</strong> '.$http.'</li>
					    	<li><strong>Ethernet :</strong> '.$ethernet['up'].' Montant / '.$ethernet['down'].' Descendant</li>
					    	<li><strong>Connexions :</strong>  <span class="label label-info">'.$connections.'</span></li>
					    </ul>';

				break;
				case 'gpio':
					$response['title'] = 'GPIO';
					$gpios = array();					
					
						$gpios = Monitoring::gpio();
						$model = System::getModel();
						$pinLabelsRange = System::getPinForModel($model['type'],$model['version']);
						
						
						$response['title'] = 'RPI Type '.$model['type'].' V'.$model['version'].' ('.count($gpios).' pins)';
						$response['content'] .=  '<table class="gpio_container">';
						$response['content'] .=  '<tr>';
						foreach($pinLabelsRange as $range=>$pinLabels){
							$response['content'] .=  '<td valign="top"><table>';
							foreach($pinLabels as $pin){
								$roleColor = 'transparent';
								
								$class = 'gpio_state_'.($gpios[$pin->wiringPiNumber]?'on':'off');
								
								if($pin->name=='5V' || $pin->name=='3.3V') $class = 'gpio_power';
								if($pin->name=='0V' || $pin->name=='DNC') $class = 'gpio_ground';
								
								$response['content'] .=  '<div class="'.$class.'" title="Role : '.($pin->role==''?'GPIO':$pin->role).', Position physique : '.$pin->physicalNumber.', Numero BMC : '.$pin->bcmNumber.'" onclick="change_gpio_state('.$pin->wiringPiNumber.',this);">';
								$response['content'] .=  '<span style="'.($range==0?'float:right;':'').'"></span> '.$pin->name.' <small>('.($pin->role==''?'GPIO':$pin->role).')</small>';
								$response['content'] .=  '</div>';
							}
							$response['content'] .=  '</table></td>';
						}
						$response['content'] .=  '</tr>';
						$response['content'] .=  '</table>';
						
						
						if($model['type']=='unknown'){
							$response['title'] = 'RPI Inconnu, révision ('.$model['revision'].') ';
							$response['content'] =  '<p>Votre RPI dispose d\'une révision ('.$model['revision'].') inconnue de yana, il n\'est pas possible d\'afficher ses pins.<br/> Pour ajouter cette révision, merci de <a href="https://github.com/ldleman/yana-server/issues">faire une demande sur github</a> en précisant la révision, le nombre de pins, le modèle et la vesion de votre rpi.</p>';
						}
				break;
				case 'users':
					$users = array();
					if(PHP_OS!='WINNT'){
						$users = Monitoring::users();
					}

					$response['title'] = count($users).' utilisateurs connectés';
					
					$response['content'] = '<ul class="yana-list">';
				    foreach ($users as $value) {
						$response['content'] .= '<li>Utilisateur <strong class="badge">'.$value['user'].'</strong> IP : <code>'.$value['ip'].'</code>, Connexion : '.$value['hour'].' </li>';
				    }
			    	$response['content'] .= '</ul>';
				break;
				case 'services':
					$response['title'] = 'Services';
					$services = array();
					
					if(PHP_OS!='WINNT'){
						$services = Monitoring::services();
						$response['content'] = '<ul class="yana-list">';
				    	foreach ($services as $value) {
				    		$response['content'] .= '<li '.($value['status']?'class="service-active"':'').'>- '.$value['name'].'</li>';
				    	}
				   		$response['content'] .= '</ul>';
					}else{
						$response['content'] .='Information indisponible sur cet OS :'.PHP_OS;
					}

				break;
				case 'hdd':
					$response['title'] = 'HDD';
					$hdds = array();
					
					if(PHP_OS!='WINNT'){
						$hdds = Monitoring::hdd();
						$response['content'] ='<ul class="yana-list">';
						foreach ($hdds as $value) {
							$response['content'] .='<li><strong class="badge">'.$value['name'].'</strong><br><strong> Espace :</strong> '.$value['used'].'/'.$value['total'].'<strong> Format :</strong> '.$value['format'].' </li>';
						}
						$response['content'] .='</ul>';
					}else{
						$response['content'] .='Information indisponible sur cet OS :'.PHP_OS;
					}

				break;

				case 'disk':

					$response['title'] = 'Disques';
					$disks = array();

					if(PHP_OS!='WINNT'){
						$disks = Monitoring::disks();
						$response['content'] ='<ul class="yana-list">';
					    foreach ($disks as $value) {
					    	$response['content'] .='<li><strong class="badge">'.$value['name'].'</strong> Statut : '.$value['size'].' Type : '.$value['type'].' Chemin : '.$value['mountpoint'].'  </li>';
					    }
					    $response['content'] .='</ul>';
					}else{
						$response['content'] .='Information indisponible sur cet OS :'.PHP_OS;
					}
		

				break;
			}

			echo json_encode($response);
			exit(0);

		break;

		case 'dash_monitoring_plugin_edit':
			echo '<label>Time Zone</label><input id="zone" type="text">';
		break;

		case 'dash_monitoring_plugin_save':

		break;
		case 'dash_monitoring_plugin_delete':

		break;
		case 'dash_monitoring_plugin_move':

		break;

		
	
	}
	
}


Plugin::addCss('/css/style.css',true);
Plugin::addJs('/js/main.js',true);
Plugin::addHook("widgets", "dash_monitoring_plugin_menu");
Plugin::addHook("action_post_case", "dash_monitoring_plugin_actions");
?>
