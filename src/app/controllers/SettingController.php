<?php 

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Escaper;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

class SettingController extends Controller
{
    public function IndexAction(){

    }
    public function defaultAction(){
        $postdata = $_POST ?? array();
        // echo "<pre>";
        // print_r($postdata);

        $request = new Request();
        $product = new Settings();
        $escaper = new Escaper();

        $inputdata = array(
            "title" => $escaper->escapeHtml($this->request->getPost('title'),),
            "zipcode" => $escaper->escapeHtml($this->request->getPost('zipcode'),),
            "price" => $escaper->escapeHtml($this->request->getPost('price'),),
            "stock" => $escaper->escapeHtml($this->request->getPost('stock'),)

        );

        $product->assign(
            $this->request->getPost(),
                [
                'title',
                'price',
                'stock',
                'zipcode'
                ]
        );
        $product->save();
        header('Location:http://localhost:8080/');
    }
}
// settings