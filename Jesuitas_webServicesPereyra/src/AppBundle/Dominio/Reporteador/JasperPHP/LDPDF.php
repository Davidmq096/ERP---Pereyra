<?php
namespace AppBundle\Dominio\Reporteador\JasperPHP;

class LDPDF{
    //PATHS
    private $env="";
    private $clean="";
    private $root="";
    private $full="";

    private $report="";
    private $report_c="";
    public $report_r="";

    private $fdb="";
    private $fdb_c="";
    public $fdb_r="";
    private $output="";
    private $output_c="";
    public $output_r="";

    private $container;
    private $driver=false;
    private $useMysql=false;
    private $params=array();
    private $options=array();

    public function __construct($container,$report,$output,$driver=false,$params=[],$options=['pdf']){
				$extension=$options[0];
        $this->container=$container;
        $this->loadPath();
        $this->params=$params;
        $this->options=$options;
        $this->driver=$driver;
        $this->useMysql=(!$driver ? true : false);

        $this->output_c="{$this->clean}{$output}";
        $this->output_r="../{$this->output_c}.$extension";
        $this->output=$this->root.$this->output_c;

        $this->report_c="{$this->clean}{$this->env}{$report}.jrxml";
        $this->report_r="../{$this->report_c}";
        $this->report=$this->root.$this->report_c;

        if($this->driver && !empty($this->driver['data_file'])){
            $this->fdb_c=$this->clean.$this->driver['data_file'].".json";
            $this->driver['data_file']=$this->getCMDPath($this->root.$this->fdb_c);
            $this->fdb_r="../$this->fdb_c";
            $this->fdb=$this->root.$this->fdb_c;
        }
        $this->logo="{$this->full}logo.png";
    }
    public function output(){ return $this->exec("output"); }
    public function execute(){ return $this->exec("execute"); }
    private function exec($command){
        $data=$this->process();
        if($data==false){ return false; }
        return $data->$command();
    }
    private function process(){
        //$this->logPathPDF();
        list($report,$output,$logo)=$this->getPathPDF();
        $this->params['logo']=$logo;
        try{
            return (new JasperPHP($this->container))->process(
                $report,
                $output,
                $this->options,
                $this->params,
                $this->useMysql,
                true,
                true,
                $this->driver
            );
        }catch(\Exception $e){ return false; }
    }

    private function loadPath(){
        $env=[1=>"Lux/",2=>"Ciencias/"];
        $this->clean="src/AppBundle/Dominio/Reporteador/Plantillas/";
        $this->env=$env[ENTORNO];
        $this->root=str_replace('app', '', $this->container->get('kernel')->getRootDir());
        $this->full=$this->root.$this->clean.$this->env;
    }

    private function getCMDPath($x){ return "\"$x\""; }
    private function getPathPDF(){ return array($this->getCMDPath($this->report),$this->getCMDPath($this->output),$this->logo); }
    private function logPathPDF(){
        list($report,$output,$logo)=$this->getPathPDF();
        echo $report."\n";
        echo $output."\n";
        echo $logo."\n";
    }

    public static function fileRead($file){return fopen($file,"w+");}
    public static function fileClose($fileh){return fclose($fileh);}
		public static function fileDelete($file){return unlink($file);}
    public static function fileWrite($fileh,$data){fwrite($fileh,$data);}
    public static function fileLock($fileh){
        if(flock($fileh,LOCK_EX)){
            ftruncate($fileh,0);
            return true;
        }
        return false;
    }
    public static function fileRelease($fileh){
        fflush($fileh);
        return flock($fileh, LOCK_UN);
    }
}