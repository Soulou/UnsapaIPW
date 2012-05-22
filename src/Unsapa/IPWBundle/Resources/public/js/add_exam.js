function load_data()
{
    $('#promo_detail_dialog').html("");
    $.ajax(
        "add/students", {
        dataType: "json",
        type: "POST",
        data: { 'promo' : $('#exam_promo').val() },
        success: function(data, textStatus, jqXHR)
        {
            for(var i in data)
            {
              $('#promo_detail_dialog').append("<span class=\"ckb_user\">" +
                "<input type=\"checkbox\" name=\"user" + data[i].id + "\"" + 
                       "value=\"" + data[i].id + "\"checked/>" + 
                       data[i].firstname + " " + data[i].lastname + "<br></span>"
              
              );
            }
            $('#promo_detail_dialog').append("<button id=\"close_detail_dialog\">Fermer</button>");
            $('#close_detail_dialog').click(function()
            {
                $('#promo_detail_dialog').dialog("close");
            });
        }
    });
}

var promo = "";
var newpromo = "";
$(function() {
    var min_date = new Date();
    min_date.setDate(min_date.getDate()+1);
    $("#promo_detail_dialog").dialog({ title: "Étudiants concernés", autoOpen: false });
    $("#exam_exam_date").datepicker({ 
      dateFormat: "dd/mm/yy" ,
      minDate: min_date
    });
    $("#promo_detail").click(
      function()
      {
          if($('#promo_detail_dialog').html() != "")
          {
              $('select option:selected').each(function() {
                newpromo = $(this).text();
              });
              
              if(newpromo != promo)
              {
                  promo = newpromo;
                  load_data();
              }
          }
          else
          {
              $('select option:selected').each(function() {
                promo = $(this).text();
              });
              load_data();
          }
          $("#promo_detail_dialog").dialog('open');
      }
    );

    $("#exam_promo").change(
      function()
      {
          $("#promo_detail_dialog").dialog('close');
      }
    );

    $("#exam_add_form").submit(
      function(e)
      {
        $("#promo_detail_dialog").dialog('close');

        $(":checkbox:checked").each(function()
          {
            $(this)[0].setAttribute("style", "display:none");
          });
        $(":checkbox:checked").prependTo($("#exam_add_form"));
      }
    );
});
