<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">All amenities</h1>
    </div>
    <div>
        <?php if ($this->session->flashdata('msg_success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= $this->session->flashdata('msg_success') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('msg_error1')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $this->session->flashdata('msg_error1') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('msg_error2')) : ?>
            <div class="alert alert-warning" role="alert">
                <?= $this->session->flashdata('msg_error2') ?>
            </div>
        <?php endif; ?>
        <!-- Amenities form -->
        <div class="row justify-content-center">
            <fieldset class="col-8 col-md-6 px-3" style="border-radius: 4px; background-color: rgba(111, 66, 193, 0.3);">
                <legend style="background-color: #fff;border: 1px solid #ddd;border-radius: 4px;color: var(--purple);font-size: 17px;font-weight: bold;padding: 3px 5px 3px 7px;width: auto;">
                    My amenities
                </legend>
                <div class="row justify-content-center">
                    <form action="<?php if(isset($edit)){echo base_url('backoffice/update_amenities');}else{echo base_url('backoffice/add_amenities');};?>" method="POST">
                            <input type="hidden" name="idAmenities" class="form-control" value="<?php if (isset($edit)){echo $edit->id_amenities;};?>">
                            <div class="form-group col-sm-9 col-lg-6">
                                <label class="pt-2" for="nameAmenities">Name:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i data-feather="star"></i></div>
                                    </div>
                                    <input type="text" name="nameAmenities" id="nameAmenities" class="form-control" value="<?php if (isset($edit)){echo $edit->a_name;};?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-9 col-lg-6">
                                <label class="pt-2" for="descAmenities">Description :</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i data-feather="bookmark"></i></div>
                                    </div>
                                    <input type="text" name="descAmenities" id="descAmenities" class="form-control" value="<?php if (isset($edit)){echo $edit->a_description;};?>">
                                </div>
                            </div>
                        <input type="submit" class="btn btn-secondary col-sm-9 col-lg-6 m-2" id="submit-amenities" value="submit">
                    </form>
                </div>
        </div>
        </fieldset>
    </div>
    <div class="row justify-content-center m-4">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Desc</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($amenities->result() as $row) { ?>
                    <tr>
                        <th scope="row"><?php echo $row->id_amenities ?></th>
                        <td><?php echo $row->a_name ?></td>
                        <td><?php echo $row->a_description ?></td>
                        <td>
                            <a class="btn btn-info" href="<?= base_url('backoffice/edit_amenities/' . $row->id_amenities) ?>">Edit</a>
                            <a class="btn btn-danger" href="<?= base_url('backoffice/delete_amenities/' . $row->id_amenities) ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</main>
</div>
</div>