<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">My Room's details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
        </div>
    </div>

    <div>
        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModalAdd">
            <span data-feather="plus-circle"></span>Add room
        </button>
        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModalEdit">
            <span data-feather="plus-circle"></span>Modify room
        </button>

    </div>
    <?php if ($this->session->flashdata('msg_error0')) : ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?= $this->session->flashdata('msg_error0') ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('msg_success')) : ?>
        <div class="alert alert-success mt-3" role="alert">
            <?= $this->session->flashdata('msg_success') ?>
        </div>
    <?php endif; ?>

    <table class="table mt-4">
        <thead class="thead-dark">
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Amenities</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($room_details); $i++) : ?>
                <tr>
                    <th scope="row"><?= $room_details[$i]->id_room ?></th>
                    <td><?= $room_details[$i]->r_name ?></td>
                    <td><?= substr($room_details[$i]->r_description, 0, 50) ?></td>
                    <?php for ($j = $i; $j <= $i; $j++) : ?>
                        <?php foreach ($amenities_each_room[$j] as $rows) : ?>
                            <td class="badge badge-secondary m-1"><?= $rows->a_name . '' ?></td>
                        <?php endforeach; ?>
                    <?php endfor; ?>
                    <td><button class="btn btn-danger">Delete</button></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</main>
</div>
</div>

<!--Modal Add room-->
<div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title" id="myModalLabel">Add room section</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('backoffice/add_room') ?>">
                    <!-- Description room -->
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="text" name="r_name" class="form-control" id="inputName" aria-describedby="nameHelp" placeholder="Enter room name">
                    </div>
                    <div class="form-group">
                        <label for="inputDesc">Description</label>
                        <textarea class="form-control" name="r_desc" id="inputDesc" cols="10" rows="10"></textarea>
                    </div>
                    <!-- Amenities -->
                    <div class="form-group">
                        <label for="inputDesc">Available amenities</label>
                        <hr>
                        <?php $i = 0; ?>
                        <?php $qlength = count($amenities->result()); ?>
                        <?php foreach ($amenities->result() as $row) : ?>
                            <?php if ($i < $qlength) : ?>
                                <div class="input-group mb-2" name="amenities" id="<?php echo 'forAmenities' . $i; ?>">
                                    <input type="text" name="<?php echo 'amenities' . $i; ?>" id="<?php echo 'r_amenities' . $i; ?>" class="form-control" readonly="yes" value="<?php echo $row->a_name; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" id="<?php echo 'bAmenities' . $i ?>" type="button">&times;</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </div>
                    <!--Contenir le nombre d'amenities actuel-->
                    <input type="hidden" id="l_amenities" name="length_amenities">
                    <hr>
                    <!-- Media(galery/pictures) -->
                    <button type="submit" id="r_submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!--Modal edit room-->
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title" id="myModalLabel">Edit room section</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" id="message_on_edit"></div>
                <form method="post" action="<?= base_url('backoffice/add_room') ?>">
                    <!-- Description room -->
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">room name</label>
                        <select class="form-control" id="selectRoomName" name="roomName">
                            <option value="">Select room name</option>
                            <?php foreach ($room_details as $row) : ?>
                                <option value='<?= $row->r_name ?>'><?= $row->r_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputDesc">Description</label>
                        <textarea class="form-control" name="r_desc_on_edit" id="inputDesc" value="ok" cols="10" rows="10"></textarea>
                    </div>
                    <!-- Amenities -->
                    <div class="form-group" id="available_amenities_on_edit">
                        <label for="inputDesc">Available amenities</label>
                        </div>
                        <div class="amenities_accepted">
                        <hr>
                        <table class="amenities_management">
                                <thead>
                                    <tr>
                                        <th>Amenities stored</th>
                                        <th>Amenities accepted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td id="amenities_stored">
                                    </td>
                                    <td id="amenities_accepted">
                                    </td>
                                </tbody>
                        </table>
                    </div>
                    <!--Contenir le nombre d'amenities actuel-->
                    <input type="hidden" id="l_amenities" name="length_amenities">
                    <!--Contenir amenities supprimee -->
                    <!--<input type="hidden" id="delete_amenities" name="delete_amenities">-->

                    <hr>
                    <!-- Media(galery/pictures) -->
                    <button type="submit" id="r_submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>