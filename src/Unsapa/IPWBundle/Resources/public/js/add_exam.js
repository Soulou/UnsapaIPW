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
        }
    });
}

$(function() {
    $("#exam_exam_date").datepicker({ dateFormat: "dd/mm/yy" });
    $("#promo_detail_dialog").dialog({ title: "Étudiants concernés", autoOpen: false });
    $("#promo_detail").click(
      function()
      {
          load_data();
          $("#promo_detail_dialog").dialog('open');
      }
    );

    $("#exam_promo").change(
      function()
      {
          $("#promo_detail_dialog").dialog('close');
      }
    );

    $("#exam_add").submit(
      function(e)
      {
        $("#promo_detail_dialog").dialog('close');
        $(".ckb_user").hide();
        $(":checkbox:checked").prependTo($("#exam_add"));
      }
    );
});
