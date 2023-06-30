$(document).ready(function() {
    let json = '', table = '';
    let location =  window.location.protocol +"//"+ window.location.hostname;
    let url = window.location.protocol === "http:" ? location + "/api-loja-new" : location;
    
    let now = new Date();
    let yearMonth = moment(now).format('YYYYMM');



    let fncTable = function(data){
       $('#datatable').DataTable().destroy();
       $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: url + "/bestseller/"+data+"/edit",
        columns: [
            { "data": "id" , "defaultContent": ""},
            { "data": "descricao" , "defaultContent": ""},
            { "data": "codigo_produto" , "defaultContent": ""},
            { "data": "quantidade" , "defaultContent": ""},
            { "data": "data", "defaultContent": "" }
        ],
        "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable":true
            }
        ],
         language: {
                "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            }
    });

      /*table = $('#datatable').DataTable({
            "ajax":{
                "method": 'get',
                "processing": true,
                "serverSide": true,
                "headers": {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                "url": url + "/bestseller/"+data+"/edit"
            },
            "columns": [
                
                { "data": "id" , "defaultContent": ""},
                { "data": "codigo_produto" , "defaultContent": ""},
                { "data": "descricao" , "defaultContent": ""},
                { "data": "quantidade" , "defaultContent": ""},
                { "data": "data", "defaultContent": "" },
            ],
              "columnDefs": [
                  {
                      "targets": [ 1 ],
                      "visible": false,
                      "searchable":true
                  }
              ],
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
            },
            order: [[ 4, "desc" ]],
        });*/
    }


    /***
     * #########################################################
     * ###########      ONLOAD   ##############################
     * ########################################################
     * */
    //fncDataCards(yearMonth,false).then();
   // fncTable(yearMonth);
   fncTable("202209");
});