<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->helper('url');
      $this->load->library('session');
      $this->load->model('m_modelo'); //carga del modelo que hice pruebas en el inicio
      $this->load->library('grocery_CRUD'); // carga de la librería groceryCRUD
      $this->load->helper('url');
    }

      public function index() 
      {
            redirect('inicio/administracion');
      }


      function administracion()
      {
      try{
      $crud = new grocery_CRUD();
       
      $crud->set_theme('datatables');
      $crud->set_table('contactos');
      $crud->display_as('id_programas','Programa');
      $crud->set_subject('Contactos');
      $crud->set_relation('id_programas','programas','nom_programas');
      $crud->set_language('spanish');

      /* Campos obligatorios con groceryCRUD */
      $crud->required_fields(
      'nombre',
      'apellido',
      'password'
      );

      /* Campos para mostrar con groceryCRUD */
      $crud->columns(
      'id',
      'nombre',
      'nombre',
      'apellido',
      'areas',
      'id_programas'
      );

      //$crud->add_fields('nombre','apellido');
      //$crud->edit_fields('nombre','apellido');
      
      $crud->field_type('areas','multiselect',
                                array( "1"  => "Administración", "2" => "Sistemas", "3"  => "Contabilidad", "4" => "Mecánica", "5" => "Electricidad", "6" => "Electrónica"));

      $crud->field_type('password', 'password');

      $crud->field_type('nom_programas','dropdown');

      $crud->set_field_upload('foto','assets/uploads/files');

      $output = $crud->render();


      $this->load->view('inicio/administracion', $output);

	}catch(Exception $e){
                  /* Si algo sale mal cachamos el error y lo mostramos */
                  show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }
      }

      function encrypt_password_callback($post_array, $primary_key = null)
      {
          $this->load->library('encrypt');
       
          $key = 'super-secret-key';
          $post_array['password'] = $this->encrypt->encode($post_array['password'], $key)      ;
          return $post_array;
      }
       
      function decrypt_password_callback($value)
      {
          $this->load->library('encrypt');
       
          $key = 'super-secret-key';
          $decrypted_password = $this->encrypt->decode($value, $key);
          return "<input type='password' name='password' value='$decrypted_password' />";
      }

      public function ver()
      {
            // Leo el modelo al controlador
            $contactos["listado_contactos"]=$this->m_modelo->ver();

            $this->load->view('inicio',$contactos);
      }

      public function json()
      {

            // Leo el modelo al controlador
            $contactos["listado_contactos"]=$this->m_modelo->ver();

            $this->load->view('json',$contactos);
      }

}
