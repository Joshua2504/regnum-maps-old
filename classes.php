<?php
class label {
	public $name;
	public $nickname;
	public $extra;
	public $shortname;
	public $posx;
	public $posy;
	public $realm;
	private $link;

	function __construct($name,$shortname,$realm,$posy,$posx,$nickname = null,$extra = null)
	{
		$this->name = $name;
		$this->nickname = $nickname;
		$this->shortname = $shortname;
		$this->realm = $realm;
		$this->extra = $extra;
		$this->posy = $posy;
		$this->posx = $posx;
		
		$link = './info/'.$shortname.'.php';
		if(!is_file($link))
			$link = '#';
		$this->link = $link;
	}

	function css()
	{
		$css = "\n#label-".$this->shortname.' {'.
		"\n".'position:absolute;'.
		"\n".'top:'.$this->posy.';'.
		"\n".'left:'.$this->posx.';'.
		"\n}\n";
		return $css;
	}

	function biglabel()
	{
		$html = "\n".'<a href="'.$this->link.'" class="label" id="label-'.$this->shortname.'">'.
		"\n".'<span class="fortname '.$this->realm.'">'.$this->name."</span>\n";
		if($this->nickname != null)
			$html .= '<span class="nickname">"'.$this->nickname."\"</span>\n";
		if($this->extra != null)
			$html .= '<span class="extra">'.$this->extra."</span>\n";
		$html .= "</a>\n";
		return $html;
	}
	
	function smalllabel()
	{
		$html = "\n".'<a href="'.$this->link.'" class="nickname" id="label-'.$this->shortname.'">'.$this->name;
		if($this->extra != null)
			$html .= '<span class="extra">'.$this->extra."</span>\n";
		$html .= "</a>\n";
		return $html;
	}
}
?>
