$(document).ready(function(){
  var url;

  var newEmployee = function(){
      $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nuevo Empleado');
      $('#fm').form('clear');
      $('#government_agency_id').combobox({
        url:'/get_department',
        valueField:'id',
        textField:'government_agency'
      });
      $('#parent_token').combobox({
        url:'/get_parent_token',
        valueField:'token',
        textField:'token'
      });
    url = 'save_employee';
  }

  var editEmployee=function(){
      var row = $('#dg').datagrid('getSelected');
      if (row){
          $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Empleado');
          $('#fm').form('load',row);
          $('#government_agency_id').combobox({
            url:'/get_department',
            valueField:'id',
            textField:'government_agency',
            value:row.government_agency_id
          });
          $('#parent_token').combobox({
            url:'/get_parent_token',
            valueField:'token',
            textField:'token',
            value:row.parent_token
          });
          url = 'update_employee/'+row.id;
      }
  }
  var saveEmployee=function(){
      $('#fm').form('submit',{
          iframe:false,
          url: url,
          headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
          },
          onSubmit: function(){
              return $(this).form('validate');
          },
          success: function(result){
              var result = eval('('+result+')');
              if (result.errorMsg){
                  $.messager.show({
                      title: 'Evaluación Desempeño',
                      msg: result.errorMsg
                  });
              } else {
                  $('#dlg').dialog('close');        // close the dialog
                  $('#dg').datagrid('reload');    // reload the user data
              }
          }
      });
  }
  var destroyEmployee=function(){
      var row = $('#dg').datagrid('getSelected');
      if (row){
          $.messager.confirm('Evaluacion Desempeño','Eliminar Empleado?',function(r){
              if (r){
                  $.post('destroy_employee',{id:row.id},function(result){
                      if (result.success){
                          $('#dg').datagrid('reload');    // reload the user data
                      } else {
                          $.messager.show({    // show error message
                              title: 'Evaluacion Desempeño',
                              msg: result.errorMsg
                          });
                      }
                  },'json');
              }
          });
      }
  }
$('#newEmployee').on('click', newEmployee);
$('#saveEmployee').on('click', saveEmployee);
$('#editEmployee').on('click', editEmployee);
$('#destroyEmployee').on('click', destroyEmployee);

});
