<?php
namespace App\Home\Controllers;

use Common\BaseController;
use App\Home\Models\Robots;

class RobotsController extends BaseController {
    
    public function initialize() {
        echo '<pre>';
        $this->view->disable();
    }
    
    public function indexAction() {
        $robotsList = Robots::find();
        foreach ($robotsList as $robot){
            echo $robot->id,' ',$robot->name,' ',$robot->type,' ',$robot->weight,'<br/>';
        }
    }
    
    public function addAction() {
        $data = $this->get();
        $robots = new Robots();
        $res = $robots->create($data); // or save($data)
        var_dump($res, $robots->id ?? '插入失败', $robots->getMessages());exit;
    }
    
    public function infoAction() {
        $id = $this->get('id', 'int');
        $this->config->services->db->logged = true;
        $robot = Robots::findFirst($id);
        echo $robot->id,' ',$robot->name,' ',$robot->type,' ',$robot->weight;exit;
    }
    
    public function editAction() {
        $data = $this->get();
        $robot = Robots::findFirst($data['id']);
        $res = $robot->update($data); // or save($data)
        var_dump($res, $res ? '更新成功' : '更新失败', $robot->getMessages());exit;
    }
    
    public function deleteAction() {
        $id = $this->get('id', 'int');
        $robot = Robots::findFirst($id);
        $res = $robot->delete();
        var_dump($res, $res ? '删除成功' : '删除失败', $robot->getMessages());exit;
    }
}