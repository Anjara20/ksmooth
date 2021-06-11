<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Login_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function get_data($attr,$name){
        //recuperer donnees via database
        /*
            $attr attribut de la base de donne
            $name nom de la table
        */
        $this->db->select($attr);
        return $this->db->get($name);
    }


    public function login(){
        //recuperation de donnee
        $mail=$this->security->xss_clean($this->input->post('mail'));
        $password=$this->security->xss_clean($this->input->post('password'));

        //preparation de la requete
        $this->db->where('mail',$mail);
        $this->db->where('password',$password);

        //lancement de la requete
        $data=$this->db->get('login')->row();
        if(count($data)>0){
            $sdata=array(
                'log_username'=>$data->username,
                'log_mail'=>$data->mail,
                'log_password'=>$data->password,
                'log_in'=>true
            );
            $this->session->set_userdata($sdata);
            return true;
        }
        else{
            return false;
        }

    }
}