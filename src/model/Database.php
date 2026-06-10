<?php

class Database
{
    public function moKetNoi()
    {
        $conn = mysqli_connect('localhost', 'admin', '123', 'websitebanhang');
        return $conn;
    }
}
