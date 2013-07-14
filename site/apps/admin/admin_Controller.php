<?php

/**
* Plantilla de la clase appController para Balero CMS.
* Coloque aqui la entrada/salida de datos.
* Llame desde ésta clase los modelos/vistas 
* correspondientes de cada controlador.
**/

class admin_Controller {
	
	/**
	* Variables para heredar los métodos de el modelo y la vista.
	**/

	public $objModel;
	public $objView;
	
		
	/**
	* Los cargamos en el constructor
	**/

	public function __construct($menu) {
		
		try {
			$this->objModel = new admin_Model();
			$this->objView = new admin_View();
			$this->objView->menu = $menu;
			
		} catch (Exception $e) {
			
		}
		
		// Automatizar el controlador
		$handler = new ControllerHandler($this);
	}
		
	/**
	* Método principal llamado main() (similar a C/C++)
	**/

	public function main() {
	
		try {
		$this->settings_controller();
		$this->objView->settings_view();
		$this->objView->Render();	
		} catch (Exception $e) {
			
		}
		
	}
	
	/**
	* Métodos
	**/
		
	
	public function settings_controller() {
		
		if(isset($_POST['submit'])) {
			
			
			try {
			
			// url friendly prox. versiones
			//$this->objModel->save_custom_settings($_POST['themes'], $_POST['url_friendly'], $_POST['pages']);
			
			$this->objModel->save_custom_settings($_POST['themes'], $_POST['pages']);
				
			$admcfg = new XMLHandler(LOCAL_DIR . "/site/etc/balero.config.xml");
		
			$admcfg->editChild("/config/site/title", $_POST['title']);
			$admcfg->editChild("/config/site/url", $_POST['url']);
			$admcfg->editChild("/config/site/description", $_POST['description']);
			$admcfg->editChild("/config/site/keywords", $_POST['keywords']);
			
			$ok = new Tips();
			$this->objView->content .= $ok->green(_DATA_OK);
			
			} catch (Exception $e) {
				$ok = new Tips();
				$ok->green(_DATA_ERROR . " " . $e->getMessage());
			}
		}

	}
	
	public function test_db() {
		
		$this->objModel->test_db_model();
		
	}
	
	public function logout() {
		if(isset($_COOKIE['admin_god_balero'])) {
			setcookie("admin_god_balero", "", time()-3600);
			header("Location: index.php?app=admin");
		} else {
			// forzar
			setcookie("admin_god_balero", "", time()-3600);
			$this->objView->content .= _COOKIE_ERROR;
		}
	}
	
	public function get_regs_in_controller($name) {
		
		$regs = $this->objModel->get_regs(name);
		
		return $regs;
		
	}
	

	
}
