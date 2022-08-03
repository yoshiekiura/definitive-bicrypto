<?php

namespace App\Http\Controllers\Admin\Frontends;

use App\Http\Controllers\Controller;
use App\Models\FrontendTemplates;
use Illuminate\Http\Request;
use ZipArchive;

class FrontendInstallController extends Controller
{

    public function index($product_id){
        $product = FrontendTemplates::where('product_id',$product_id)->first();
        $page_title = $product->name.' Installer';
        return view('admin.frontend.install', compact('page_title','product','product_id'));
    }

    public function activater($product_id){
        $product = FrontendTemplates::where('product_id',$product_id)->first();
        session()->put('tracker', $product);
        $page_title = $product->name.' Activater';
        return view('admin.frontend.activate', compact('page_title','product'));
    }
	private $api_url;
	private $api_key;
	private $api_language;
	private $verify_type;
	private $verification_period;
	private $current_path;
	private $root_path;

	public function __construct(){
		$this->api_url = 'https://api.mashdiv.com/';
		$this->api_key = 'CF30BB9297634F7075F6';
		$this->api_language = 'english';
		$this->verify_type = 'envato';
		$this->verification_period = 3;
		$this->current_path = realpath(__DIR__);
		$this->root_path = realpath($this->current_path.'/../../../../..');
	}

	public function check_local_license_exist($product_id){
        $product = FrontendTemplates::where('product_id',$product_id)->first();
		return is_file($this->current_path.'/'.$product->product_id.'.lic');
	}

	public function get_current_version($product_id){
        $product = FrontendTemplates::where('product_id',$product_id)->first();
		return $product->current_version;
	}

	private function call_api($method, $url, $data = null){
		$curl = curl_init();
		switch ($method){
			case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
			case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				if($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				break;
		  	default:
		  		if($data)
					$url = sprintf("%s?%s", $url, http_build_query($data));
		}
		$this_server_name = getenv('SERVER_NAME')?:
			$_SERVER['SERVER_NAME']?:
			getenv('HTTP_HOST')?:
			$_SERVER['HTTP_HOST'];
		$this_http_or_https = ((
			(isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS']=="on"))or
			(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])and
				$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		)?'https://':'http://');
		$this_url = $this_http_or_https.$this_server_name.$_SERVER['REQUEST_URI'];
		$this_ip = $this->get_ip_from_third_party()?:
			gethostbyname(gethostname());
		curl_setopt($curl, CURLOPT_HTTPHEADER,
			array('Content-Type: application/json',
				'LB-API-KEY: '.$this->api_key,
				'LB-URL: '.$this_url,
				'LB-IP: '.$this_ip,
				'LB-LANG: '.$this->api_language)
		);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		$result = curl_exec($curl);
		if(!$result&&!LB_API_DEBUG){
			$rs = array(
				'status' => FALSE,
				'message' => LB_TEXT_CONNECTION_FAILED
			);
			return json_encode($rs);
		}
		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if($http_status != 200){
			if(LB_API_DEBUG){
				$temp_decode = json_decode($result, true);
				$rs = array(
					'status' => FALSE,
					'message' => ((!empty($temp_decode['error']))?
						$temp_decode['error']:
						$temp_decode['message'])
				);
				return json_encode($rs);
			}else{
				$rs = array(
					'status' => FALSE,
					'message' => LB_TEXT_INVALID_RESPONSE
				);
				return json_encode($rs);
			}
		}
		curl_close($curl);
		return $result;
	}

	public function check_connection(){
		$get_data = $this->call_api(
			'POST',
			$this->api_url.'api/check_connection_ext'
		);
		$response = json_decode($get_data, true);
		return $response;
	}

	public function get_latest_version($product_id){
        $product = FrontendTemplates::where('product_id',$product_id)->first();
		$data_array =  array(
			"product_id"  => $product->product_id
		);
		$get_data = $this->call_api(
			'POST',
			$this->api_url.'api/latest_version',
			json_encode($data_array)
		);
		$response = json_decode($get_data, true);
		return $response;
	}

	public function activate_license($license, $client, $create_lic = true,$product_id){
        $product = FrontendTemplates::where('product_id',$product_id)->first();
		$data_array =  array(
			"product_id"  => $product->product_id,
			"license_code" => $license,
			"client_name" => $client,
			"verify_type" => $this->verify_type
		);
		$get_data = $this->call_api(
			'POST',
			$this->api_url.'api/activate_license',
			json_encode($data_array)
		);
		$response = json_decode($get_data, true);
		if(!empty($create_lic)){
			if($response['status']){
				$licfile = trim($response['lic_response']);
				file_put_contents($this->license_file, $licfile, LOCK_EX);
			}else{
				@chmod($this->license_file, 0777);
				if(is_writeable($this->license_file)){
					unlink($this->license_file);
				}
			}
		}
		return $response;
	}
    public function activate_licenser(Request $request){
        $create_lic = true;
		$data_array =  array(
			"product_id"  => $request->product_id,
			"license_code" => $request->license,
			"client_name" => $request->client,
			"verify_type" => $this->verify_type
		);
		$get_data = $this->call_api(
			'POST',
			$this->api_url.'api/activate_license',
			json_encode($data_array)
		);
		$response = json_decode($get_data, true);
		if(!empty($create_lic)){
			if($response['status']){
				$licfile = trim($response['lic_response']);
				file_put_contents($this->current_path.'/'.$request->product_id.'.lic', $licfile, LOCK_EX);
                $ext = FrontendTemplates::where('product_id',$request->product_id)->first();
                $ext->activated = '1';
                $ext->save();
                $notify[] = ['success', 'Template activated successfully'];
                return redirect()->route('admin.template.index')->withNotify($notify);
			}else{
				@chmod($this->current_path.'/'.$request->product_id.'.lic', 0777);
				if(is_writeable($this->current_path.'/'.$request->product_id.'.lic')){
					unlink($this->current_path.'/'.$request->product_id.'.lic');
				}
                $notify[] = ['warning', 'License is Invalid'];
                return back()->withNotify($notify);
			}
		}
	}

	public function verify_license($time_based_check = false, $license = false, $client = false,$product_id){
        $product = FrontendTemplates::where('product_id',$product_id)->first();
		if(!empty($license)&&!empty($client)){
			$data_array =  array(
				"product_id"  => $product->product_id,
				"license_file" => null,
				"license_code" => $license,
				"client_name" => $client
			);
		}else{
			if(is_file($this->license_file)){
				$data_array =  array(
					"product_id"  => $product->product_id,
					"license_file" => file_get_contents($this->license_file),
					"license_code" => null,
					"client_name" => null
				);
			}else{
				$data_array =  array();
			}
		}
		$res = array('status' => TRUE, 'message' => LB_TEXT_VERIFIED_RESPONSE);
		if($time_based_check && $this->verification_period > 0){
			ob_start();
			if(session_status() == PHP_SESSION_NONE){
				session_start();
			}
			$type = (int) $this->verification_period;
			$today = date('d-m-Y');
			if(empty($_SESSION["b6974808abe572d"])){
				$_SESSION["b6974808abe572d"] = '00-00-0000';
			}
			if($type == 1){
				$type_text = '1 day';
			}elseif($type == 3){
				$type_text = '3 days';
			}elseif($type == 7){
				$type_text = '1 week';
			}elseif($type == 30){
				$type_text = '1 month';
			}elseif($type == 90){
				$type_text = '3 months';
			}elseif($type == 365) {
				$type_text = '1 year';
			}else{
				$type_text = $type.' days';
			}
			if(strtotime($today) >= strtotime($_SESSION["b6974808abe572d"])){
				$get_data = $this->call_api(
					'POST',
					$this->api_url.'api/verify_license',
					json_encode($data_array)
				);
				$res = json_decode($get_data, true);
				if($res['status']==true){
					$tomo = date('d-m-Y', strtotime($today. ' + '.$type_text));
					$_SESSION["b6974808abe572d"] = $tomo;
				}
			}
			ob_end_clean();
		}else{
			$get_data = $this->call_api(
				'POST',
				$this->api_url.'api/verify_license',
				json_encode($data_array)
			);
			$res = json_decode($get_data, true);
		}
		return $res;
	}

	public function check_update($product_id){
        $product = FrontendTemplates::where('product_id',$product_id)->first();
		$data_array =  array(
			"product_id"  => $product->product_id,
			"current_version" => $product->current_version
		);
		$get_data = $this->call_api(
			'POST',
			$this->api_url.'api/check_update',
			json_encode($data_array)
		);
		$response = json_decode($get_data, true);
		return $response;
	}

	public function download_update($product_id,$update_id, $type, $version, $license = false, $client = false, $db_for_import = false){
		if(!empty($license)&&!empty($client)){
			$data_array =  array(
				"license_file" => null,
				"license_code" => $license,
				"client_name" => $client
			);
		}else{
			if(is_file($this->current_path.'/'.$product_id.'.lic')){
				$data_array =  array(
					"license_file" => file_get_contents($this->current_path.'/'.$product_id.'.lic'),
					"license_code" => null,
					"client_name" => null
				);
			}else{
				$data_array =  array();
			}
		}
		ob_end_flush();
		ob_implicit_flush(true);
		$version = str_replace(".", "_", $version);
		ob_start();
		$source_size = $this->api_url."api/get_update_size/main/".$update_id;
		echo LB_TEXT_PREPARING_MAIN_DOWNLOAD."<br>";
		if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 1;</script>';}
		ob_flush();
		echo LB_TEXT_MAIN_UPDATE_SIZE." ".$this->get_remote_filesize($source_size)." ".LB_TEXT_DONT_REFRESH."<br>";
		if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 5;</script>';}
		ob_flush();
		$temp_progress = '';
		$ch = curl_init();
		$source = $this->api_url."api/download_update/main/".$update_id;
		curl_setopt($ch, CURLOPT_URL, $source);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_array);
		$this_server_name = getenv('SERVER_NAME')?:
			$_SERVER['SERVER_NAME']?:
			getenv('HTTP_HOST')?:
			$_SERVER['HTTP_HOST'];
		$this_http_or_https = ((
			(isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS']=="on"))or
			(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])and
				$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		)?'https://':'http://');
		$this_url = $this_http_or_https.$this_server_name.$_SERVER['REQUEST_URI'];
		$this_ip = $this->get_ip_from_third_party()?:
			gethostbyname(gethostname());
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'LB-API-KEY: '.$this->api_key,
			'LB-URL: '.$this_url,
			'LB-IP: '.$this_ip,
			'LB-LANG: '.$this->api_language)
		);
		if(LB_SHOW_UPDATE_PROGRESS){curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, array($this, 'progress'));}
		if(LB_SHOW_UPDATE_PROGRESS){curl_setopt($ch, CURLOPT_NOPROGRESS, false);}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		echo LB_TEXT_DOWNLOADING_MAIN."<br>";
		if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 10;</script>';}
		ob_flush();
		$data = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($http_status != 200){
			if($http_status == 401){
				curl_close($ch);
				exit("<br>".LB_TEXT_UPDATE_PERIOD_EXPIRED);
			}else{
				curl_close($ch);
				exit("<br>".LB_TEXT_INVALID_RESPONSE);
			}
		}
		curl_close($ch);
		$destination = $this->root_path."/update_main_".$version.".zip";
		$file = fopen($destination, "w+");
		if(!$file){
			exit("<br>".LB_TEXT_UPDATE_PATH_ERROR);
		}
		fputs($file, $data);
		fclose($file);
		if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 65;</script>';}
		ob_flush();
		$zip = new ZipArchive;
		$res = $zip->open($destination);
		if($res === TRUE){
			$zip->extractTo($this->root_path."/");
			$zip->close();
			unlink($destination);
			echo LB_TEXT_MAIN_UPDATE_DONE."<br><br>";
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 75;</script>';}
			ob_flush();
		}else{
			echo LB_TEXT_UPDATE_EXTRACTION_ERROR."<br><br>";
			ob_flush();
		}
		if($type == true){
			$source_size = $this->api_url."api/get_update_size/sql/".$update_id;
			echo LB_TEXT_PREPARING_SQL_DOWNLOAD."<br>";
			ob_flush();
			echo LB_TEXT_SQL_UPDATE_SIZE." ".$this->get_remote_filesize($source_size)." ".LB_TEXT_DONT_REFRESH."<br>";
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 85;</script>';}
			ob_flush();
			$temp_progress = '';
			$ch = curl_init();
			$source = $this->api_url."api/download_update/sql/".$update_id;
			curl_setopt($ch, CURLOPT_URL, $source);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_array);
			$this_server_name = getenv('SERVER_NAME')?:
				$_SERVER['SERVER_NAME']?:
				getenv('HTTP_HOST')?:
				$_SERVER['HTTP_HOST'];
			$this_http_or_https = ((
				(isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS']=="on"))or
				(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])and
					$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
			)?'https://':'http://');
			$this_url = $this_http_or_https.$this_server_name.$_SERVER['REQUEST_URI'];
			$this_ip = $this->get_ip_from_third_party()?:
				gethostbyname(gethostname());
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'LB-API-KEY: '.$this->api_key,
				'LB-URL: '.$this_url,
				'LB-IP: '.$this_ip,
				'LB-LANG: '.$this->api_language)
			);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			echo LB_TEXT_DOWNLOADING_SQL."<br>";
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 90;</script>';}
			ob_flush();
			$data = curl_exec($ch);
			$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($http_status!=200){
				curl_close($ch);
				exit(LB_TEXT_INVALID_RESPONSE);
			}
			curl_close($ch);
			$destination = $this->root_path."/update_sql_".$version.".sql";
			$file = fopen($destination, "w+");
			if(!$file){
				exit(LB_TEXT_UPDATE_PATH_ERROR);
			}
			fputs($file, $data);
			fclose($file);
			echo LB_TEXT_SQL_UPDATE_DONE."<br><br>";
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 95;</script>';}
			ob_flush();
			if(is_array($db_for_import)){
				if(!empty($db_for_import["db_host"])&&!empty($db_for_import["db_user"])&&!empty($db_for_import["db_name"])){
					$db_host = strip_tags(trim($db_for_import["db_host"]));
            		$db_user = strip_tags(trim($db_for_import["db_user"]));
            		$db_pass = strip_tags(trim($db_for_import["db_pass"]));
            		$db_name = strip_tags(trim($db_for_import["db_name"]));
					$con = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
					if(mysqli_connect_errno()){
						echo LB_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED;
						$ext = FrontendTemplates::where('product_id',$product_id)->first();
						$ext->installed = '1';
						$version = str_replace("_", ".", $version);
						$ext->current_version = $version;
						$ext->save();
					}else{
						$templine = '';
						$lines = file($destination);
						foreach($lines as $line){
							if(substr($line, 0, 2) == '--' || $line == '')
								continue;
							$templine .= $line;
							$query = false;
							if(substr(trim($line), -1, 1) == ';'){
								$query = mysqli_query($con, $templine);
								$templine = '';
							}
						}
						@chmod($destination,0777);
						if(is_writeable($destination)){
							unlink($destination);
						}
						echo LB_TEXT_UPDATE_WITH_SQL_IMPORT_DONE;
                        $ext = FrontendTemplates::where('product_id',$product_id)->first();
                        $ext->installed = '1';
                        $version = str_replace("_", ".", $version);
                        $ext->current_version = $version;
                        $ext->save();
					}
				}else{
					echo LB_TEXT_UPDATE_WITH_SQL_IMPORT_FAILED;
					$ext = FrontendTemplates::where('product_id',$product_id)->first();
					$ext->installed = '1';
					$version = str_replace("_", ".", $version);
					$ext->current_version = $version;
					$ext->save();
				}
			}else{
				echo LB_TEXT_UPDATE_WITH_SQL_DONE;
                $ext = FrontendTemplates::where('product_id',$product_id)->first();
                $ext->installed = '1';
                $version = str_replace("_", ".", $version);
                $ext->current_version = $version;
                $ext->save();
			}
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 100;</script>';}
			ob_flush();
		}else{
			if(LB_SHOW_UPDATE_PROGRESS){echo '<script>document.getElementById(\'prog\').value = 100;</script>';}
			echo LB_TEXT_UPDATE_WITHOUT_SQL_DONE;
            $ext = FrontendTemplates::where('product_id',$product_id)->first();
            $ext->installed = '1';
            $version = str_replace("_", ".", $version);
            $ext->current_version = $version;
            $ext->save();
			ob_flush();
		}
		ob_end_flush();
	}

	private function progress($resource, $download_size, $downloaded, $upload_size, $uploaded){
		static $prev = 0;
		if($download_size == 0){
			$progress = 0;
		}else{
			$progress = round( $downloaded * 100 / $download_size );
		}
		if(($progress!=$prev) && ($progress == 25)){
			$prev = $progress;
			echo '<script>document.getElementById(\'prog\').value = 22.5;</script>';
			ob_flush();
		}
		if(($progress!=$prev) && ($progress == 50)){
			$prev=$progress;
			echo '<script>document.getElementById(\'prog\').value = 35;</script>';
			ob_flush();
		}
		if(($progress!=$prev) && ($progress == 75)){
			$prev=$progress;
			echo '<script>document.getElementById(\'prog\').value = 47.5;</script>';
			ob_flush();
		}
		if(($progress!=$prev) && ($progress == 100)){
			$prev=$progress;
			echo '<script>document.getElementById(\'prog\').value = 60;</script>';
			ob_flush();
		}
	}

	private function get_ip_from_third_party(){
		$curl = curl_init ();
		curl_setopt($curl, CURLOPT_URL, "http://ipecho.net/plain");
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	private function get_remote_filesize($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HEADER, TRUE);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_NOBODY, TRUE);
		$this_server_name = getenv('SERVER_NAME')?:
			$_SERVER['SERVER_NAME']?:
			getenv('HTTP_HOST')?:
			$_SERVER['HTTP_HOST'];
		$this_http_or_https = ((
			(isset($_SERVER['HTTPS'])&&($_SERVER['HTTPS']=="on"))or
			(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])and
				$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		)?'https://':'http://');
		$this_url = $this_http_or_https.$this_server_name.$_SERVER['REQUEST_URI'];
		$this_ip = $this->get_ip_from_third_party()?:
			gethostbyname(gethostname());
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'LB-API-KEY: '.$this->api_key,
			'LB-URL: '.$this_url,
			'LB-IP: '.$this_ip,
			'LB-LANG: '.$this->api_language)
		);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		$result = curl_exec($curl);
		$filesize = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		if ($filesize){
			switch ($filesize){
				case $filesize < 1024:
					$size = $filesize .' B'; break;
				case $filesize < 1048576:
					$size = round($filesize / 1024, 2) .' KB'; break;
				case $filesize < 1073741824:
					$size = round($filesize / 1048576, 2) . ' MB'; break;
				case $filesize < 1099511627776:
					$size = round($filesize / 1073741824, 2) . ' GB'; break;
			}
			return $size;
		}
	}
}
