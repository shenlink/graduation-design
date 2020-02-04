<php
Class Db {
    public function __construct(){
        try{
            $this->pdo=new PDO('mysql:host=127.0.0.1;dbname=xbk','xbk',
            'xbk1004');
        }catch(PDOException $e){
            $e->getMessage();
        }
    }
    
}
