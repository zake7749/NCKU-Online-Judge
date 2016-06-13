<?php
  $pid = $_GET["pid"];
  $username = $_GET["username"];
  $query="SELECT pid FROM `star` WHERE username='".$username."'";
  $result=mysql_query($query,$link);
  $check = 0;
  while($rows=mysql_fetch_array($result,MYSQL_ASSOC)){
    if($pid = $row["pid"])
      $check = 1;
  }
  if($check == 1){
    $query="INSERT INTO star(pid,username) values('".$pid."','".$username."')";
    $result=mysql_query($query,$link);
    print '<a id = "star" onclick = "send(this)" > unstar</a>';
  }
  else{
    $query="DELETE FROM `star` WHERE pid = '".$pid."' and username = '".$username."'";
    $result=mysql_query($query,$link);
    print '<a id = "star" onclick = "send(this)" > star</a>';
  }
 ?>
