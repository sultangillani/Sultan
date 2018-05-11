<?php
include_once '../admin/inc/db.php';

class query
{
    public function select($con,$res,$tablename,$cond){
        $query ="SELECT $res FROM $tablename $cond";
        $mysql_res = mysqli_query($con,$query);
        return $mysql_res;
    }
    
    public function delete($con,$tablename,$cond){
        $query ="DELETE FROM $tablename $cond";
        $mysql_res = mysqli_query($con,$query);
        return $mysql_res;
    }

    public function insert($con,$tablename,$res,$val,$cond){
        $query ="INSERT INTO $tablename ($res) VALUES ($val) $cond";
        $mysql_res = mysqli_query($con,$query);
        return $mysql_res;
    }

    public function update($con,$tablename,$data,$cond_up){
        $query ="UPDATE $tablename SET $data $cond_up";
        $mysql_res = mysqli_query($con,$query);
        return $mysql_res;
    }
}
//ipAdress
function get_client_ip() {
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

$data = new query();
if(isset($_POST['search'])){
    if(!empty($_POST['search'])){
        
        $ip = get_client_ip();
        $searcher = mysqli_real_escape_string($conn,htmlentities($_POST['search']));
        $query_recent_sel = $data->select($conn,'*','wp_recent',"WHERE `recent`='$searcher' AND `ipaddr`='$ip'");
        if(mysqli_num_rows($query_recent_sel) > 0){
            echo "The keyword is already exists";
        }else{
            $insert_recent = $data->insert($conn,'wp_recent',"recent, ipaddr","'$searcher','$ip'","");
        } 
    }
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>Page Title</title>
</head>

<body>

<form action="" method="post" class="" role="search">
    <input type="text" class="form-control foce" name="search" id="inputGroupSuccess2" placeholder="Search on RetailMeNot"/>
</form>

<div class="result">
    
</div>
</body>
</html>
