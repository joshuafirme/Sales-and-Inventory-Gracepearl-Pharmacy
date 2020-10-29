
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $("#supplier-table").Tabledit({
          url: '/maintenance/supplier/action',
          dataType:"json",
          columns:{
              identifier:[0, 'supplierID'],
              editable:[[1, 'supplierName'], [2, 'address'], [3, 'person'], [4, 'contact']]
          },
          buttons: {
            edit: {
                class: 'btn btn-sm btn-primary',
                html: '<span class="fa fa-edit"></span>',
                action: 'edit'
            },
            delete: {        
                class: 'btn btn-sm btn-danger mr-1',
                attr: 'id="deleteSupplier" delete-id="{{ $data->supplierID }}',
                html: '<span class="fa fa-trash"></span>',
             
            },

            save: {
                class: 'btn btn-sm btn-success',
                action: 'save'
            }

        },
          restoreButton:false,
          onSuccess:function(data, textStatus, jqXHR){

            if(data.action == 'delete'){
                $('#'+data.id).remove();
            }
          }
      });
});
