<?php

namespace Controllers;
use Vendor\Controller;
use Models\Member as memberModel;

class Member extends Controller {

    private $memberModel;
    public function __construct()
    {
        $this->memberModel = new memberModel();
    }

    public function getMembers() {
        if (isset($_POST['mId'])) {
            $mId = $_POST['mId'];
            return $this->memberModel->getMember($mId);

        } else {
            return $this->memberModel->getMembers();
        }
    }

    public function newMember() {
        if (isset($_POST['mId'], $_POST['name'], $_POST['phone'], $_POST['email'], $_POST['password']) && !empty($_POST['mId'])) {
            $mId = $_POST['mId'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            return $this->memberModel->newMember($mId, $name, $phone, $email, $password);
        }
        return self::response(400, 'mId為必要輸入');
    }

    public function removeMember() {
        $mId = $_POST['mId'];
        return $this->memberModel->removeMember($mId);
    }
    
    public function updateMember() {
        if (isset($_POST['mId'], $_POST['name'], $_POST['phone'], $_POST['email'], $_POST['password'])) {
            $mId = $_POST['mId'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            return $this->memberModel->updateMember($name, $phone, $email, $password, $mId);
        }
        return self::response(400, '所有欄位為必要輸入');
    }    public function countMembers() {
        $result = $this->memberModel->countMembers();
        if ($result['status'] == 200) {
            return self::response(200, '獲取會員數量成功', $result['result'][0]['count']);
        } else {
            return self::response($result['status'], $result['message']);
        }
    }
}
