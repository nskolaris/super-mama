<?php

class FrontController extends AppController {

	public $name = 'Front';

	public $uses = array();

public function beforeFilter()
{
	parent::beforeFilter();
	$this->layout = 'default';
}

	public function home() //fangate
	{
			$data = $this->fbgetSignedRequest();
		
			if(!empty($data))
				{
					if (!isset($data["page"]["liked"]))
					{
						echo "<script> window.top.location.href='http://www.facebook.com/pages/Drublus-Factory/351127084993501?id=351127084993501&sk=app_211645485590601'</script>";
					}
						if (empty($data["page"]["liked"])) {
		     $this->render('usuario_no_fan');
		    }
	    		else
	    		{
	     		$this->render('usuario_fan');
	    		}
				}
				
		$page = $subpage = $title_for_layout = null;
		$title_for_layout = 'Home';
		$this->set(compact('page', 'subpage', 'title_for_layout'));

	}

}