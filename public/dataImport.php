<?php

if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'import' ) { //导入CSV 

    $filename = $_FILES['file']['tmp_name']; 
    if (empty ($filename)) { 
        echo '请选择要导入的CSV文件！'; 
        exit; 
    } 
    $handle = fopen($filename, 'r'); 
    $result = input_csv($handle); //解析csv 
    $len_result = count($result); 
    if($len_result==0){ 
        echo '没有任何数据！'; 
        exit; 
    } 
    $items=0;
    for ($i = 1; $i < $len_result; $i++) { //循环获取各字段值 
       
        $mode_name=iconv('gb2312', 'utf-8',$result[$i][2]);
    	$model=findOne("categories","where name='$mode_name'");
        if(count($model)==0){
            insertSql("categories",array("name"=>$mode_name,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'user_id'=>1,'category_type'=>'asset'));
            $model_last=findOne("categories"," order by id desc ");
            $model_id=$model_last['id'];
        }else{
           $model_id=$model['id']; 
        }
        $manufacturer_name=iconv('gb2312', 'utf-8',$result[$i][3]);
        $manufacturer=findOne("manufacturers","where name='$manufacturer_name'");
        if(count($manufacturer)==0){
            insertSql("manufacturers",array("name"=>$manufacturer_name,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'user_id'=>1));
            $manufacturer_last=findOne("manufacturers"," order by id desc ");
            $manufacturer_id=$manufacturer_last['id'];
        }else{
           $manufacturer_id=$manufacturer['id']; 
        }

        insertSql("assets",array("name"=>$result[$i][1] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][1]),
            'model_id'=>$model_id,
            'manufacturer_id'=>$manufacturer_id,
            'size'=>$result[$i][4] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][4]),
            'product_number'=>$result[$i][5] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][5]),
            'product_code'=>$result[$i][6] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][6]),
            'base_code'=>$result[$i][7] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][7]),
            'address'=>$result[$i][8] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][8]),
            'owner'=>$result[$i][9] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][9]),
            'user_check'=>$result[$i][10] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][10]),  
            'money_way'=>$result[$i][11] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][11]),
            'sugguset'=>$result[$i][12] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][12]),
            'notes'=>$result[$i][13] =="" ? "":iconv('gb2312', 'utf-8',$result[$i][13]),
            'user_id'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'physical'=>1,
            'status_id'=>3,
            'archived'=>0,
            'warranty_months'=>12,
            'depreciate'=>0,
            'requestable'=>0,
            ));

        $items++;
       
    } 
    echo "导入成功，共导入条".$items."数据";exit;
}
function mysqlConnect(){
    $ms_host = "localhost"; //主机
    //$ms_port = "3306"; //主机
    $ms_user = "root"; //用户名
    $ms_pass = "JACK@2016"; //密码
    $ms_data = "snipeit";  //mysql库名
    $ms_connect = mysql_connect($ms_host, $ms_user, $ms_pass)
    or die("Couldn't connect to mysql Server on $$ms_host");
     mysql_query("SET NAMES utf8",$ms_connect);
    $ms_select = mysql_select_db($ms_data, $ms_connect)
    or die("Couldn't open database $ms_select");
    return $ms_connect;
}

function findOne($table,$where){
    $result = mysql_query("SELECT * FROM $table $where limit 0,1",mysqlConnect());
    $rdata=array();
    while($data=@mysql_fetch_assoc($result)) {
        $rdata=$data;
    }
 return $rdata; 
}
    function input_csv($handle) { 
	    $out = array (); 
	    $n = 0; 
	    while ($data = fgetcsv($handle, 10000)) { 
	        $num = count($data); 
	        for ($i = 0; $i < $num; $i++) { 
	            $out[$n][$i] = $data[$i]; 
	        } 
	        $n++; 
	    } 
	    return $out; 
	} 
function insertSql($table,$fields=array()){
    $f="";
    $v="";
    foreach ($fields as $key => $value) {
        $f.=($f!="" ? ',':"").$key;
        $v.=($v!="" ? ',':"")."'".$value."'";
    }
    $update="INSERT INTO $table ($f) values($v)";
   
   $rdata = mysql_query($update,mysqlConnect());
   echo $update;
 return $rdata ? true:false;
}

?>

<form id="addform" action="dataImport.php?action=import" method="post" enctype="multipart/form-data"> 
    <p>请选择要导入的CSV文件：<br/><input type="file" name="file"> <input type="submit" 
    class="btn" value="导入CSV"> 
  </p> 
</form> 