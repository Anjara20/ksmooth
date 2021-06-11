<footer class="my-5 pt-6 text-muted text-center text-small">
    <p class="mb-1">&copy; 2020-2021 ANDRIANILANA Anjaramamy Liantsoa</p>
    <ul class="list-inline">
        <li class="list-inline-item"><a href="#">Privacy</a></li>
        <li class="list-inline-item"><a href="#">Terms</a></li>
        <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
</footer>
<!-- Bootstrap core JavaScript
    ================================================== -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    window.jQuery || document.write('<script src="<?= base_url('assets/bootstrap-4.0.0/js/vendoe/jquery-slim.min.js') ?>"><\/script>')
</script>
<script src="<?= base_url('assets/bootstrap-4.0.0/js/vendor/pooper.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-4.0.0/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-4.0.0/dist/util.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-4.0.0/dist/modal.js') ?>"></script>
<script src="<?= base_url('assets/bootstrap-4.0.0/dist/popover.js') ?>"></script>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>


<script>
    $(document).ready(function() {
        //affichage amenities//gestion amenities room_details.php
        var $newTagLength;
        var $taglength;
        var recep;
        var count;

        /*$('#l_amenities').attr('value', $taglength);
        $.ajax({
            type: 'POST',
            url: "<//?= //base_url('backoffice/add_room') ?>",
            data: {
                'length_amenities': $('#l_amenities').val()
            }
        });*/

        //Edit room
        if ($('#myModalEdit').length) {
            $("div[id='message_on_edit']").html("make your choice :)");
        };
        $("#selectRoomName").change(function() {
            let roomname = $("#selectRoomName").val();
            $("div[name='amenities_edit']").remove();
            if ($("#selectRoomName").val() == "") {
                $("div[id='message_on_edit']").html("make your choice :)");
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('backoffice/final_edit_room') ?>",
                    data: {
                        'roomName': roomname
                    },
                    success: function(data) {
                        //recuperation de donne en JSON et transformation en objet
                        recep = JSON.parse(data);
                        console.table(recep);
                        //affichage de message 
                        $("#message_on_edit").html(recep.room_name + " choosed");

                        //affichage de donnee sur textArea
                        $("textarea[name='r_desc_on_edit']").val(recep['room_description']);

                        //affichage des amenities en fonction de room selectionnee
                        let div_parent = $("#amenities_accepted");
                        for (let i = 0; i < recep.move_to_front.length; i++) {
                            div_parent.append($("<div/>")
                                .addClass("input-group mb-2")
                                .attr("name", "amenities_edit")
                                .attr("id", "forAmenities_on_edit" + i)
                                .append($("<input/>")
                                    .addClass("form-control")
                                    .attr("name", "amenities_accepted" + i)
                                    .attr("id", "amenities_ok" + i)
                                    .attr("value", recep.move_to_front[i])
                                    .attr('draggable',true)
                                    .prop("readonly", true)
                                    
                                )
                            );
                            
                        };
                        for (let j = 0; j < recep.rest_in_back.length; j++) {
                            $("#amenities_stored").append($("<div/>")
                                .addClass("input-group mb-2")
                                .attr("name", "amenities_edit")
                                .attr("id", "forAmenities_on_edit" + j)
                                .append($("<input/>")
                                    .addClass("form-control")
                                    .attr("name", "amenities_stored" + j)
                                    .attr("id", "amenities_bd" + j)
                                    .attr("value", recep.rest_in_back[j])
                                    .attr("draggable", true)
                                    .prop("readonly", true)
                                )
                            );

                        };

                    }
                });
            };

        });
        // //Si je souhaite ajouter amenities 
        // var k = 0;
        // $("#bAdd_others").click(function() {
        //     let div_parent = $("#available_amenities_on_edit");
        //     if (k < recep.room_all_amenities.length) {
        //         div_parent.append($("<div/>")
        //             .addClass("input-group mb-2")
        //             .attr("name", "amenities_on_add")
        //             .attr("id", "forAmenities_on_add" + k)
        //             .append($("<input/>")
        //                 .addClass("form-control")
        //                 .attr("name", "amenities_on_edit" + k)
        //                 .attr("id", "amenities_on_edit" + k)
        //                 .attr("value", recep.room_all_amenities[k].a_name)
        //                 .prop("readonly", true)
        //             )
        //             .append($("<div/>")
        //                 .addClass("input-group-append")
        //                 .append($("<button/>")
        //                     .addClass("btn btn-secondary")
        //                     .attr("id", "bAmenities_on_add" + k)
        //                     .attr("type", "button")
        //                     .html('&times;')
        //                 )
        //             )
        //         );
        //         k++;
        //     };

        // });

    });
    //Drag and drop system for Amenities

    
    
    
    
</script>
</body>

</html>