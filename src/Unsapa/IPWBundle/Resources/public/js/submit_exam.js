function get_record_data()
{
  if($("#exam_submit_warn"))
  {
    $("#exam_submit_warn").hide();
  }
  $.ajax(
      "../record/" + $('#form_exam').val(), {
      dataType: "json",
      success: function(data, textStatus, jqXHR)
      {
        if(data.document)
        {
          $('#form_exam').after( 
            "<span class=\"warn\" id=\"exam_submit_warn\"><br>" +
              "Vous avez déjà soumis un document pour cet examen : " + 
              "<a alt=\"Télécharger le document\" href=\"../download/" + data.student + "/" + data.exam + "\">Télécharger</a>" +
            "</span>"
          );
        }
      }
  });
}

$('#form_exam').change(get_record_data);
$('#form_exam').ready(get_record_data);
