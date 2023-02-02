
function prikazi() {
    var x = document.getElementById("pregled");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  } 


$('#btn-izbrisi').click( function(){
  const checked = $('button[id=btn-izmeni]:selected');
  request = $.ajax({
    url:'crud/delete.php',
    type: 'post',
    data: {'id': checked.val()}
  });
  request.done(function (response, textStatus, jqXHR) {
    if (response === 'Success') {
      checked.closest("tr").remove();
        console.log('Pregled je obrisan ');
        alert('Pregled je obrisan');
        //$('#izmeniForm').reset;
    }
    else {
      console.log('Pregled nije obrisan ' + response);
      alert('Pregled nije obrisan');
    }
});
});

$('#btn-izmeni').click(function () {

  const checked = $('input[name=checked-donut]:checked');

  request = $.ajax({
      url: 'crud/get.php',
      type: 'post',
      data: {'id': checked.val()},
      dataType: 'json'
  });

  request.done(function (response, textStatus, jqXHR) {
      console.log('Popunjena');
      $('#idzubar').val(response[0]['zubar']);
      console.log(response[0]['zubar']);

      $('#idgrad').val(response[0]['grad'].trim());
      console.log(response[0]['grad'].trim());

      $('#idkategorija').val(response[0]['kategorija'].trim());
      console.log(response[0]['kategorija'].trim());

      $('#iddatum').val(response[0]['datum'].trim());
      console.log(response[0]['datum'].trim());

      $('#idid').val(checked.val());

      console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
      console.error('The following error occurred: ' + textStatus, errorThrown);
  });

});

$('#izmeniForm').submit(function () {
  event.preventDefault();
  console.log("Izmena");
  const $form = $(this);
  const $inputs = $form.find('input, select, button');
  const serializedData = $form.serialize();
  console.log(serializedData);
  $inputs.prop('disabled', true);

  request = $.ajax({
      url: 'crud/update.php',
      type: 'post',
      data: serializedData
  });

  request.done(function (response, textStatus, jqXHR) {


      if (response === 'Success') {
          console.log('Pregled je izmenjen');
          location.reload(true);
          //$('#izmeniForm').reset;
      }
      else console.log('Pregled nije izmenjen ' + response);
      console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
      console.error('The following error occurred: ' + textStatus, errorThrown);
  });


  
});
 
$('#btnDodaj').submit(function(){
    $('myModal').modal('toggle');
    return false;
});

$('#btn-izmeni').submit(function () {
   
    $('#myModal').modal('toggle');
    return false;
});

$('#dodajForm').submit(function () {
    event.preventDefault();
  
    const $form = $(this);
    const $inputs = $form.find('input, select, button');
    const serializedData = $form.serialize();
    console.log(serializedData);
    let obj = $form.serializeArray().reduce(function (json, { name, value }) {
    json[name] = value;
    return json;
    }, {});
    console.log(obj);
    $inputs.prop("disabled", true);

    request = $.ajax({
        url: 'crud/add.php',
        type: 'post',
        data: serializedData
    });

    request.done(function (response, textStatus, jqXHR) {
        if (response === 'Success') {
            alert('Pregled je dodat');
            appandRow(obj);
        }
        else console.log('Pregled nije dodat ' + response);
        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });
});


function appandRow(obj) {
  console.log(obj);

  $.get("crud/getLastElement.php", function (data) {
    console.log(data);
    console.log($("#tabela tbody tr:last").get());
    $("#tabela tbody").append(`
      <tr>
          <td>${data}</td>
          <td>${obj.zubar}</td>
          <td>${obj.grad}</td>
          <td>${obj.kategorija}</td>
          <td>${obj.datum}</td>
          <td>
              <label class="custom-radio-btn">
                  <input type="radio" name="checked-donut" value=${data}>
                  <span class="checkmark"></span>
              </label>
          </td>
      </tr>
    `);
  });
}
