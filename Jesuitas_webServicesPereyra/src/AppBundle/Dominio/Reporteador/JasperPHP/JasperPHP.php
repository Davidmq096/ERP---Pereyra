<?php
namespace AppBundle\Dominio\Reporteador\JasperPHP;

class JasperPHP
{
    protected $executable = "/../JasperStarter/bin/jasperstarter";
    protected $the_command;
    protected $redirect_output;
    protected $background;
    protected $container;
    protected $windows = false;
    protected $formats = array('pdf', 'rtf', 'xls', 'xlsx', 'docx', 'odt', 'ods', 'pptx', 'csv', 'html', 'xhtml', 'xml', 'jrprint');
    protected $resource_directory; // Path to report resource dir or jar file

    function __construct($container, $resource_dir = false)
    {
        $this->container = $container;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
           $this->windows = true;

        if (!$resource_dir) {
            $this->resource_directory = '"'.__DIR__ . '/../../../../../"';
        } else {
            if (!file_exists($resource_dir))
                throw new \Exception("Invalid resource directory", 1);

            $this->resource_directory = $resource_dir;
        }
    }

    public static function __callStatic($method, $parameters)
    {
        // Create a new instance of the called class, in this case it is Post
        $model = get_called_class();

        // Call the requested method on the newly created object
        return call_user_func_array(array(new $model, $method), $parameters);
    }

    public function compile($input_file, $output_file = false, $background = true, $redirect_output = true)
    {
        if(is_null($input_file) || empty($input_file))
            throw new \Exception("No input file", 1);

        $command = '"'.__DIR__ . $this->executable.'"';

        $command .= " compile ";

        $command .= $input_file;

        if( $output_file !== false )
            $command .= " -o " . $output_file;

        $this->redirect_output  = $redirect_output;
        $this->background       = $background;
        $this->the_command      = escapeshellcmd($command);

        return $this;
    }

    public function process($input_file, $output_file = false, $format = array("pdf"), $parameters = array(), $db_connection_active = false, $background = true, $redirect_output = true, $ldDriver=false)
    {
        if(is_null($input_file) || empty($input_file))
            throw new \Exception("No input file", 1);

        if( is_array($format) )
        {
            foreach ($format as $key)
            {
                if( !in_array($key, $this->formats))
                    throw new \Exception("Invalid format!", 1);
            }
        } else {
            if( !in_array($format, $this->formats))
                    throw new \Exception("Invalid format!", 1);
        }

        $command = "\"".__DIR__ . $this->executable."\"";

        $command .= " process ";

        $command .= $input_file;

        if( $output_file !== false )
            $command .= " -o " . $output_file;

        if( is_array($format) )
            $command .= " -f " . join(" ", $format);
        else
            $command .= " -f " . $format;

        // Resources dir
        $command .= " -r " . $this->resource_directory;

        if( count($parameters) > 0 )
        {
            $command .= " -P";
            foreach ($parameters as $key => $value)
            {
                if( is_string($value) )
                    $command .= " $key=\"$value\"";
                else
                    $command .= " $key=$value";
            }
        }
        if($db_connection_active){
            $dbp=$this->container->getParameter('database_password');
            if($this->windows){ $dbp=str_replace("^","^^",$dbp); }
            $ldDriver=array(
                'driver'=>'mysql',
                'username'=>$this->container->getParameter('database_user'),
                'password'=>$dbp,
                'host'=>$this->container->getParameter('database_host'),
                'database'=>$this->container->getParameter('database_name'),
                'port'=>$this->container->getParameter('database_port')
            );
        }
        if($ldDriver && sizeof($ldDriver)>0){
            $cmds=array(
                'driver'=>'-t',
                'username'=>'-u',
                'password'=>'-p',
                'host'=>'-H',
                'database'=>'-n',
                'port'=>'--db-port',
                'data_file'=>'--data-file',
                'json_query'=>'--json-query',
                'jsonql_query'=>'--jsonql-query',
                'jdbc_driver'=>'--db-driver',
                'jdbc_url'=>'--db-url',
                'jdbc_dir'=>'--jdbc-dir',
                'db_sid'=>'-db-sid',
                'xml_xpath'=>'--xml-xpath'
            );
            foreach($ldDriver AS $k=>$i) {
                $command.=" {$cmds[$k]} {$i}";
            }
        }

        $this->redirect_output  = $redirect_output;
        $this->background       = $background;
        $this->the_command      = $command;//escapeshellcmd($command);
				//echo($command);exit;
        return $this;
    }

    public function list_parameters($input_file)
    {
        if(is_null($input_file) || empty($input_file))
            throw new \Exception("No input file", 1);

        $command = '"'.__DIR__ . $this->executable.'"';

        $command .= " list_parameters ";

        $command .= $input_file;

        $this->the_command = escapeshellcmd($command);

        return $this;
    }

    public function output()
    {
        return escapeshellcmd($this->the_command);
    }

    public function execute($run_as_user = false)
    {
        if(!$this->windows){
            if($this->redirect_output){ $this->the_command.=" 2>&1"; }
            if($this->background){ $this->the_command.=" &"; }
            if($run_as_user!==false && strlen($run_as_user)>0){ $this->the_command="su -c \"{$this->the_command}\" {$run_as_user}"; }
        }
        $output=array();
        $return_var=0;
        exec($this->the_command, $output, $return_var);

        if($return_var!= 0 && isset($output[0]))
            throw new \Exception($output[0], 1);
        elseif( $return_var != 0 ) 
            throw new \Exception("Your report has an error and couldn't be processed! Try to output the command using the function `output();` and run it manually in the console.", 1);
        return $output;
    }
}
