<?php 

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

class SecureController extends Controller
{
    public function buildAction(){
        $aclfile = APP_PATH . '/security/acl.cathe';
        // echo "gann";
        // die;
        if(true !== is_file($aclfile)){
            $acl = new Memory();
            // $acl->addRole('manager');
            $acl->addRole('admin');
            // $acl->addrole('accounting');
            // $acl->addrole('guest');
                $per = Permissions::find();
                foreach($per as $val){
                    $len = strlen($val->controller);
                    $cont = strtolower(substr($val->controller,0,($len-14)));

                    $len2 = strlen($val->action);
                    $action = strtolower(substr($val->action,0,($len2-6)));
                    // echo $action ."<br>";
                    // echo $val->role;
                    // die;
                    $acl->addComponent(
                        $cont,
                        [
                            $action
                        ]
                        );
                    $acl->addRole($val->role);
                    $acl->allow($val->role,$cont,$action);
                }
                $acl->allow('admin',"*","*");
                echo "$val->role    $cont / $action";
                echo "   fff";
                //die;
                // die;
                // echo "<pre>";
                // print_r($per->role);
                // die();
                // $acl->allow('manager','test','eventtest');
                // $acl->allow('admin','*','*');
                // $acl->deny('guest','*','*');
                file_put_contents(
                    $aclfile,
                    serialize($acl)

                );
        }
        else{
            $acl = unserialize(
                file_get_contents(
                    $aclfile
                ));
        }
        if(true === $acl->isAllowed('accounting','test','eventtest')){
            echo 'Access granted';
        }
        else{
            echo "Access Denied";
        }
    }
}