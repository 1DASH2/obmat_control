<?php
$cajero1 = password_hash("c1JHONATAN@456OBMAT", PASSWORD_DEFAULT);
$cajero2 = password_hash("c2T48@MDI/_dIdo12", PASSWORD_DEFAULT);
$admin   = password_hash("456LUISRAMOSadmin@obmat/.og", PASSWORD_DEFAULT);

echo "cajero1: " . $cajero1 . "<br><br>";
echo "cajero2: " . $cajero2 . "<br><br>";
echo "admin: "   . $admin;
?>