<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

abstract class AuthMeController
{

    const AUTHME_TABLE = 'authme';

    function checkPassword($username, $password)
    {
        if (is_scalar($username) && is_scalar($password)) {
            $hash = $this->getHashFromDatabase($username);
            if ($hash) {
                return $this->isValidPassword($password, $hash);
            }
        }
        return false;
    }

    function isUserRegistered($username)
    {
        $mysqli = $this->getAuthmeMySqli();
        if ($mysqli !== null) {
            $stmt = $mysqli->prepare('SELECT 1 FROM ' . self::AUTHME_TABLE . ' WHERE username = ?');
            $stmt->bind_param('s', $username);
            $stmt->execute();
            return $stmt->fetch();
        }
        return true;
    }

    function isEmailRegistered($email)
    {
        $mysqli = $this->getAuthmeMySqli();
        if ($mysqli !== null) {
            $stmt = $mysqli->prepare('SELECT 1 FROM ' . self::AUTHME_TABLE . ' WHERE email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            return $stmt->fetch();
        }
        return true;
    }

    function register($username, $password, $email)
    {
        $email = $email ? $email : 'your@email.com';
        $mysqli = $this->getAuthmeMySqli();
        if ($mysqli !== null) {
            $hash = $this->hash($password);
            $stmt = $mysqli->prepare('INSERT INTO ' . self::AUTHME_TABLE . ' (username, realname, password, email, ip) '
                . 'VALUES (?, ?, ?, ?, ?)');
            $username_low = strtolower($username);
            $stmt->bind_param('sssss', $username_low, $username, $hash, $email, $_SERVER['REMOTE_ADDR']);
            return $stmt->execute();
        }
        return false;
    }

    function changePassword($username, $password)
    {
        $mysqli = $this->getAuthmeMySqli();
        if ($mysqli !== null) {
            $hash = $this->hash($password);
            $stmt = $mysqli->prepare('UPDATE ' . self::AUTHME_TABLE . ' SET password=? '
                . 'WHERE username=?');
            $username_low = strtolower($username);
            $stmt->bind_param('ss', $hash, $username_low);
            return $stmt->execute();
        }
        return false;
    }

    protected abstract function hash($password);
    protected abstract function isValidPassword($password, $hash);

    private function getAuthmeMySqli()
    { # Config1
        $mysqli = new mysqli('localhost', 'quackmc_net', 'WwGhC2kwxdpdtF3r', 'quackmc_net');
        if (mysqli_connect_error()) {
            printf(
                'Could not connect to AuthMe database. Errno: %d, error: "%s"',
                mysqli_connect_errno(),
                mysqli_connect_error()
            );
            return null;
        }
        return $mysqli;
    }

    private function getHashFromDatabase($username)
    {
        $mysqli = $this->getAuthmeMySqli();
        if ($mysqli !== null) {
            $stmt = $mysqli->prepare('SELECT password FROM ' . self::AUTHME_TABLE . ' WHERE username = ?');
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->bind_result($password);
            if ($stmt->fetch()) {
                return $password;
            }
        }
        return null;
    }
}

class PTDUNG
{
    private $ketnoi;

    function connect()
    {
        if (!$this->ketnoi) { #Config2
            $this->ketnoi = mysqli_connect('localhost', 'quackmc_net', 'WwGhC2kwxdpdtF3r', 'quackmc_net') or die('Bảo Trì');
            mysqli_query($this->ketnoi, "set names 'utf8'");
        }
    }

    function dis_connect()
    {
        if ($this->ketnoi) {
            mysqli_close($this->ketnoi);
        }
    }

    public function get_id_insert()
    {
        $this->connect();
        return mysqli_insert_id($this->ketnoi);
    }

    function getUser($user_id)
    {
        $this->connect();
        $row = $this->ketnoi->query("SELECT * FROM `freegems_info` WHERE `user_id` = '$user_id' ")->fetch_array();
        return $row;
    }

    function site($data)
    {
        $this->connect();
        $row = $this->ketnoi->query("SELECT * FROM `settings` WHERE `name` = '$data' ")->fetch_array();
        return $row['value'];
    }

    function query($sql)
    {
        $this->connect();
        return $this->ketnoi->query($sql);
    }

    function cong($table, $data, $sotien, $where)
    {
        $this->connect();
        return $this->ketnoi->query("UPDATE `$table` SET `$data` = `$data` + '$sotien' WHERE $where ");
    }

    function tru($table, $data, $sotien, $where)
    {
        $this->connect();
        return $this->ketnoi->query("UPDATE `$table` SET `$data` = `$data` - '$sotien' WHERE $where ");
    }

    function insert($table, $data)
    {
        $this->connect();
        $field_list = '';
        $value_list = '';
        foreach ($data as $key => $value) {
            $field_list .= ",$key";
            $value_list .= ",'" . mysqli_real_escape_string($this->ketnoi, $value) . "'";
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($field_list, ',') . ') VALUES (' . trim($value_list, ',') . ')';
        return mysqli_query($this->ketnoi, $sql);
    }

    function update($table, $data, $where)
    {
        $this->connect();
        $sql = '';
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysqli_real_escape_string($this->ketnoi, $value) . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where;
        return mysqli_query($this->ketnoi, $sql);
    }

    function remove($table, $where)
    {
        $this->connect();
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->ketnoi, $sql);
    }

    function get_list($sql)
    {
        $this->connect();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai');
        }
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        mysqli_free_result($result);
        return $return;
    }

    function get_row($sql)
    {
        $this->connect();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai');
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }

    function num_rows($sql)
    {
        $this->connect();
        $result = mysqli_query($this->ketnoi, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai');
        }
        return mysqli_num_rows($result);
    }
}
?>