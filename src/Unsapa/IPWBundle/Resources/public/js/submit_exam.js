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
            "<span class=\"warn\" id=\"exam_submit_warn\">" +
              "<img alt=\"Warning\" src=\"../../bundles/unsapaipw/images/warning.png\" width=\"35\"/>" +
              "Vous avez déjà soumis un document pour cet examen : " + 
              "<a alt=\"Télécharger le document\" href=\"../download/" + data.student + "/" + data.exam + "\">Télécharger</a>" +
              "<br>Il sera écrasé si vous choisissez un nouveau fichier."+ 
            "</span>"
          );
        }
      }
  });
}

$('#form_exam').change(get_record_data);
$('#form_exam').ready(get_record_data);
