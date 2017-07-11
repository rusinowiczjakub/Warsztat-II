<?php

$plain = "pass";

$hashed = password_hash($plain, PASSWORD_BCRYPT,["cost"=>11], ["salt"=>]);

echo $hashed;