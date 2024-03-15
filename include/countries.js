//Fungsi jquery untuk Country option pada signup page

$(function () {
  var countryOptions
  $.getJSON("countries.json", function (result) {
    $.each(result, function (i, country) {
      countryOptions +=
        "<option value='" + country.name + "'>" + country.name + "</option>"
    })
    $("#country").html(countryOptions)
  })
})
