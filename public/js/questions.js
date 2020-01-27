$(document).ready(function(){
  var url;

  var newQuestion = function(){
      $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nueva Pregunta');
      $('#fm').form('clear');
      url = 'save_question';
  }

  var editQuestion=function(){
      var row = $('#dg').datagrid('getSelected');
      if (row){
          $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Pregunta');
          $('#fm').form('load',row);
          url = 'update_question/'+row.id;
      }
  }
  var saveQuestion=function(){
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
  var destroyQuestion=function(){
      var row = $('#dg').datagrid('getSelected');
      if (row){
          $.messager.confirm('OMC Calibrations','Eliminar Pregunta?',function(r){
              if (r){
                  $.post('destroy_status',{id:row.id},function(result){
                      if (result.success){
                          $('#dg').datagrid('reload');    // reload the user data
                      } else {
                          $.messager.show({    // show error message
                              title: 'OMC Calibrations',
                              msg: result.errorMsg
                          });
                      }
                  },'json');
              }
          });
      }
  }
$('#newQuestion').on('click', newQuestion);
$('#saveQuestion').on('click', saveQuestion);
$('#editQuestion').on('click', editQuestion);
$('#destroyQuestion').on('click', destroyQuestion);

});
