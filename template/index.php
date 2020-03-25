<?php
    class Template{
        private $vars = [];
        public function assign($key, $val=""){
            $this->vars[$key] = $val;
        }
        public function render($folder, $template_name){
            $path = "template/".$folder."/".$template_name.".html";
            if(file_exists($path)){
                $content = file_get_contents($path);
                foreach($this->vars as $key=>$val){
                    if(is_array($val)){
                        $t = "";
                        foreach($val as $v){
                            $t.= "<span>$v</span>";
                        }
                        $val = $t;
                    }
                    $content = preg_replace("/\[".$key."\]/", $val, $content);
                }
                echo $content;
            }
        }
    }

?>