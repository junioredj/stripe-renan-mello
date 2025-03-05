function myFunction() {

    var input, filter, table, tr, td, cell, i, j;
    input = document.getElementById("txt_consulta");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabela");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
      tr[i].style.display = "none";
      td = tr[i].getElementsByTagName("td");

    for (var j = 0; j < td.length; j++) {
         cell = tr[i].getElementsByTagName("td")[j];
         if (cell) {
            if (cell.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                break;
            }
         }
      }
    }
  }
