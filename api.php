<?php

$conn = mysqli_connect(
    'localhost',
    'root',
    '',
    'vue_curd'
);

if($conn->connect_errno){
   die('Databse connet errno!');
}

$response =[
    'error'=>false
];

$action ='read';

if(isset($_GET['action'])){
  $action =$_GET['action'];
}

if($action=='read'){
   $users=array();
   $result = $conn->query('SELECT * FROM users ORDER BY id DESC');
   while($row=$result->fetch_assoc()){
       array_push($users,$row);
   }
   $response['users']=$users;


}else if($action=='create'){
    
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $result = $conn->query("INSERT INTO `users` (`name`, `username`, `email`) VALUES ('$name', '$username', '$email')");
    if($result){
        $response['message']="Data save successfully!";
    }else{
        $response['error']=true;
        $response['message']="Data  save faild!";
    }


}else if($action=='update'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    // UPDATE `users` SET `name`='$name',`username`='$username',`email`='$email' WHERE `id`='$id' 
    $email = $_POST['email'];
    $result = $conn->query("UPDATE `users` SET `name`='$name',`username`='$username',`email`='$email' WHERE `id`='$id'");
    if($result){
        $response['message']="Data update successfully!";
    }else{
        $response['error']=true;
        $response['message']="Data  update faild!";
    }

}else if($action=='delete'){
    $id = $_POST['id'];
    $result = $conn->query("DELETE FROM `users` WHERE `id`='$id' ");
    if($result){
        $response['message']="Data deleted successfully!";
    }else{
        $response['error']=true;
        $response['message']="Data  deleted faild!";
    }

}else{
    die('Invalid Action!');
}


// header('content-type:aplication/json');
// 
echo json_encode($response);