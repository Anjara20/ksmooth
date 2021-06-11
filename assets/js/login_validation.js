$(document).ready(function(){
    $('#submit-amenities').click(function(){

        var name=$('#nameAmenities').val();
        var description=$('#descAmenities').val();

        if(name!=''){
            JQuery.ajax({
                type:'POST',
                url:"<?= base_url('backoffice/add_amenities')?>",
                dataType:'html',
                data:{name:name,description:description},
                success:function(result){
                    if(result=='saved successfully'){
                        alert(result);
                    }
                    else{
                        alert(result);
                    }
                },
                error:function(){
                    alert('error');
                }
            });
        }
        else{
            alert('fill all fields  first');
        }

        
    })
});