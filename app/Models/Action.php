<?php
namespace Models;
use Vendor\DB;

class Action {
    public function getRoles($action) {
        $sql = "
        SELECT role_action.role_id
        FROM `action`, `role_action`
        WHERE action.name=? AND role_action.action_id=action.id
        ";

        $arg = [$action];

        $response = DB::read($sql, $arg);
        $result = $response["result"];
        $cnt = count($result);
        for ($i=0; $i < $cnt; $i++) { 
            $result[$i] = $result[$i]['role_id'];
        }
        $response["result"] = $result;
        return $response;
    }
}