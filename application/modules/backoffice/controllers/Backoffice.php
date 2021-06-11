<?php (defined('BASEPATH')) or exit('No direct script access allowed');

class Backoffice extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('backoffice_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('calendar', array(
            'show_next_prev' => TRUE,
            'next_prev_url' => 'http://localhost/ksmooth/backoffice/view_available_room'
        ));
        $this->load->helper('email');
        $this->load->helper('security');
    }
    public function index()
    {
        //affiche login_page
        $this->load->view('login_page/login');
    }
    public function home()
    {
        //affiche homepage de Backoffice
        if (!$this->session->userdata('log_in')) {
            $this->index();
        } else {
            $this->load->view('includes/header');
            $this->load->view('includes/navbar');
            $this->load->view('includes/sidebar');
            $this->load->view('content/home');
            $this->load->view('includes/footer');
        }
    }

    public function view_room($id = null)
    {

        //pour affichage de la room_details page

        //pour affichage room seulement
        /*$data_fields = array(
            'room_id' => 'ks_room.id_room',
            'room_name' => 'ks_room.r_name',
            'room_desc' => 'ks_room.r_description',
        );
        $data_table = array(
            'from_room' => 'ks_room',
        );
        $data_join = array(
            'ks_amenitieroom' => 'ks_room.id_room=ks_amenitieroom.id_room'
        );
        $this->backoffice_model->select_data_join($data_table, $data_fields, $data_join)*/

        //pour affichage amenities seulement
        $room_details = $this->backoffice_model->get_data('ks_room')->result();
        $result = array();
        //$result=$this->db->query($query)->result();
        for ($i = 0; $i < count($room_details); $i++) {
            $id_room = $room_details[$i]->id_room;
            $query = "SELECT DISTINCT  ks_amenities.a_name FROM ks_amenities INNER JOIN ks_amenitieroom WHERE ks_amenities.id_amenities=ks_amenitieroom.id_amenities AND ks_amenitieroom.id_room='$id_room'";
            $result[$i] = $this->db->query($query)->result();
        };
        $data = array(
            'amenities' => $this->backoffice_model->get_data('ks_amenities'),
            'room_details' => $room_details,
            'amenities_each_room' => $result
        );

        if (!$this->session->userdata('log_in')) {
            $this->index();
        } else {
            $this->load->view('includes/header');
            $this->load->view('includes/navbar');
            $this->load->view('includes/sidebar');
            $this->load->view('content/room_details', $data);
            $this->load->view('includes/footer');
        }
    }

    public function view_available_room()
    {
        $data = array(
            'room' => $this->backoffice_model->get_data('ks_room')
        );
        if (!$this->session->userdata('log_in')) {
            $this->index();
        } else {
            $this->load->view('includes/header');
            $this->load->view('includes/navbar');
            $this->load->view('includes/sidebar');
            $this->load->view('content/available_room', $data);
            $this->load->view('includes/footer');
        }
    }

    public function view_amenities($id = null)
    {
        // pour affichage amenities page
        $query = array(
            'amenities' => $this->backoffice_model->get_data('ks_amenities'),
            'edit' => $this->backoffice_model->edit_data('id_amenities', $id, 'ks_amenities')
        );
        if (!$this->session->userdata('log_in')) {
            $this->index();
        } else {

            $this->load->view('includes/header');
            $this->load->view('includes/navbar');
            $this->load->view('includes/sidebar');
            $this->load->view('content/amenities', $query);
            $this->load->view('includes/footer');
        }
    }
    public function view_customer()
    {
        if (!$this->session->userdata('log_in')) {
            $this->index();
        } else {
            $this->load->view('includes/header');
            $this->load->view('includes/navbar');
            $this->load->view('includes/sidebar');
            $this->load->view('content/customer');
            $this->load->view('includes/footer');
        }
    }



    /*--------------------MotorCI--------------------------------- */
    public function login2()
    {
        $mail = $this->security->xss_clean($this->input->post('mail'));
        $password = $this->security->xss_clean($this->input->post('password'));
        if (!empty($mail)) {
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                echo 'invalid email';
            } else {
                $this->db->where('mail', $mail);
                $data = $this->db->get('login')->row();
                if (count($data) > 0) {
                    if ($mail == $data->mail) {
                        echo 'success';
                        $sdata = array(
                            'log_username' => $data->username,
                            'log_mail' => $data->mail,
                            'log_password' => $data->password,
                            'log_in' => true
                        );
                        $this->session->set_userdata($sdata);
                    }
                } else {
                    echo 'you are not the admin';
                };
            };
        };

        if (!empty($password)) {
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            if (!$uppercase) {
                echo 'Your password must contain at least 1 uppercase letter</br>';
            };
            if (!$lowercase) {
                echo 'your password must contain at least 1 lowercase letter</br>';
            };
            if (!$number) {
                echo 'your password must contain at least 1 number</br>';
            };
            if (strlen($password) < 6) {
                echo 'your password is too short';
            };
            if ($uppercase && $lowercase && $number && (strlen($password) >= 6)) {
                if ($password == $this->session->userdata('log_password')) {
                    echo 'success';
                    exit();
                } else {
                    echo 'invalid password';
                };
            };
        };
        if ($this->input->post('checkAll')) {
            echo 'done';
        };
    }




    /*Amenities */
    public function add_amenities()
    {
        //ajout d'equipement
        $a_name = $this->input->post('nameAmenities');
        $a_description = $this->input->post('descAmenities');
        $data = array(
            'a_name' => $a_name,
            'a_description' => $a_description
        );
        if ($a_name != '') {
            if ($this->backoffice_model->insert_data('ks_amenities', $data)) {
                $this->session->set_flashdata('msg_success', 'success');
                redirect(base_url('backoffice/view_amenities'));
            } else {
                $this->session->set_flashdata('msg_error1', 'Something wrong');
                redirect(base_url('backoffice/view_amenities'));
            }
        } else {
            $this->session->set_flashdata('msg_error2', 'all the fields must be filled in');
            redirect(base_url('backoffice/view_amenities'));
        }
    }
    public function delete_amenities($id)
    {
        $this->backoffice_model->delete_data('id_amenities', $id, 'ks_amenities');
        redirect(base_url('backoffice/view_amenities'));
    }

    public function edit_amenities($id)
    {
        $this->view_amenities($id);
    }

    public function update_amenities()
    {
        //data=donne mis a jour
        $a_name = $this->input->post('nameAmenities');
        $a_description = $this->input->post('descAmenities');
        $id_amenities = $this->input->post('idAmenities');
        $id = 'id_amenities';
        $data = array(
            'id_amenities' => $id_amenities,
            'a_name' => $a_name,
            'a_description' => $a_description
        );
        if ($a_name != '') {
            if ($this->backoffice_model->update_data('id_amenities', $data, $id, 'ks_amenities')) {
                $this->session->set_flashdata('msg_success', 'success');
                redirect(base_url('backoffice/view_amenities'));
            } else {
                $this->session->set_flashdata('msg_error1', 'Something wrong');
                redirect(base_url('backoffice/view_amenities'));
            }
        } else {
            $this->session->set_flashdata('msg_error2', 'all the fields must be filled in');
            redirect(base_url('backoffice/view_amenities'));
        }
    }
    /*Fin Amenities */




    /*For Room */
    public function add_room()
    {
        $amenities_view = array();
        $amenities_view_final = array();
        //recupere le length amenities dans view a l'aide AJAX
        $length = $this->input->post('length_amenities');
        //insertion de donnes dans une tableau $amenities_view 
        for ($i = 0; $i < $length; $i++) {
            $amenities_view[$i] = $this->input->post('amenities' . $i);
        };

        //suppression de donnee "null" en cas de suppression d'amenities dans room_details.php
        /*$i = 0;
        $j = 0;
        while ($i < $length) {
            if (empty($amenities_view[$i])) {
                $i++;
            } else {
                $amenities_view_final[$j] = $amenities_view[$i];
                $j++;
                $i++;
            };
        };*/

        //preparation de donne a inserer dans la base de donnee 
        $l_amenities = $this->input->post('length_amenities');
        $amenities = $this->backoffice_model->get_data('ks_amenities')->result();
        //insertion des donnees dans ks_room
        if ($this->input->post('r_name') == "" || $this->input->post('r_desc') == "" || ($this->input->post('r_name') == "" && $this->input->post('r_desc') == "")) {
            $this->session->set_flashdata('msg_error0', 'Empty fields');
            redirect('backoffice/view_room');
        } else {
            $data_room = array(
                'r_name' => $this->input->post('r_name'),
                'r_description' => $this->input->post('r_desc')
            );
            $id_room = $this->backoffice_model->insert_data_with_last_id('ks_room', $data_room);
            //recuperation des 2 ids : id_room et id_amenities
            for ($i = 0; $i < count($amenities_view); $i++) {
                if ($amenities[$i]->a_name == $amenities_view[$i]) {
                    $data_amenities_room = array(
                        'id_amenities' => $amenities[$i]->id_amenities,
                        'id_room' => $id_room
                    );
                    $this->backoffice_model->insert_data('ks_amenitieroom', $data_amenities_room);
                };
            };
            $this->session->set_flashdata('msg_success', 'success');
            redirect(base_url('backoffice/view_room'));
        };
    }



    function RoomAndAmenities($query)
    {
        $data = [];
        //si $query est non vide, recupere $id_room
        $id_room = $query->id_room;
        //cette requete consiste a selectionner les amenities correspond a l'id room donnee
        $query_amenities = "SELECT DISTINCT  ks_amenities.a_name,ks_amenities.id_amenities FROM ks_amenities INNER JOIN ks_amenitieroom WHERE ks_amenities.id_amenities=ks_amenitieroom.id_amenities AND ks_amenitieroom.id_room='$id_room'";
        $result_amenities = $this->db->query($query_amenities)->result();
        $amenities = $this->backoffice_model->get_data('ks_amenities')->result();
        if (!empty($result_amenities) && empty($this->input->post("deleted_amenities"))) {
            $data = array(
                'room_name' => $query->r_name,
                'room_description' => $query->r_description,
                'room_amenities' => $result_amenities,
                'room_all_amenities' => $amenities

            );
            echo json_encode($data);
        } else if (empty($this->input->post("deleted_amenities"))) {
            $data = array(
                'room_name' => $query->r_name,
                'room_description' => $query->r_description,
                'room_amenities' => 0,
                'room_all_amenities' => $amenities
            );
            echo json_encode($data);
        }
        return $data;
    }

    public function final_edit_room()
    {
        
        $key_of_deleted_amenities=0;
        $data=[];
         $rest_in_back=[];
         $move_to_front=[];;
        if (isset($_POST['roomName'])) {

            $query = $this->backoffice_model->edit_data('r_name', $this->input->post('roomName'), 'ks_room');
            $id_room = $query->id_room;

            //query for amenities depends on roomName
            $query_amenities = "SELECT DISTINCT  ks_amenities.a_name
                              FROM ks_amenities 
                              INNER JOIN ks_amenitieroom 
                              WHERE ks_amenities.id_amenities=ks_amenitieroom.id_amenities 
                              AND ks_amenitieroom.id_room='$id_room'";
            foreach($this->db->query($query_amenities)->result() as $one_item){
                 $move_to_front[]=$one_item->a_name;
            }
            //query for amenities wich not depends on roomName , if exist;
            $query_amenities = "SELECT  ks_amenities.a_name FROM ks_amenities";
            $result=array();
            foreach($this->db->query($query_amenities)->result() as $one_item){
                $result[]=$one_item->a_name;
            }
            $rest_in_back=explode(",",implode(",",array_diff($result,$move_to_front)));
            
            $data = array(
                'move_to_front' => $move_to_front,
                'rest_in_back'=>$rest_in_back,
                'room_name' => $query->r_name,
                'room_description' => $query->r_description
            ); 
            echo JSON_encode($data);
        }

        
    }


    public function edit_room()
    {
        $data = [];
        //$id_amenities=[];
        //recuperer valeur de room_name
        $room_name = $this->input->post("roomName");

        //obtention des donnees (room) en fonction de room_name 
        if (!empty($room_name)) {
            $query = $this->backoffice_model->edit_data('r_name', $room_name, 'ks_room');
            $data = $this->RoomAndAmenities($query);
        };

        //obtention de donnee amenities supprime
        if (!empty($this->input->post('deleted_amenities'))) {
            $array_of_delete_amenities = $this->input->post('deleted_amenities');
            $id_room = $this->backoffice_model->edit_data('r_name', $room_name, 'ks_room')->id_room;
            $amenities_result = $this->db->query("SELECT DISTINCT  ks_amenities.a_name,ks_amenities.id_amenities 
                                            FROM ks_amenities 
                                            INNER JOIN ks_amenitieroom 
                                            WHERE ks_amenities.id_amenities=ks_amenitieroom.id_amenities 
                                            AND ks_amenitieroom.id_room='$id_room'")
                ->result();
            $all_amenities = $this->backoffice_model->get_data('ks_amenities')->result();

            //recuperation de l'id dans $result_amenities
            if (!empty($amenities_result)) {
                for ($i = 0; $i < count($amenities_result); $i++) {
                    $id_amenities[$i] = $amenities_result[$i]->id_amenities;
                };
            } else {
                $id_amenities = 0;
            };

            //recuperation de l'id de all_amenities
            for ($i = 0; $i < count($all_amenities); $i++) {
                $id_all_amenities[$i] = $all_amenities[$i]->id_amenities;
            };

            //recuperation d'id non-match-amenities de id_all_amenities et id_amenities + transformation tableau
            $result = array_diff($id_all_amenities, $id_amenities);
            if (!empty($result)) {
                $result_text = implode(',', $result);
                $result_array = explode(',', $result_text);
                for ($i = 0; $i < count($result_array); $i++) {
                    $non_match_amenities[$i] = $this->db->select('a_name')
                        ->get_where('ks_amenities', array('id_amenities' => $result_array[$i]))
                        ->row()
                        ->a_name;
                }
                $array_final = array_merge($non_match_amenities, $array_of_delete_amenities);
                $data_amenities = array(
                    'deleted_amenities' => $array_final
                );
            } else {
                $data_amenities = array(
                    'deleted_amenities' => $array_of_delete_amenities
                );
            }
            echo json_encode($data_amenities);
        }
    }



    public function edit_room2()
    {
        $non_match_amenities = array();
        if ($this->input->post("delete_amenities")) {
            $delete_amenities = $this->input->post('delete_amenities');

            $query = $this->backoffice_model->edit_data('r_name', $this->input->post('roomName'), 'ks_room');
            $id_room = $query->id_room;
            $query_amenities = "SELECT DISTINCT  ks_amenities.a_name,ks_amenities.id_amenities FROM ks_amenities INNER JOIN ks_amenitieroom WHERE ks_amenities.id_amenities=ks_amenitieroom.id_amenities AND ks_amenitieroom.id_room='$id_room'";
            $result_amenities = $this->db->query($query_amenities)->result();
            $all_amenities = $this->backoffice_model->get_data('ks_amenities')->result();
            if (!empty($result_amenities)) {
                /**
                 * PORTION DE CODE QUI ENGLOBE LA RECHERCHE DES AMENITIES NON PRESENTES DANS LE VIEW
                 */
                //recuperation de l'id dans $result_amenities
                for ($i = 0; $i < count($result_amenities); $i++) {
                    $id_amenities[$i] = $result_amenities[$i]->id_amenities;
                };

                //recuperation de l'id de all_amenities
                for ($i = 0; $i < count($all_amenities); $i++) {
                    $id_all_amenities[$i] = $all_amenities[$i]->id_amenities;
                };

                //recuperation d'id non-match-amenities de id_all_amenities et id_amenities
                $result = array_diff($id_all_amenities, $id_amenities);
                $result_text = implode(',', $result);
                $result_array = explode(',', $result_text);

                for ($i = 0; $i < count($result_array); $i++) {
                    $non_match_amenities[$i] = $this->db->select('a_name')
                        ->get_where('ks_amenities', array('id_amenities' => $result_array[$i]))
                        ->row()
                        ->a_name;
                }
                $array_final = array_merge($non_match_amenities, $delete_amenities);
                /**
                 * FIN DE PORTION DE CODE QUI ENGLOBE LA RECHERCHE DES AMENITIES NON PRESENTES DANS LE VIEW
                 */
                $data = array(
                    'delete_amenities' => $array_final
                );
                echo json_encode($data);
            }
        }
    }
}
