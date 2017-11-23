<?php
class Conexion
{
    public function conectar()
    {
        //$connect = new PDO("mysql:charset=utf8;host=mysql.hostinger.es;dbname=u892132586_chat",'u892132586_elvin','E1j0nEr4oLMf');
        $connect = new PDO("mysql:charset=utf8;host=localhost;dbname=redsocial",'root','');
        return $connect;
    }
}