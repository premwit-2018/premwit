<?php


$hashed = '$2y$10$hVYhxJcShuwnSbMZiPUIjOZAT5QDfv6/KWKTQimdiO3.MZMWYGu4C';

if (password_verify("idk",$hashed)){
    echo "yay";
}
else{
    echo "how?";
}
?>