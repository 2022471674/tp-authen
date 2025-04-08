<?php
namespace app\controller;

use think\facade\{View, Session,Log};
use app\event\getAllCategories;
use app\model\tools\Md5CryptModel;
use think\facade\Request;
use app\model\tools\Sm2CryptModel;

class Main
{
    public $categories;
    public $mdCipher;
    public function __construct()
    {
        $this->categories   = (new getAllCategories())->handle();
        $this->mdCipher     =  new Md5CryptModel();
    }
    /**
     * function login "/" 路由下的内容渲染
     */
    function login()
    {
        if (!Session::has("userid"))
        {
            $userid = 'null';
            $name = '登录';
            $action = url('api/login');
        }else{
            $userid = md5(Session::get("userid"));
            $user = Session::get("name");
            $name = isset($user) ? "欢迎"." " .htmlspecialchars($user) : "欢迎用户";
            $action = url('api/loginout'); 
        }
        return View::fetch('home/index', [ 
            "userid" => $userid,
            "name"   => $name,
            "action" => $action
        ]);
    }

    /**
     * 阅读文章
     */
    function read()
    {
        return View::fetch('home/read/single');
    }

    /**
     * 发布文章
     */
    function edit()
    {
        return View::fetch('publish/edit');
    } 

    /**
     * ctf工具
     */
    function tools_encrypt()
    {
        return View::fetch('md5/index');
    }

    /**
     * md5加密
     */
    function md5_encode(Request $request)
    {
        header('Content-Type: application/json');
        $data = Request::post();
        
        if (empty($data['action']))
        {
            return json([
                'code' => 404,
                'msg' => '请输入加密类型',
                'result' => ''
            ]);
        }
        switch($data['action'])
        {
            case '16':
                $result = $this->mdCipher->md5_16($data['input'],$data['upper']);
                break;
            case '32':
                $result = $this->mdCipher->md5_32($data['input'],$data['upper']);
                break;
        }
        
        return json([
            'code' => 200,
            'msg' => '加密成功',
            'result' => $result
        ]);
    }

    /**
     * sm2模板渲染
     */
    function sm2_encrypt_view()
    {
        return View::fetch('sm2/index');
    }
    /**
     * sm2算法生成
     */
    function sm2_encrypt(Request $request)
    {
        $data = Request::post();
        if (empty($data['action'])||empty($data['input']))
        {
            return json([
                'code' => 404,
                'msg' => '请输入加密类型',
                'result' => ''
            ]);
        }
        $result = (new Sm2CryptModel())->sm2DoEncrypt($data['input'],$data['public_key']);

        return json([
            'code' => 200,
            'msg' => '加密成功',
            'result' => $result
        ]);
    }


    /**
     * 用户配置中心
     */
    function setting()
    {
        return View::fetch('home/setting/setting');
    }

    /**
     * 分类
     */
    function category()
    {
        return View::fetch('publish/read/category');
    }

    /**
     * 阅读分类
     */
    function readCategory()
    {
        $name = Session::get("name")?? "Cfer";
        $category_id = input('category_id');
        $articles = (new ArticleModel())->getArticlesByCategory($category_id);
        return View::fetch('publish/read/category', [
            'articles' => $articles,
            'name' => $name
        ]);
    }
}

    


    