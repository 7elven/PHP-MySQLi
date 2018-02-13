<?php

class Database
{
    private $db;
    function __construct()
    {
        $hostname = "";
        $database = "";
        $username = "";
        $password = "";
        $this->db = new mysqli($hostname, $username, $password, $database);

        if ($this->db->connect_errno) {
            die("Failed to connect to MySQL: (" . $this->db->connect_errno . ") " . $mysqli->connect_error);
        }
        $this->db->query("set names utf8");
    }
    public function query($sql, $arg = [])
    {
        if (is_array($arg) && $arg != []) {
            $result = $this->prepared($sql, $arg);
            return $result;
        } else {
            if (!$result = $this->db->query($sql)) {
                echo "Error message: " . mysqli_error($this->db);
            }
            return $result;
        }
    }

    public function fetch_all($result)
    {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function escape($data)
    {
        return $this->db->real_escape_string($data);
    }

    public function prepared($sql, array $args)
    {
        $stmt = $this->db->prepare($sql);
        $params = [];
        $types = array_reduce($args, function ($string, &$arg) use (&$params) {
            $params[] = &$arg;
            if (is_float($arg)) $string .= 'd';
            elseif (is_integer($arg)) $string .= 'i';
            elseif (is_string($arg)) $string .= 's';
            else $string .= 'b';
            return $string;
        }, '');
        array_unshift($params, $types);
        call_user_func_array([$stmt, 'bind_param'], $params);
        $result = $stmt->execute() ? $stmt->get_result() : false;
        $stmt->close();

        return $result;
    }
}