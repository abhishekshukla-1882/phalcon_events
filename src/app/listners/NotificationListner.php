<?php
namespace App\Listeners;
use Phalcon\Mvc\Collection;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Acl\Adapter\Memory;


Class NotificationListner extends Injectable
{
    public function IndexAction(){

    }
    public function beforeHandleRequest(Event $event, \Phalcon\Mvc\Application $application){
        // echo "h";
        // die;
        // $role = $application->request->get('role');
        // echo $role;
        // die;
        $aclfile = APP_PATH . '/security/acl.cathe';
        if(is_file($aclfile)){
            // echo "read";
           $acl = unserialize(
               file_get_contents($aclfile)
           );
        } else {
            $acl = new Memory();
            $acl->addRole('admin');
            $acl->addComponent(
                "secure",
                [
                    'build'
                ]
            );
            $acl->allow("admin","*","*");
        }
        $role = $application->request->getQuery('role')??'admin';
        //    echo $role;
        //    die;
        $cont=$this->router->getControllerName();
        $act=$this->router->getActionName();
        // echo "$act , $cont,$role";
        // die;
           if($acl->isAllowed("$role","$cont","$act")){
           }else{
            echo 'Access denied';
            // print_r($acl);
               die;
           }       

    }
}