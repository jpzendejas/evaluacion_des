$(document).ready(function(){
  var url;

  var newAnswer = function(){
      $('#dlg').dialog('open').dialog('center').dialog('setTitle','Nueva Respuesta');
      $('#fm').form('clear');
      url = 'save_answer';
  }

  var editAnswer=function(){
      var row = $('#dg').datagrid('getSelected');
      if (row){
          $('#dlg').dialog('open').dialog('center').dialog('setTitle','Editar Respuesta');
          $('#fm').form('load',row);
          url = 'update_answer/'+row.id;
      }
  }
  var saveAnswer=function(){
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
  var destroyAnswer=function(){
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
$('#newAnswer').on('click', newAnswer);
$('#saveAnswer').on('click', saveAnswer);
$('#editAnswer').on('click', editAnswer);
$('#destroyAnswer').on('click', destroyAnswer);

});
