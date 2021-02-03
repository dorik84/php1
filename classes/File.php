<?php 
    class CSV_File {
        private $errors;
        private $file_name;
        private $new_file_name;
        private $file_size;
        private $file_tmp;
        private $file_type;
        private $file_error;
        private $file_ext;


        function __construct($FILE) {
            $this->errors=[];
            $this->file_name = $FILE['name'];
            $this->file_size = $FILE['size'];
            $this->file_tmp = $FILE['tmp_name'];
            $this->file_type = $FILE['type'];
            $this->file_error = $FILE['error'];
            $this->file_ext = strtolower(pathinfo($this->file_name,PATHINFO_EXTENSION));;
            $this->file_check();
            
        }

//================================================= METHODS
        function hasErrors() {
            if ( count($this->errors)>0){
                echo '<ul>';
                foreach($this->errors as $value) {
                    echo "<li style='color:red;'>$value</li>";
                }
                echo '</ul>';
                return true;
            } 
            else return false;
        }

        
        function file_check () {
            if($this->file_error != 0 ){
                $this->errors[]="no files were chosen.";
            }
    
            else if($this->file_ext !== "csv"){
                $this->errors[]="The extension is not allowed, please choose a CSV file.";
            }
            
            else if($this->file_size > 2097152){
                $this->errors[]='File size must be excately 2 MB';
            }
        }





        function safe_file() {
            if(!$this->hasErrors()){
            
                $this->new_file_name =  "./uploads/". sha1_file($this->file_tmp) . $this->file_ext;
    
                if(!is_dir ("uploads")){
                    mkdir("./uploads", 0777);
                }
                copy($this->file_tmp, $this->new_file_name);
                return $this->new_file_name;

     
            }

        }

    }
?>