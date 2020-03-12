$(document).ready(function(){
  var url;
  function cellStyler(value,row,index){
			if (value < 30){
				return 'background-color:#ffee00;color:red;';
			}
		}
    $('#dgr').datagrid({
      url:'obtener_resultados',
      columns:[[
          {field:'token',title:'Ficha',width:50},
          {field:'employee_name',title:'Nombre',width:250},
          {field:'government_agency',title:'Departamento',width:250},
          {field:'productividad',title:'Productividad',width:100,styler:function(value,row){
                if(row.productividad == 50){
                    return 'background:lightgreen;color:black';
                }else if (row.productividad >= 40 && row.productividad <= 49) {
                  return 'background:lightyellow;color:black';
                }else if (row.productividad >= 30 && row.productividad <= 39) {
                  return 'background:lightpink;color:black';
                }else if (row.productividad <= 29) {
                  return 'background:red;color:black';
                }
            }},
          {field:'planificacion',title:'Planificación',width:100,styler:function(value,row){
                if(row.planificacion == 50){
                return 'background:lightgreen;color:black';
                }else if (row.planificacion >= 40 && row.planificacion <= 49) {
                  return 'background:lightyellow;color:black';
                }else if (row.planificacion >= 30 && row.planificacion <= 39) {
                  return 'background:lightpink;color:black';
                }else if (row.planificacion <= 29) {
                  return 'background:red;color:black';
                }
            }},
          {field:'liderazgo',title:'Liderazgo',width:100,styler:function(value,row){
                if(row.liderazgo == 50){
                return 'background:lightgreen;color:black';
              }else if (row.liderazgo >= 40 && row.liderazgo <= 49) {
                  return 'background:lightyellow;color:black';
                }else if (row.liderazgo >= 30 && row.liderazgo <= 39) {
                  return 'background:lightpink;color:black';
                }else if (row.liderazgo <= 29) {
                  return 'background:red;color:black';
                }
            }}
        ]]
      });

      $('#dept').combobox({
        url:'get_department',
        valueField:'id',
        textField:'government_agency',
        onChange:function(rec){
          doSearch(rec);
        }
      });

      function doSearch(rec){
        $('#dgr').datagrid('load',{
          government_agency_id:$('#dept').val()
        }).datagrid('Footer', [{itemid:'TotalPrice',listprice:'123'}]);

      }

      var exportResults = function(){
        $('#dgr').datagrid('print','resultados');
      }
      var searchData = function(){
        $('#dgr').datagrid('load',{
          search:$('#buscar').val()
        }).datagrid('Footer', [{itemid:'TotalPrice',listprice:'123'}]);
      }

      $('#exportResults').on('click', exportResults);
      $('#buscar').on('keyup', searchData);

    });
