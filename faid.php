<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use liliuwei\think\Jump;
use think\facade\Db;
use think\facade\View;
use think\Request;

class faid extends BaseController
{
    use Jump;
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
     return View::fetch("register");
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
   public function list()
    {
        //这是购物车的列表展示页面
        $listFile=Db::table('goods_sat')->paginate(3);
        View::assign("list",$listFile);
        return View::fetch("list");
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
        $register=[
            "goods_name"=>$request->post("goods_name"),
            "goods_dan"=>$request->post("goods_dan"),
            "goods_ku"=>$request->post("goods_ku")
        ];
        $file=$request->file("img");
        if($file){
            $image=\think\facade\Filesystem::disk('public')->putFile( 'topic', $file);
            $register["img"]="/storage/".$image;
        }
        if(Db::table('goods_sat')->insert($register)){
            $this->success("成功","faid/index");
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function create($id)
    {
        //
        $this->success("添加购物车成功","faid/list");
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit()
    {
        //用户表登录返回购物车
        return view('login');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function gin(Request $request)
    {
        //用户表登录的方法
        $registr_gin=[
            "username"=>$request->post("username"),
            "phone"=>$request->post("phone")
        ];
        if(Db::table('usename')->select($registr_gin)){
            $this->success("登录成功返回购物车","faid/list");
        }
    }
}
