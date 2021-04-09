<?php
class PerPage {
	public $perpage;
	function __construct() {
		$this->perpage = 18;
	}

	function getAllPageLinks($count,$href) {
		$output = '';
		if(!isset($_POST["page"])) $_POST["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
			if($pages>1) {
				if($_POST["page"] == 1)
					$output = $output . '<span class="link first disabled"><i class="fa fa-backward"></i></span><span class="link disabled"><i class="fa fa-step-backward"></i></span>';
				else	
					$output = $output . '<a class="link first paginationclicklink" data="' . $href . (1) . '" ><i class="fa fa-backward"></i></a><a class="link paginationclicklink" data="' . $href . ($_POST["page"]-1) . '" ><i class="fa fa-step-backward"></i></a>';
				if(($_POST["page"]-3)>0) {
					if($_POST["page"] == 1)
						$output = $output . '<span id=1 class="link current">1</span>';
					else
						$output = $output . '<a class="link paginationclicklink" data="' . $href . '1" >1</a>';
				}
				if(($_POST["page"]-3)>1) {
					$output = $output . '<span class="dot">...</span>';
				}
				for($i=($_POST["page"]-2); $i<=($_POST["page"]+2); $i++)	{
					if($i<1) continue;
					if($i>$pages) break;
					if($_POST["page"] == $i)
						$output = $output . '<span id='.$i.' class="link current">'.$i.'</span>';
					else				
						$output = $output . '<a class="link paginationclicklink" data="' . $href . $i . '" >'.$i.'</a>';
				}
				if(($pages-($_POST["page"]+2))>1) {
					$output = $output . '<span class="dot">...</span>';
				}
				if(($pages-($_POST["page"]+2))>0) {
					if($_POST["page"] == $pages)
						$output = $output . '<span id=' . ($pages) .' class="link current">' . ($pages) .'</span>';
					else				
						$output = $output . '<a class="link paginationclicklink" data="' . $href .  ($pages) .'" >' . ($pages) .'</a>';
				}
				if($_POST["page"] < $pages)
					$output = $output . '<a  class="link paginationclicklink" data="' . $href . ($_POST["page"]+1) . '" ><i class="fa fa-step-forward"></i></a><a  class="link paginationclicklink" data="' . $href . ($pages) . '" ><i class="fa fa-forward"></i></a>';
				else				
					$output = $output . '<span class="link disabled"><i class="fa fa-step-forward"></i></span><span class="link disabled"><i class="fa fa-forward"></i></span>';
			}
			return $output;
	}
}
?>