<?php 	/**Utilizamos este script php para instanciar el cliente mongoDB desde un único sitio**/
	try{
		$client = new MongoClient();
	} catch(MongoException $e){
		echo "<p>Please, check Mongo DB server is started</p>"; 
	}
?>