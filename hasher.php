<html>
<body>
<?php
  $ms = connect_db();
  $res = $ms->query("SELECT password FROM user WHERE 1");
  while($row = $res->fetch_assoc()){
    echo "<p>".pasword_hash($row['pass'])."</p>";
  }
?>
</body>
</html>
