<?php

class app
{
	public $G;
	//联系密钥
	private $sc = 'exam@phpems.net';

	public function __construct(&$G)
	{
		$this->G = $G;
		$this->ev = $this->G->make('ev');
		$this->tpl = $this->G->make('tpl');
		$this->sql = $this->G->make('sql');
		$this->db = $this->G->make('db');
		$this->pg = $this->G->make('pg');
		$this->html = $this->G->make('html');
		$this->session = $this->G->make('session');
		$this->exam = $this->G->make('exam','exam');
	}

	public function index()
	{
		header("location:".'index.php?'.$this->G->app.'-app');
	}

	//通过接口进行登录
	public function login()
	{
		$sign = $this->ev->get('sign');
		$userid = $this->ev->get('userid');
		$username = $this->ev->get('username');
		$useremail = $this->ev->get('useremail');
		$ts = $this->ev->get('ts');
		$rand =rand(1,6);
		if($rand == 5)
		{
			$this->session->clearOutTimeUser();
			$this->exam->clearOutTimeExamSession();
		}
		if($sign == md5($userid.$username.$useremail.$this->sc.$ts))
		{
			$user = $this->G->make('user','user');
			$u = $user->getUserByUserName($username);
			if(!$u)
			{
				$defaultgroup = $this->user->getDefaultGroup();
				$pass = md5(rand(1000,9999));
				$id = $this->user->insertUser(array('username' => $username,'usergroupid' => $defaultgroup['groupid'],'userpassword' => md5($pass),'useremail' => $useremail));
				$this->session->setSessionUser(array('sessionuserid'=>$id,'sessionpassword'=>md5($pass),'sessionip'=>$this->ev->getClientIp(),'sessiongroupid'=>8,'sessionlogintime'=>TIME,'sessionusername'=>$username));
			}
			else
			$this->session->setSessionUser(array('sessionuserid'=>$userid,'sessionpassword'=>$user['userpassword'],'sessionip'=>$this->ev->getClientIp(),'sessiongroupid'=>$user['usergroupid'],'sessionlogintime'=>TIME,'sessionusername'=>$username));
			header("location:".'index.php?'.$this->G->app.'-app');
		}
		else
		header("location:".'index.php?exam');
		exit(0);
	}

	//退出登录
	public function logout()
	{
		$this->session->clearSessionUser();
		header("location:".'index.php?'.$this->G->app.'-app');
	}
}

?>