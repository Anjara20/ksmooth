<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class backoffice_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    public function insert_data($mytable,$data){
        //$mytable=nom de la table
        //$data=donnee a insere
       if($this->db->insert($mytable,$data)){
           return true;
       }else{
           return false;
       }
    }

    public function insert_data_with_last_id($mytable,$data){
        if($this->db->insert($mytable,$data)){
            return $this->db->insert_id();
        }else{
            return 0;
        }
    }

    public function get_data($mytable){
        //$mytable=nom de la table
        $query=$this->db->get($mytable);
        return $query;
    }
    public function get_where_data($data,$array_data,$mytable){
        $query=$this->db->select($data)
                        ->get_where($mytable,$array_data)
                        ->row();
    }
    public function delete_data($idtable,$id,$mytable){
        //$idtable = id de la table
        //$mytable=nom de la table
        $this->db->where($idtable,$id);
        $this->db->delete($mytable);
    }
    public function edit_data($idtable,$id,$mytable){
         //$idtable = id de la table
        //$mytable=nom de la table
        $this->db->where($idtable,$id);
        $query=$this->db->get($mytable);
        return $query->row();
    }
    public function update_data($idtable,$data,$id,$mytable){
        //$idtable = id de la table
        //$data=donnee a mis a jour
        $this->db->where($idtable,$data[strval($id)]);
        $this->db->set($data);
        return $this->db->update($mytable);
    }

    //specialement pour data
    public function select_data_join($mytable,$fields,$data){
        //selectionner les champs fields
        foreach($fields as $key=>$value){
            $this->db->distinct();
            $this->db->select($value);
        };

        //de 
        $this->db->from($mytable);
        //join $data
        foreach($data as $coll=>$val){
            $this->db->join($coll,$val);
        }
        //obtenir valeur 
        $query=$this->db->get();
        
        return $query->result();
    
    }
}