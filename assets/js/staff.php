<?php
  header("Content-type: application/javascript");
  $url = urldecode($_GET["url"]);
?>
/*
** deleted_data is a global variable located on hansontable script, added by myself 
*/
var errors = 0;
$(document).ready(function(){
  $("#staff_birthdate" ).datepicker({
    dateFormat: "yy-mm-dd"
  });
  var staff_sex = $("#staff_sex").val() == "laki-laki" ? "Istri":"Suami";
  $("#staff_sex").on("change", function(e){
    var sex = $(this).val();
    if(sex == "laki-laki") relation[0] = "Istri";
    else relation[0] = "Suami";
  });
  var relation = [staff_sex, "Ayah", "Ibu", "Anak Ke-1", "Anak Ke-2", "Anak Ke-3", "Anak Ke-4", "Anak Ke-5"];
  
  $("#family_table").handsontable({
    colHeaders: ["Name", "Birthdate", "Birthplace", "Sex", "Relation", ""], // hidden col for ID and edit flag
    startCols: 6,
    startRows: 3,
    minSpareRows: 1,
    contextMenu: true,
    colWidths: [120, 80, 80, 60, 120],
    onChange: function(update, source){
      if(source != "alter"){ // there's no changes on columns, no need to flag 1
        var row = update[0][0];
        var data = $("#family_table").handsontable("getData")[row];
        var url = "<?php echo $url.'/staffs/update_family'; ?>";
        $.post(url, {
          id: data[5],
          name: data[0],
          birthdate: data[1],
          birthplace: data[2],
          sex: data[3],
          relation: data[4]  
        }, function(data){
          console.log(data);  
        });
      }
      
      // delete row ajax
      if(source == "alter"){
        var id = deleted_data[5];
        var url = "<?php echo $url.'/families/ajax_delete/'; ?>"+id;
        $.get(url, function(data){
          console.log(data);
        });
      }
    },
    columns: [
      {},
      {type:'date'},
      {},
      {
        type: "autocomplete",
        source: ["Laki - laki", "Perempuan"],
        strict: true
      },
      {
        type: "autocomplete",
        source: relation,
        strict: true
      }
    ]
  });
  
  
  /*Medic table*/
  $("#medic_table").handsontable({
    colHeaders: ["Date", "Description", ""], // hidden col for ID and edit flag
    startCols: 3,
    startRows: 3,
    minSpareRows: 1,
    colWidths: [50, 500],
     columns: [{type:'date'},{}],
    contextMenu: true,
    onChange: function(update, source){
      if(source != "alter"){ // there's no changes on columns, no need to flag 1
        var row = update[0][0];
        var data = $("#medic_table").handsontable("getData")[row];
        var url = "<?php echo $url.'/staffs/update_medic'; ?>";
        $.post(url, {
          id: data[2],
          date: data[0],
          description: data[1]
        }, function(data){
          console.log(data);
        });
      }
      
      // delete row ajax
      if(source == "alter"){
        var id = deleted_data[2];
        var url = "<?php echo $url.'/medical_histories/ajax_delete/'; ?>"+id;
        $.get(url, function(data){
          console.log(data);
        });
      }
    }
  });
  
  /*Works table*/
  $("#works_table").handsontable({
    startCols: 3,
    startRows: 3,
    minSpareRows: 1,
    colHeaders: ["Date", "Description", ""],
    colWidths: [50, 500],
    columns: [{type: 'date'}, {}],
    contextMenu: true,
    onChange: function(update, source){
      if(source != "alter"){ // there's no changes on columns, no need to flag 1
        var row = update[0][0];
        var data = $("#works_table").handsontable("getData")[row];
        var url = "<?php echo $url.'/staffs/update_work'; ?>";
        $.post(url, {
          id: data[2],
          date: data[0],
          description: data[1]
        }, function(data){
          console.log(data);
        });
      }
      
      // delete row ajax
      if(source == "alter"){
        var id = deleted_data[2];
        var url = "<?php echo $url.'/work_histories/ajax_delete/'; ?>"+id;
        $.get(url, function(data){
          console.log(data);
        });
      }
    }
  });
  
  /* Eductions */
  $("#edu_table").handsontable({
    startCols: 4,
    startRows: 3,
    minSpareRows: 1,
    colHeaders: ["Date", "Gelar", "Nama", ""],
    colWidths: [50, 300, 200],
    columns: [{type: 'numeric'}, {}, {}],
    contextMenu: true,
    onChange: function(update, source){
      if(source != "alter"){ // there's no changes on columns, no need to flag 1
        var row = update[0][0];
        var data = $("#edu_table").handsontable("getData")[row];
        var url = "<?php echo $url.'/staffs/update_edu'; ?>";
        $.post(url, {
          id: data[3],
          date: data[0],
          gelar: data[1],
          name: data[2]
        }, function(data){
          console.log(data);
        });
      }
      
      // delete row ajax
      if(source == "alter"){
        var id = deleted_data[3];
        var url = "<?php echo $url.'/educations/ajax_delete/'; ?>"+id;
        $.get(url, function(data){
          console.log(data);
        });
      }
    }
  });
  
  /*Salaries*/
  $("#salary_component_a").handsontable({
    contextMenu: true,
    startCols: 6,
    startRows: 3,
    minSpareRows: 1,
    colHeaders: ["Component", "Type", "Daily value (Rp)", "Monthly value (Rp)", "", ""], // ID, FLAG, COMPONENT ID
    colWidths: [150, 80, 100, 120],
    columns: [
      {
        type: 'autocomplete',
        source: function(req, process){
          var url = "<?php echo $url.'components/get_components'; ?>"
          $.getJSON(url, function(data){
            var items = [];
            $.each(data, function(i, v){
              items.push(v.comp_name);
            });
            process(items);
          });
        }
      },
      {readOnly: true},
      {type: "numeric", format: "0,0.00"},
      {type: "numeric", format: "0,0.00"}
    ],
    onChange: function(update, source){
      if(source=="edit" && update[0][1]==0){
        var url = "<?php echo $url.'components/get_where_component'; ?>/"+update[0][3];
        $.getJSON(url, function(data){
          $("#salary_component_a").handsontable("setDataAtCell", update[0][0], 1, data.comp_type);
          $("#salary_component_a").handsontable("setDataAtCell", update[0][0], 5, data.id);
          if(data.comp_type.toLowerCase() != "daily"){
            $("#salary_component_a").handsontable("setDataAtCell", update[0][0], 2, "0");
          }else{
            $("#salary_component_a").handsontable("setDataAtCell", update[0][0], 3, "0");
          }
        });
      }
      if(source != "alter"){
        var row = update[0][0];
        var data = $("#salary_component_a").handsontable("getData")[row];
        var url = "<?php echo $url.'/staffs/update_component_a'; ?>";
        $.post(url, {
          id: data[4],
          comp_id: data[5],
          daily: data[2],
          amount: data[3],
        }, function(data){
          console.log(data);
        });
      }
    },
    onBeforeChange: function(update){
      if(update[0][1] == 2){
        var type = $("#salary_component_a").handsontable("getDataAtCell", update[0][0], 1);
        if(type.toLowerCase() != "daily"){
          update[0][3] = 0;
        }else{
          return true;
        }
      }
    }
  });
  
  $("#salary_component_b").handsontable({
    contextMenu: true,
    startCols: 6,
    startRows: 3,
    minSpareRows: 1,
    colHeaders: ["Component", "Type", "Daily value", "Monthly value", "", ""], // ID, COMPONENT ID
    colWidths: [150, 80, 100, 120],
    columns: [
      {
        type: 'autocomplete',
        source: function(req, process){
          var url = "<?php echo $url.'components/get_components'; ?>"
          $.getJSON(url, function(data){
            var items = [];
            $.each(data, function(i, v){
              items.push(v.comp_name);
            });
            process(items);
          });
        }
      },
      {readOnly: true},
      {type: "numeric", format: "0,0.00"},
      {type: "numeric", format: "0,0.00"}
    ],
    onChange: function(update, source){
      if(source=="edit" && update[0][1]==0){
        var url = "<?php echo $url.'components/get_where_component'; ?>/"+update[0][3];
        $.getJSON(url, function(data){
          $("#salary_component_b").handsontable("setDataAtCell", update[0][0], 1, data.comp_type);
          $("#salary_component_b").handsontable("setDataAtCell", update[0][0], 5, data.id);
          if(data.comp_type.toLowerCase() != "daily"){
            $("#salary_component_b").handsontable("setDataAtCell", update[0][0], 2, "0");
          }else{
            $("#salary_component_b").handsontable("setDataAtCell", update[0][0], 3, "0");
          }
        });
      }
      if(source != "alter"){
        var row = update[0][0];
        var data = $("#salary_component_b").handsontable("getData")[row];
        var url = "<?php echo $url.'/staffs/update_component_b'; ?>";
        $.post(url, {
          id: data[4],
          comp_id: data[5],
          daily: data[2],
          amount: data[3],
        }, function(data){
          console.log(data);
        });
      }
    },
    onBeforeChange: function(update){
      if(update[0][1] == 2){
        var type = $("#salary_component_b").handsontable("getDataAtCell", update[0][0], 1); // get type
        if(type.toLowerCase() != "daily"){
          update[0][3] = 0;
        }else{
          return true;
        }
      }
    }
  });
  
  $("form").on("submit", function(e){
    e.preventDefault();
    var form = this;
    // get data from families tab
    getFamilies();
    // get data from medics tab
    getMedics();
    // get works
    getWorks();
    // get Education
    getEdu();
    // get component A
    getComponentsA();
    // get component B
    getComponentsB();
    // submit the form
    form.submit();
  });
});


  
function getFamilies(){
  var $instance = $("#family_table");
  var data = $instance.handsontable('getData');
  var row_length = data.length;
  var families = "";
  for(i=0; i<row_length; i++){
    if(data[i][0]!=null && 
    data[i][1]!=null && 
    data[i][2]!=null && 
    data[i][3]!=null && 
    data[i][4]!=null){
      families += '<input type="hidden" name="families[]" value="'+data[i][0]+';'+data[i][1]+';'+data[i][2]+';'+data[i][3]+';'+data[i][4]+';'+data[i][5]+'">'; 
    }else{
      errors++;
    }
  }
  $("#families_hidden").html(families);
}

function getMedics(){
  var $instance = $("#medic_table");
  var data = $instance.handsontable('getData');
  var row_length = data.length;
  var medics = "";
  for(i=0; i<row_length; i++){
    if(data[i][0] != null && data[i][1] != null){
      medics += '<input type="hidden" name="medics[]" value="'+data[i][0]+';'+data[i][1]+';'+data[i][2]+';'+data[i][3]+'">';
    }else{
      errors++;
    }
  }
  $("#medics_hidden").html(medics);
}

function getWorks(){
  var $instance = $("#works_table");
  var data = $instance.handsontable('getData');
  var row_length = data.length;
  var medics = "";
  for(i=0; i<row_length; i++){
    if(data[i][0] != null && data[i][1] != null){
      medics += '<input type="hidden" name="works[]" value="'+data[i][0]+';'+data[i][1]+';'+data[i][2]+';'+data[i][3]+'">';
    }else{
      errors++;
    }
  }
  $("#works_hidden").html(medics);
}

function getEdu(){
  var $instance = $("#edu_table");
  var data = $instance.handsontable('getData');
  var row_length = data.length;
  var edu = "";
  for(i=0; i<row_length; i++){
    if(data[i][0] != null && data[i][1] != null && data[i][2] != null){
      edu += '<input type="hidden" name="edu[]" value="'+data[i][0]+';'+data[i][1]+';'+data[i][2]+';'+data[i][3]+'">';
    }else{
      errors++;
    }
  }
  $("#edu_hidden").html(edu);
}

function getComponentsA(){
  var $instance = $("#salary_component_a");
  var data = $instance.handsontable('getData');
  var row_length = data.length;
  var comp_a = "";
  for(i=0; i<row_length; i++){
    if(data[i][5] != null && data[i][2] != null && data[i][3] != null){ // save only ID, daily, monthly
      comp_a += '<input type="hidden" name="comp_a[]" value="'+data[i][5]+';'+data[i][2]+';'+data[i][3]+';'+data[i][4]+'">';
    }else{
      errors++;
    }
  }
  $("#salary_comp_a").html(comp_a);
}

function getComponentsB(){
  var $instance = $("#salary_component_b");
  var data = $instance.handsontable('getData');
  var row_length = data.length;
  var comp_b = "";
  console.log(data);
  for(i=0; i<row_length; i++){
    if(data[i][5] != null && data[i][2] != null && data[i][3] != null){ // save only ID, daily, monthly
      comp_b += '<input type="hidden" name="comp_b[]" value="'+data[i][5]+';'+data[i][2]+';'+data[i][3]+';'+data[i][4]+'">';
    }else{
      errors++;
    }
  }
  $("#salary_comp_b").html(comp_b);
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
        $('#preview').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
