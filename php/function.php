<?php
    function GetContent($arrData) {
        $url = $arrData["url"];
        $postdata = http_build_query($arrData);
        $opts = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            ),
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            )
        );
        $context = stream_context_create($opts);
        return file_get_contents($url, false, $context);
    }
    function GetClientIpEnv() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }
    function DateTh($date, $time=true) {
        if( $date=="0000-00-00" || $date=="" ) return "";
        $arr1 = explode(" ", $date);
		$arr2 = explode("-", $arr1[0]);
        if( sizeof($arr2)<=2 ) return "";
        $rs = $arr2[2]."/".$arr2[1]."/".($arr2[0]*1+543);
        if( sizeof($arr1)==2 ) $rs .= " ".substr($arr1[1], 0, 5);
        if( $time==false ) {
            $arr = explode(" ", $rs);
            return $arr[0];
        }
		return $rs;
    }
    function DateEn($date, $time=true) {
        $arr1 = explode(" ", $date);
		$arr2 = explode("/", $arr1[0]);
		if( sizeof($arr2)<=2 ) return "";
		$rs = ($arr2[2]*1-543)."-".$arr2[1]."-".($arr2[0]);
        if( sizeof($arr1)==2 ) $rs .= " ".substr($arr1[1], 0, 5);
        if( $time==false ) {
            $arr = explode(" ", $rs);
            return $arr[0];
        }
        return $rs;
    }
    function GetDateNowTh() {
        $date = date("d/m/").(date("Y")*1+543);
        return $date;
    }
    function GetDateNowEn() {
        $date = date("Y-m-d");
        return $date;
    }
    function ToNum($num) {
        $num = str_replace(" %", "", $num);
        return number_format( str_replace(",","",$num)*1, 2, '.', '');
    }
    function PrintData($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    
    function LinkTo($url) {
        echo '
            <script>
                location.href = "'.$url.'";
            </script>
        ';
        exit();
    }
    function Back() {
        echo '
            <script>
                history.back();
            </script>
        ';
        exit();
    }
    function Reload() {
        echo '
            <script>
                var href = window.location.href;
                window.history.replaceState({}, "", href);
                location.reload();
            </script>
        ';
        exit();
    }
    function ShowAlert($title="แจ้งข้อความ", $html="ระบุข้อความ", $type="question", $href="") {
        // $type = success, error, warning, info, question
        echo '
            <script>
                ShowAlert({
                    title: "'.$title.'",
                    html: "'.$html.'",
                    type: "'.$type.'",
                    callback: function() {
                        if( "'.$href.'"!="" ) {
                            if( "'.$href.'"!="Reload()" ) {
                                window.location.href = "'.$href.'";
                            } else {
                                Reload();
                            }
                        }
                    }
                });
            </script>
        ';
    }
    function FtpConnect() {
        $ftp = new FTPConnect(FTP_SERVER, FTP_USER, FTP_PASS);
        return $ftp;
    }
    function MakeDir($targetPath) {
        $ftp = FtpConnect();
        $ftp->MkDir($targetPath);
        $ftp->Close();
    }
    function UploadFile($elementName, $dir, $rename=null, $allowType=null, $index=null) {
        if( isset($_FILES[$elementName]) && $_FILES[$elementName]["size"]>0 ) {
            $ftp = FtpConnect();
            if( $index!==null ) {
                $tmpName = $_FILES[$elementName]['tmp_name'][$index];
                $name = $_FILES[$elementName]['name'][$index];
                $size = $_FILES[$elementName]['size'][$index];
            } else {
                $tmpName = $_FILES[$elementName]['tmp_name'];
                $name = $_FILES[$elementName]['name'];
                $size = $_FILES[$elementName]['size'];
            }
            $type = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if( $rename===null ) $rename = $name;
            if( $allowType!==null && !in_array($type, $allowType) ) return array( "status"=>false, "fileName"=>"", "message"=>"รูปแบบไฟล์ไม่รองรับ" );
            if( $allowType!==null) {
                foreach ($allowType as $key => $value) {
                    if( $ftp->IsFile($dir.$rename.".".$value) ) $ftp->Unlink($dir.$rename.".".$value);
                }
            }
            $fileName = $rename.".".$type;
            $ftp->MoveUploadFile($tmpName, $dir.$fileName);
            $ftp->Close();
            return array( "status"=>true, "fileName"=>$fileName );
        }
        return array( "status"=>false, "fileName"=>"", "message"=>"ไม่พบไฟล์" );
    }
    function RemoveDir($targetPath) {
        $ftp = FtpConnect();
        $ftp->RmDir($targetPath);
        $ftp->Close();
    }
    function RemoveFile($targetFile) {
        $ftp = FtpConnect();
        $ftp->Unlink($targetFile);
        $ftp->Close();
    }
    function AcceptImplode($type) {
        foreach ($type as $key => $value) {
            $type[$key] = ".".$type[$key];
        }
        return implode(", ", $type);
    }
	function Encoder($data) {
		$cryption = new KSCryption();
		return $cryption->encrypt($data, "dtcconnect");
	}
	function Decoder($data) {
		$cryption = new KSCryption();
		return $cryption->decrypt($data, "dtcconnect");
    }
    function CheckFeildEmpty($feild, $message) {
        if( !$feild || $feild=="" || $feild==null ) {
            echo json_encode(array(
                "status"=>false,
                "message"=>$message
            ));
            exit();
        }
    }
    function SendLineNotify($lineToken, $message) {
        $LINE_API = "https://notify-api.line.me/api/notify";
        $headers = [
            'Authorization: Bearer ' . $lineToken
        ];
        $fields = [
            'message' => $message
        ];
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $LINE_API);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
            if ($result == false) throw new Exception(curl_error($ch), curl_errno($ch));
            $json = json_decode($result, true);
            if( isset($json["status"]) && $json["status"]==200 ) return true;
        } catch (Exception $e) { }
        return false;
    }
    function CalculateAge($date) {
        $arr = explode("-", $date);
        if(sizeof($arr)!=3) return "No";
        return date("Y")*1 - $arr[0]*1; 
    }